<?php
//CHECK LOGIN
session_start(); // Khởi tạo session
if (!isset($_SESSION['account'])) { // Kiểm tra nếu người dùng chưa đăng nhập
    header("Location: /register"); // Chuyển hướng đến trang đăng ký
    exit(); // Dừng thực thi mã tiếp theo
}

include_once 'head.php';

// Lấy địa chỉ IP từ cơ sở dữ liệu
$ip_address = '';
if (isset($_username)) {
    // Truy vấn lấy địa chỉ IP từ bảng account
    $query = "SELECT ip_address FROM account WHERE username = ?";
    
    // Chuẩn bị câu truy vấn
    if ($stmt = $conn->prepare($query)) {
        // Bind giá trị của $_username vào câu truy vấn
        $stmt->bind_param("s", $_username);
        
        // Thực thi câu truy vấn
        $stmt->execute();
        
        // Lấy kết quả
        $stmt->bind_result($ip_address);
        if ($stmt->fetch()) {
            // Địa chỉ IP đã được gán vào biến $ip_address
        }
        
        // Đóng câu truy vấn
        $stmt->close();
    }
}
?>

<head>
    <title>Tài khoản - <?php echo $sv_code ?></title>
    <style>
    body {
        background: none;
    }

    .container-custom {
        font-family: Arial, sans-serif;
        font-size: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 2px solid red;
        padding: 20px;
        width: 80%;
        margin: 0 auto;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 10px;
    }

    .info-row span:first-child {
        font-weight: bold;
        color: #333;
    }

    .text-danger {
        color: red;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <main class="flex-grow-1 flex-shrink-1">
        <div class="container-fluid">
            <main>
                <div class="menu row">
                    <div class="col-md-3 pb-3 pt-2">
                        <div class="list-group d-sm-block">
                            <?php include_once 'menu.php'; ?>
                        </div>
                    </div>
                    <div class="col-md-9 pb-3 pt-2">
                        <div class="container-custom">
                            <!-- Hiển thị thông tin tài khoản -->
                            <div class="info-row">
                                <span>TÀI KHOẢN:</span>
                                <span style="color: red;"><?php echo $_username; ?></span>
                            </div>

                            <div class="info-row">
                                <span>TRẠNG THÁI:</span>
                                <span style="font-size: 16px;">
                                    <?php 
                                        switch ($_status) {
                                            case "0":
                                                echo 'Chưa kích hoạt';
                                                break;
                                            case "-1":
                                                echo 'Đang bị khoá';
                                                break;
                                            case "1":
                                                echo 'Đã kích hoạt';
                                                break;
                                        }
                                    ?>
                                </span>
                            </div>

                            

                            <div class="info-row">
                                <span>VND:</span>
                                <span class="text-danger"><?php echo number_format($_vnd); ?></span>
                            </div>

                            <div class="info-row">
                                <span>TỔNG NẠP:</span>
                                <span class="text-danger"><?php echo number_format($_tvnd); ?></span>
                            </div>

                            <div class="info-row">
                                <span>ĐỊA CHỈ IP:</span>
                                <span style="font-size: 16px;"><?php echo $ip_address; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </main>
</body>