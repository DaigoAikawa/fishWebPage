<?php // db connection
	$dsn = "mysql:dbname=tb210109db;host=localhost"; //サーバ情報
	$dbuser = "tb-210109";
	$dbpass = "TaWzkCf5gc";
	$pdo = new PDO($dsn, $dbuser, $dbpass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
<?php
	$sql="delete from fish_tbl;alter table fish_tbl auto_increment=1";
	$pdo->exec($sql);
	$sql=
	"insert into fish_tbl(katakana, hiragana, kanji, season) values ('タイ', 'たい', '鯛', '晩秋～春');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('サワラ','さわら','鰆','晩秋～冬');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('クジラ','くじら','鯨','冬');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('コノシロ','このしろ','鮗','秋～冬');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('マス','ます','鱒','冬');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('ヒラメ','ひらめ','鮃','晩秋～春');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('カレイ','かれい','鰈','種類や地域による。１年中出回っている');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('アジ','あじ','鰺','５〜７月');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('サバ','さば','鯖','10〜12月');
	insert into fish_tbl(katakana,hiragana,kanji,season) values ('イナダ・ハマチ','いなだ・はまち','鰍','11〜1月');
	";

	$num=$pdo->exec($sql);
	$sql="select * from fish_tbl";
	$stmt=$pdo->query($sql);
	$stmt=$stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($stmt as $row){
		var_dump($row);
		echo("<br>");
	}
?>
</body>
</html>