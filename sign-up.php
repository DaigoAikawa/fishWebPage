<?php // db connection
	$dsn = "mysql:dbname=tb210109db;host=localhost"; //サーバ情報
	$dbuser = "tb-210109";
	$dbpass = "TaWzkCf5gc";
	$pdo = new PDO($dsn, $dbuser, $dbpass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<?php
$flag = 0;
$idmessage = "";
$passmessage = "";
$emailmessage = "";
if(isset($_POST['flag']) || !empty($_POST['flag'])){
	$flag = $_POST['flag'];
} else {
	$flag = FALSE;
}
if ($flag) {
	if ($_POST['id'] != "") {
		if ($_POST['pass'] != "") {
			if ($_POST['email'] != "") {
				$id = $_POST['id'];
				$sql = "select id from users_tbl";
				$stmt = $pdo->query($sql);
				$resultset = $stmt->fetchAll(PDO::FETCH_NUM);
				//var_dump($resultset);
				$isUnique = 1;
				foreach ($resultset as $value) {
					if ($id == $value[0]) {
						$isUnique = 0;
						break;
					}
				}
				if ($isUnique) {
					$pass = hash('sha256', $_POST['pass']);
					$email = $_POST['email'];
					$sql = $pdo->prepare("insert into users_tbl (id,password,mail) values (:id,:password,:mail)");
					$sql->bindParam(':id', $id, PDO::PARAM_STR);
					$sql->bindParam(':password', $pass, PDO::PARAM_STR);
					$sql->bindParam(':mail', $email, PDO::PARAM_STR);
					$sql->execute();



					http_response_code(301);
					header("Location: /complete.php?id=" . $id . "&email=" . $email);
					exit();
				} else {$idmessage = "このIDはすでに使われています";}
			} else {$emailmessage = "メールアドレスを記入してください";}
		} else {$passmessage = "パスワードを記入してください";}
	} else {$idmessage = "IDを半角英数30文字以下，もしくは全角１５文字以下で記入してください";}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" >
    <title>会員登録</title>
    <link rel="stylesheet" href="common.css">
</head>
<body>
	<div class="header">
			<div class="header-left">
				<a href="./index.php">TOP</a>
				<a href="./zukan.php">お魚図鑑</a>
			</div>
			<div class="header-right">
				<?php
					if (isset($_SESSION['id']) || !empty($_SESSION['id'])) {
						echo("<a href='logout.php'>ログアウト</a>");
						echo("<a href='favorite.php'>お気に入りリスト</a>");
					}
				?>
				<?php
					if (isset($_SESSION['id']) || !empty($_SESSION['id'])) {
						echo("<a>ようこそ " . $_SESSION['id'] . " さん</a>");
					} else {
						echo("<a href='./login.php'>ログイン</a>");
					}
				?>
			</div>
			<div class="clear"></div>
		</div>
	<center>
	<h1>会員登録</h1><br>
		<form method="post" action="sign-up.php">
			<?php echo($idmessage); ?><br>
			ID : <input type="text" name="id" placeholder="任意のIDを入力"><br>
			<font size=-2>（半角英数30文字以下，もしくは全角１５文字以下）</font><br>
			<?php echo($passmessage) ?><br>
			パスワード : <input type="text" name="pass" placeholder="任意のパスワードを入力"><br>
			<?php echo($emailmessage) ?><br>
			e-mail : <input type="text" name="email" placeholder="メールアドレスを入力"><br>
			<font size=-2>会員登録後，このアドレスへ確認メールを送信いたします</font>
			<br>
			<input type="hidden" name="flag" value=1>
			<input type="submit" value="登録" class="sbutton">
		</form>
	</center>
</body>
</html>