<?php session_start();?>
<?php // db connection
	$dsn = "mysql:dbname=tb210109db;host=localhost"; //サーバ情報
	$dbuser = "tb-210109";
	$dbpass = "TaWzkCf5gc";
	$pdo = new PDO($dsn, $dbuser, $dbpass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<?php
	$id = 1; //ここを魚のIDに書きかえる

	$sql = "select * from fish_tbl where id=".$id;
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$resultset = $stmt->fetch();
	$katakana = $resultset['katakana'];
	$hiragana = $resultset['hiragana'];
	$kanji = $resultset['kanji'];
	$season = $resultset['season'];
	if (isset($_POST['flag'])){
		$sql = "select number from users_tbl where id='".$_SESSION['id']."'";
		$stmt = $pdo->query($sql);
		$result = $stmt->fetch(); //numberの取得
		$sql = "create table if not exists ".$result['number']."_tbl(number int(10) auto_increment, katakana varchar(20), hiragana varchar(20), kanji varchar(10), season varchar(50), fish_number int(11), primary key(number))";
		$sql = $pdo->prepare($sql);
		$sql->execute();
		$sql = "insert into ".$result['number']."_tbl (katakana, hiragana, kanji, season, fish_number) values ('".$katakana."', '".$hiragana."', '".$kanji."', '".$season."', ".$id.")";
		$sql = $pdo->prepare($sql);
		$sql->execute();
		$message = "お気に入りへ登録しました";
	}
?>
<!DOCTYPE html>
<thmk>
	<head>
		<meta charset="UTF-8">
		<title>魚編どっとこむ（<?= $kanji." ".$hiragana; ?>）</title>
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
			<?php
				if (!empty($message) || isset($message)) {
					echo('<font size="6" color="#ff0000">'.$message.'</font>');
				}
			?>
			<div class="kanji">
				<a class="sakanahen"><?= $kanji; ?></a>
			</div>
			<h2><?= "読み : ".$hiragana." ， ".$katakana; ?></h2>
			<img border="1" src="<?= './img/'.$id.'.jpg' ?>" width=500 alt="<?= $katakana ?>" title="<?= $katakana ?>"><br>
			<h2/>旬の時期：<?= $season; ?></h2>
			<?php
			if (!empty($_SESSION['id'])||isset($_SESSION['id'])) {
				echo("<form method='post' action='".$id.".php'>
				<input type='hidden' name='flag' value=1>
				<input type=submit value='お気に入りへ追加' class='sbutton'>
				</form>");
			} else {echo("会員登録をしてログインをすることでこの魚をお気に入りリストに登録することができます");}
			?>
		</center>