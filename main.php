<?php
// RAM16GBの整備済みMac Book Proが追加されたらメールを送信するスクリプト

require_once("lib/phpQuery-onefile.php");
require_once("lib/PHPMailer.php");
require_once("lib/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// 整備済み製品ページから情報を取得
$url = 'https://www.apple.com/jp/shop/browse/home/specialdeals/mac/macbook_pro/13';
$html = file_get_contents($url);
$dom = phpQuery::newDocument($html);
$text = $dom->text();

// もしRAM16GBモデルのMBPがあれば$flag = 1
if(strpos($text, '16GB 2,133MHz LPDDR3') !== false) {
  $body = "16GBモデルのMBPがあります。\n$url";
} else {
  $body = "16GBモデルのMBPがありません。\n$url";
}

// メール作成
$subject = "sendmail-16mbp";
$fromname = "";
$from = "";
$smtp_user = "";
$smtp_password = "";

$to = "";

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->CharSet = 'utf-8';
$mail->SMTPSecure = 'tls';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->IsHTML(false);
$mail->Username = $smtp_user;
$mail->Password = $smtp_password;
$mail->SetFrom($smtp_user);
$mail->From     = $from;
$mail->Subject = $subject;
$mail->Body = $body;
$mail->AddAddress($to);

// メール送信
if( !$mail -> Send() ){
    $message  = "Message was not sent<br/ >";
    $message .= "Mailer Error: " . $mailer->ErrorInfo;
} else {
    $message  = "Message has been sent";
}

echo $message;

?>
