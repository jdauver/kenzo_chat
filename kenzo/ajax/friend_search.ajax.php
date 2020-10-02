<?php
// 「トーク」押して、その人とのトーク画面に移行する
session_start();
try {
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
    // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
    $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $_SESSION["id2"] = $_POST["id"];
    $_SESSION["img2"] = $_POST["img"];
    $_SESSION["name2"] = $_POST["name"];
} catch (PDOException $e) {
    die("PDO Error:" . $e->getMessage());
}
