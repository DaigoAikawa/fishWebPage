<?php // db connection
	$dsn = "mysql:dbname=tb210109db;host=localhost"; //サーバ情報
	$dbuser = "tb-210109";
	$dbpass = "TaWzkCf5gc";
	$pdo = new PDO($dsn, $dbuser, $dbpass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<?php
session_start();
?>
<?php
	$sql = "select * from fish_tbl";
	$stmt = $pdo->query($sql);
	$resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>お魚図鑑</title>
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
		<h1>お魚図鑑</h1>
		<?php
		foreach ($resultset as $key) {
			?>
			<a href="<?= $key['id'] ;?>.php"><?= $key['hiragana']." (".$key['kanji'].")" ;?></a><br>
			<?php
		}
		?>
</body>