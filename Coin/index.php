﻿<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
header('Content-Type:text/html;charset=utf8');
date_default_timezone_set('Asia/Shanghai');
include '../Config/config.php';
include "../Common/Helps.php";

if (@isset($_POST['submit'])) {

    $userip = $_SERVER['REMOTE_ADDR'];
    $merchant_id = $config['merchant_id'];
    $orderid = time() . mt_rand(1000000000, 9999999999);
    $money = number_format($_POST['money'], 2, '.', '');
    if ($money > 50000 || $money < 100) {
        die('充值金额需大于100元小于50000元');
    }
    $paytype = $_POST['paytype'];
    $notifyurl = 'http://' . $_SERVER['HTTP_HOST'] . '/Coin/notify.php';
    $callbackurl = 'http://' . $_SERVER['HTTP_HOST'] . '/Coin/return.php';
    $key = $config['key'];

    $data = $merchant_id . $orderid . $paytype . $notifyurl . $callbackurl . $money . $key;

    $sign = md5($data);

    $url="http://api.ponypay1.com/";
    $param="merchant_id=".$merchant_id."&orderid=".$orderid."&paytype=".$paytype."&notifyurl=".$notifyurl."&callbackurl=".$callbackurl."&userip=".$userip."&money=".$money."&sign=".$sign;
    $helps=new \Common\Helps();
    $result=$helps->getcurl($url,$param);
    if ($result->status==1){
        header("location:".$result->data->url);
    }else{
        die($result->meddsge);
    }
} else {
    ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf8">
        <title>立马付</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            html, body, div, p, span, ul, dl, ol, h1, h2, h3, h4, h5, h6, table, td, tr {
                padding: 0;
                margin: 0
            }

            .content {
                width: 400px;
                margin: 100px auto;
                border: 1px solid #ddd
            }

            h1 {
                margin-bottom: 30px;
                background-color: #eee;;
                border-bottom: 1px solid #ddd;
                padding: 10px;
                text-align: center
            }

            table {
                border-collapse: collapse;
                width: 90%;
                margin: 20px auto
            }

            table tr td {
                height: 40px;
                font-size: 14px
            }

            input, select {
                width: 100%;
                line-height: 25px
            }

            button {
                font-size: 16px
            }
        </style>
    </head>
    <body>
    <div class="content">
        <h1>立马付</h1>
        <span><a href="index.php">金额输入框页</a></span>
        <span><a href="pay.php">金额下拉框页</a></span>
        <form action="" method="post" name="form" target="_blank">
            <table>
                <tr>
                    <td>订单金额：</td>
                    <td>
                        <input type="text" id="text" name="money" placeholder="100-50000">
                    </td>
                </tr>
                <tr>
                    <td>支付编号：</td>
                    <td>
                        <select name="paytype" onChange="changePay(this.options[this.selectedIndex].value)">
                            <option value="ZFB">支付宝扫码</option>
                            <option value="ZFBH5">支付宝wap</option>
                            <option value="WX">微信扫码</option>
                            <option value="WXH5">微信wap</option>
                            <option value="YSF">云闪付</option>
                            <option value="YLHET">银联扫码</option>
                            <option value="TLNETH5">银联扫码wap</option>
                            <option value="NETGATE">网银支付</option>
                            <option value="QQ">QQ扫码</option>
                            <option value="QQH5">QQ扫码wap</option>
                            <option value="BAIDU">百度钱包</option>
                            <option value="BAIDUH5">百度钱包wap</option>
                            <option value="JD">京东支付</option>
                            <option value="JDH5">京东支付wap</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <!--<td>订单备注：</td>-->
                    <td><input type="hidden" name="remark" value="金额输入框页的测试"></td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <button type="submit" name="submit">提交</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script>
        var text = document.getElementById("text");
        text.onblur = function () {
            this.value = this.value.replace(/\D/g, '');
            if (text.value < 100) {
                text.value = 100;
            }
            if (text.value > 50000) {
                text.value = 50000;
            }
        }
    </script>
    </body>
    </html>
<?php } ?>