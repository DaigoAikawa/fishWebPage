<?php // db connection
	$dsn = "mysql:dbname=tb210109db;host=localhost"; //サーバ情報
	$dbuser = "tb-210109";
	$dbpass = "TaWzkCf5gc";
	$pdo = new PDO($dsn, $dbuser, $dbpass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<?php
session_start();
if (!isset($_SESSION['id'])) {
	http_response_code(301);
	header("Location: ./favorite-logout.php");
	exit();
} else {
	$sql = "select number from users_tbl where id='".$_SESSION['id']."'";
	$stmt = $pdo->query($sql);
	$result = $stmt->fetch();
	$sql = "create table if not exists ".$result['number']."_tbl(number int(10) auto_increment, katakana varchar(20), hiragana varchar(20), kanji varchar(10), season varchar(50), fish_number int(11), primary key(number))";
	$sql = $pdo->prepare($sql);
	$sql->execute();

	if (isset($_POST['d_num'])||!empty($_POST['d_num'])) {
		$sql = "delete from ".$result['number']."_tbl where number=".$_POST['d_num'];
		$sql = $pdo->prepare($sql);
		$sql->execute();
	}

	$sql = "select * from ".$result['number']."_tbl";
	$stmt = $pdo->query($sql);
	$resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	if (isset($_POST['d_num'])||!empty($_POST['d_num'])) {
		$sql = "delete from ".$result['number']."_tbl;alter table ".$result['number']."_tbl auto_increment=1";
		$sql = $pdo->prepare($sql);
		$sql->execute();
		foreach ($resultset as $row) {
			$sql = "insert into ".$result['number']."_tbl (katakana, hiragana, kanji, season, fish_number) values ('".$row['katakana']."', '".$row['hiragana']."', '".$row['kanji']."', '".$row['season']."', ".$row['fish_number'].")";
			$sql = $pdo->prepare($sql);
			$sql->execute();
		}
		$_POST['d_num'] = "";
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>お気に入りリスト</title>
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
		<h1><?= $_SESSION['id'] ;?> さんのお気に入りリスト</h1>
		<?php
		$i = 1;
		if (isset($resultset[0])||!empty($resultset[0])) {
			foreach ($resultset as $row) {
				?>
				<div class='favorite'>
					<a class='fish_image'>
						<img border='1' src='./img/<?= $row['fish_number']; ?>.jpg' width=100>
					</a>
						<div class='information'>
						<?php
						echo $row['kanji']."  ".$row['katakana']."<br>";
						echo "旬：".$row['season']."<br>";
						echo "<a href='".$row['fish_number'].".php'>ページ</a>";
						?>
					</div>
					<div class='delete_button'>
						<form method='post' action='favorite.php'>
							<input type='hidden' value='<?= $i ;?>' name='d_num'>
							<input type='submit' value='削除' class='sbutton'>
						</form>
					</div>
				</div>
				<div class="clear"></div>
				<hr>
			<?php
			$i = $i + 1;
			}
		} else {
			?>
			<h2>お気に入りリストは登録されていません．</h2>
			<h2>魚紹介ページから登録することができます．</h2>
			<?php
		}
		?>
	</center>
</body>