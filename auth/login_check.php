<?php

$mail = $_POST['mail'];
$pass = $_POST['pass'];

// DB接続
require('../db/dbconnection.php');

// パスワードをハッシュ化
$hashed_pass = md5($pass);

// SQL文
$sql = 'SELECT * FROM users WHERE email=? AND password=?';
$stmt = $dbh->prepare($sql);
$data = array($mail,$hashed_pass);
$stmt->execute($data);

// データベース接続を終了
$dbh = null;

// mail,passが一致すればindex.phpに遷移
if($result = $stmt -> fetch(PDO::FETCH_ASSOC)){
    session_start();
    $_SESSION['login'] = 1;
    $_SESSION['mail'] = $mail;
    $_SESSION['name'] = $result['name'];
    $_SESSION['path'] = $result['path'];
    $_SESSION['user_id'] = $result['id'];
    header("Location:../index.php");
}

