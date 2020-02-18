<?php // db connection
	$dsn = "mysql:dbname=tb210109db;host=localhost"; //サーバ情報
	$dbuser = "tb-210109";
	$dbpass = "TaWzkCf5gc";
	$pdo = new PDO($dsn, $dbuser, $dbpass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<?php
	if ((isset($_POST['id']) || !empty($_POST['id'])) && (isset($_POST['pass']) || !empty($_POST['pass']))) {
		$id = $_POST['id'];
		$pass = hash('sha256', $_POST['pass']);
		$_POST['pass'] = "";
		$sql = "select password from users_tbl where id='" . $id ."'";
		$stmt = $pdo->query($sql);
		$resultset = $stmt->fetchAll(PDO::FETCH_NUM);
		if ($resultset) {
			if ($pass == $resultset[0][0]) {
				session_start();
				$_SESSION['id'] = $id;
				http_response_code(301);
				header("Location: ./index.php");
				exit();
			} else {
				$message = "パスワードが不正です";
			}
		} else {
			$message = "存在しないIDです";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ログイン（魚編どっとこむ）</title>
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
		<h1>ログイン</h1>
		<?php if (isset($message) || !empty($message)) {echo($message);}?>
		<form action="login.php" method="post">
			ID : <input type="text" name="id"><br>
			パスワード : <input type="password" name="pass"><br>
			<br>
			<input type="submit" class="sbutton" value="ログイン">
		</form>
		<br>
		<a href="./sign-up.php">新規会員登録はこちら</a>
	</center>
</body>