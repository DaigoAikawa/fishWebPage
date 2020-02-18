<?php
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'setting.php';

// PHPMailerのインスタンス生成
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP(); // SMTPを使うようにメーラーを設定する
    $mail->SMTPAuth = true;
    $mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
    $mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
    $mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
    $mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
    $mail->Port = SMTP_PORT; // 接続するTCPポート

    // メール内容設定
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";
    $mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
    $mail->addAddress($_GET['email'], $_GET['id']."様"); //受信者（送信先）を追加する
//    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');
//    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加
//    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加
    $name = $_GET['id']."様";
    $mail->Subject = MAIL_SUBJECT; // メールタイトル
    $mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
    $body = 'この度は魚編どっとこむへご登録いただきありがとうございます．<br>'.$name."の登録が完了いたしましたのでご確認ください<br><br>ID:".$_GET['id']."<br>メールアドレス:".$_GET['email']."<br><br>このメールに心当たりのない方や，ご不明点がございましたら，daigo.aikawa.techbase@gmail.com までご連絡ください．<br>魚編どっとこむ事務局";

    $mail->Body  = $body; // メール本文
    $mail->send(); // メール送信の実行
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>登録完了（魚編どっとこむ）</title>
	<style>
		body {
			background-color: #FFFFC9;
			margin: 20px;	/* bodyの外側の余白を指定する */
			padding: 50px 10px 50px 10px;	/* bodyの内側余白を指定する(上:右:下:左) */
		}
		.header {
			height: 47px;
			width: 100%;
			box-shadow: 0 0 10px #dddddd;
			background-color: #000066;
			position: fixed;
			top: 0px;
			left: 0px;
		}
		.header-left a {
			float: left;
			color: #ffffff;
			background-color: #000066;
			padding-left: 10px;
			margin-top: 10px;
			margin-left: 10px;
			font-size: 20px;
		}
		.header-right a {
			float: right;
			color: #ffffff;
			background-color: #000066;
			padding-right: 10px;
			margin-top: 7px;
			margin-left: 10px;
			font-size: 20px;
		}
</style>
</head>

<body>
	<div class="header">
			<div class="header-left">
				<a href="/index.php">TOP</a>
				<a href="/zukan.php">お魚図鑑</a>
			</div>
			<div class="header-right">
				<?php
					if (isset($_SESSION['id']) || !empty($_SESSION['id'])) {
						echo("<a href='/logout.php'>ログアウト</a>");
						echo("<a href='/favorite.php'>お気に入りリスト</a>");
					}
				?>
				<?php
					if (isset($_SESSION['id']) || !empty($_SESSION['id'])) {
						echo("<a>ようこそ " . $_SESSION['id'] . " さん</a>");
					} else {
						echo("<a href='/login.php'>ログイン</a>");
					}
				?>
			</div>
			<div class="clear"></div>
		</div>
	<center><h1>登録が完了しました</h1>
		ID : <?php echo($_GET['id']) ?> 様の登録が完了しました．<br>
		<?php echo($_GET['email']) ?> へ完了メールを送信いたしましたのでご確認ください．<br>
		<br>
		<a href="/index.php">TOPへ戻る</a>
	</center>
</body>
</html>