<?php
// トーク内容送信したときkenzo_talkに内容を入れる　　index.jsから送られてくる
session_start();

try {
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
    $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
    // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');
    $date = date("Y-m-d");
    $time = date("H:i");
    $sql = "INSERT INTO kenzo_talk(name, talk, date, time, id, id2) VALUES (:name, :talk, :date, :time, :id, :id2)";
    $stmt = $db->prepare($sql);
    $params = array(':name' => $_SESSION['name'], ':talk' => $_POST['message'], ':date' => $date, ':time' => $time, ':id' => $_SESSION['id'], ':id2' => $_SESSION['id2']);
    $stmt->execute($params);

    // echo json_encode($_POST['message']);
} catch (PDOException $e) {
    die("PDO Error:" . $e->getMessage());
}
