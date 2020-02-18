<?php session_start();?>
<?php // db connection
	$dsn = "mysql:dbname=tb210109db;host=localhost"; //サーバ情報
	$dbuser = "tb-210109";
	$dbpass = "TaWzkCf5gc";
	$pdo = new PDO($dsn, $dbuser, $dbpass,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>
<?php
$sql="create table users_tbl(number int(12) auto_increment, id varchar(30), password varchar(64), mail varchar(200),primary key(number))";
$num=$pdo->exec($sql);
echo($num);
$sql="create table tsukuri_tbl(id varchar(10), tsukuri varchar(5), primary key(tsukuri));";
$num=$pdo->exec($sql);
echo($num);
$sql="create table fish_tbl(id int(10) auto_increment, katakana varchar(20),hiragana varchar(20), kanji varchar(10), season varchar(50), primary key(id));";
$num=$pdo->exec($sql);
echo($num);
$sql = "CREATE TABLE keijiban_tbl (id int(3) auto_increment, name varchar(64), comment varchar(188), time varchar(64), password varchar(64), primary key(id))";
?>