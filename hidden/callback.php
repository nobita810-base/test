<?php
include_once 'set.php';

$cb = fopen('../logs/callback.log', 'a') or die("cant open file");

$validate = ValidateCallback($_POST);
if ($validate != false) { // Nếu xác thực callback đúng thì chạy vào đây.
    // Kiểm tra và ghi log thông tin nhận được
    $status = $validate['status']; // Trạng thái thẻ nạp
    $serial = $validate['serial']; // Số serial của thẻ.
    $pin = $validate['code']; // Mã pin của thẻ.
    $amount = $validate['amount']; // Mệnh giá của thẻ
    $declared = $validate['declared_value'] * 1; // Mệnh giá được khai báo
    $content = $validate['trans_id']; // ID transaction 
    $sign = hash('sha256', $partnerKey . $pin . $serial); // Dùng SHA256 thay MD5 cho bảo mật cao hơn

    // Kiểm tra chữ ký
    if ($sign != $validate['callback_sign']) { 
        fwrite($cb, "trans_id: " . $content . ", Sai chữ ký|");
        die('Sai chữ ký');
    } else {
        fwrite($cb, "trans_id: " . $content . ", Chữ ký đúng|");
    }

    // Kiểm tra callback từ database
    $query_str = "SELECT * FROM `naptien` WHERE tinhtrang = '0' AND tranid = '{$content}' AND code = '{$pin}' AND seri = '{$serial}'";
    fwrite($cb, "query: " . $query_str . "|");
    $result = _query($query_str);

    // Nếu không có kết quả, không cần truy vấn lại
    if ($result->num_rows <= 0) {
        fwrite($cb, "trans_id: " . $content . ", Không tìm thấy giao dịch|");
        die('Không tìm thấy giao dịch');
    }

    $result = $result->fetch_array(MYSQLI_ASSOC);

    // Kiểm tra trạng thái thẻ nạp
    fwrite($cb, "status: " . $status . "\n\n");
    if ($status == '1') {
        // Xử lý nạp thẻ thành công tại đây.
        // Kiểm tra giá trị declared_value hợp lệ
        if ($declared <= 0) {
            fwrite($cb, "trans_id: " . $content . ", Mệnh giá không hợp lệ|");
            die('Mệnh giá không hợp lệ');
        }

        // Nhân đôi số tiền nạp vào
        $doubleAmount = $declared * 2; // Nhân đôi số tiền nạp

        // Cập nhật số dư tài khoản người dùng
        _query("UPDATE `account` SET vnd = vnd + {$doubleAmount}, tongnap = tongnap + {$doubleAmount} WHERE username = '{$result['uid']}'");

        // Cập nhật trạng thái giao dịch thành công
        _query("UPDATE `naptien` SET `tinhtrang` = 1 WHERE `id` = {$result['id']}"); // chuyển cho kết quả thành công  
        fwrite($cb, "trans_id: " . $content . ", Nạp thẻ thành công|");
    } else if ($status == '2') {
        // Xử lý nạp thẻ sai mệnh giá tại đây.
        _query("UPDATE `naptien` SET `tinhtrang` = 2, `sotien` = {$amount} WHERE `id` = {$result['id']}"); // thất bại   
        fwrite($cb, "trans_id: " . $content . ", Nạp thẻ sai mệnh giá|");
    } else {
        // Xử lý nạp thẻ thất bại tại đây.
        _query("UPDATE `naptien` SET `tinhtrang` = 3 WHERE `id` = {$result['id']}"); // thất bại   
        fwrite($cb, "trans_id: " . $content . ", Nạp thẻ thất bại|");
    }
} else {
    fwrite($cb, "validate: false\n");
}

fclose($cb);

// Hàm kiểm tra callback từ server
function ValidateCallback($out)
{ 
    $jsonData = file_get_contents('php://input');
    $jsonArray = json_decode($jsonData, true);

    // Kiểm tra tất cả các tham số cần thiết
    if (isset(
        $jsonArray['status'],
        $jsonArray['message'],
        $jsonArray['request_id'],
        $jsonArray['declared_value'],
        $jsonArray['value'],
        $jsonArray['amount'],
        $jsonArray['code'],
        $jsonArray['serial'],
        $jsonArray['telco'],
        $jsonArray['trans_id'],
        $jsonArray['callback_sign']
    )) {
        return $jsonArray; // Xác thực thành công
    } else {
        return false; // Xác thực callback thất bại
    }
}
?>
