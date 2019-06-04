<?php
include "../Common/Helps.php";
include "../Config/config.php";

$merchant_id = $_GET['merchant_id'];
$porder = $_GET['porder'];
$orderid = $_GET['orderid'];
$money = $_GET['money'];
$status = $_GET['status'];
$sign = $_GET['sign'];

$helps = new \Common\Helps();
$filename = $orderid . date("YmdHis", time());
$filedata = "订单号：" . $orderid . "\r\n订单状态" . $status;
$helps->myfwrite($filename, $filedata);

$key = $config['key']; // 商户秘钥

$mysign = md5($merchant_id . $orderid . $money . $key);
if ($sign == $mysign) {
    echo 'SUCCESS';
} else {
    echo 'SIGNERR';
}
?>
