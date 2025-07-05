<?php
include_once 'set.php';

$cb = fopen('../logs/bank-hook.log', 'a') or die("cant open file");

$webhookData = json_decode(file_get_contents('php://input'), true);
$header = getallheaders();

if (isset($header['signature']) && $header['signature'] === $bank_signature) {

    $data = $webhookData['transactions'];

    foreach ($data as $transaction) {
        $type = $transaction['type'];

        if ($type != 'IN') {
            continue;
        }

        try {
            $description = strtolower($transaction['description']);
            $description = str_replace("  ", " ", $description);
            $amount = $transaction['amount'] * 1;
            $transactionID = $transaction['transactionID'];

            fwrite($cb, $description . "\n\n");

            reCheck($description, $amount, $cb);
        } catch (Exception $e) {
            fwrite($cb, $e->getMessage() . "\n\n");
        }
    }
}

fclose($cb);
return http_response_code(200);

function reCheck($description, $sotien, $handle)
{
    $pattern = '/notbuff\s([A-Za-z0-9]+)\s([A-Za-z0-9]{6})/i';
    $match = array();
    if (preg_match($pattern, $description, $match)) {
        $username = $match[1];
        $tranid = $match[2];

        fwrite($handle, $username . "\n\n");
        fwrite($handle, $tranid . "\n\n");
    } else {
        return;
    }

    $query = "SELECT * FROM `naptien` WHERE type='BANK' AND uid='$username' AND sotien='$sotien' AND noidung='$tranid' AND tinhtrang='0'";
    fwrite($handle, $query . "\n\n");
    $result = _query($query);
    if ($result->num_rows == 0) {
        return;
    }

    fwrite($handle, "Here\n\n");
    
    // Nhân đôi số tiền
    $sotienX2 = $sotien * 1;

    $query = "UPDATE `account` SET vnd = vnd + {$sotienX2}, tongnap = tongnap + {$sotienX2} WHERE username = '{$username}'";
    _query($query);

    $query = "UPDATE `naptien` SET `tinhtrang`='1' WHERE type='BANK' AND uid='$username' AND sotien='$sotien' AND noidung='$tranid' AND tinhtrang='0'";
    fwrite($handle, $query . "\n\n");
    _query($query);
}
