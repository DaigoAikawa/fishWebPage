<?php // db connection
	$dsn = "mysql:dbname=tb210109db;host=localhost"; //サーバ情報
	$dbuser = "tb-210109";
	$dbpass = "TaWzkCf5gc";
	$pdo = new PDO($dsn, $dbuser, $dbpass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<?php
	if (isset($_POST['tsukuri']) || !empty($_POST['tsukuri'])) {
		$tsukuri = $_POST['tsukuri'];
		$sql = 'select id from tsukuri_tbl where tsukuri="'.$tsukuri.'";';
		$stmt = $pdo->query($sql);
		$resultset = $stmt->fetch();
			//echo($resultset[0][0]);
		if (isset($resultset['id']) || !empty($resultset['id'])) {
			http_response_code(301);
			header("Location: ./".$resultset['id'].".php");
			exit();
		} else {
			http_response_code(301);
			header("Location: ./notfound.php");
			exit();
		}
	}
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<title>魚編どっとこむ</title>
		<link rel="stylesheet" href="/common.css">
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
		<center>
			<h1>魚編どっとこむ</h1><br>
			魚編（さかなへん）の漢字のつくり（漢字の右半分）を入力して読み方を検索できます！<br>
			<br>
			<form action="index.php" method="POST">
				<a class="sakanahen">魚</a><input type="text" name="tsukuri" placeholder="周" class="tsukuri" size="2"><br>
				<br>
				<input type="submit" value="検索" class="button">
			</form>
		</center>