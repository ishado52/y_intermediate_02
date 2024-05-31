<?php
// DB接続
try {
    $dbh = new PDO('mysql:host=localhost;dbname=task_app', 'root', 'root');
} catch (Exception $e) {
    print $e;
}
