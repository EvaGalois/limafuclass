<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
header('Content-Type:text/html;charset=utf8');
date_default_timezone_set('Asia/Shanghai');
include '../Config/config.php';
include "../Common/Helps.php";

$key = $config['key'];
if (@isset($_POST['submit'])) {

    $key = $config['key'];

    $url = "http://api.ponypay1.com/getbalance.aspx";
    $param = "merchant_id=" . $merchant_id;
    $helps = new \Common\Helps();
    $result = $helps->getcurl($url, $param);
    if ($result->status == 1) {
        print_r($result->data);
    } else {
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
        <form action="" method="post" name="form" target="_blank">
            <table>
                <tr>
                    <td>商户号：</td>
                    <td>
                        <input type="text" id="text" name="key" value="<?php echo $key;?>">
                    </td>
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
    </body>
    </html>
<?php } ?>