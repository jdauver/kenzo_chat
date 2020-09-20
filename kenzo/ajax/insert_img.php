<?php
session_start();
try {

    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
    $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
    // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');


    is_uploaded_file($_FILES["file"]["name"]);
    is_uploaded_file($_FILES["file"]["tmp_name"]);
    $tmp = $_FILES["file"]["tmp_name"];
    $img = $_FILES["file"]["name"];

    move_uploaded_file($tmp, '../talk_img/' . $img);


    $date = date("Y-m-d");
    $time = date("H:i");
    $sql = "INSERT INTO kenzo_talk(name, date, time, id, id2,img) VALUES (:name, :date, :time, :id, :id2, :img)";
    $stmt = $db->prepare($sql);
    $params = array(':name' => $_SESSION['name'], ':date' => $date, ':time' => $time, ':id' => $_SESSION['id'], ':id2' => $_SESSION['id2'], ':img' => $_FILES["file"]['name']);
    $stmt->execute($params);

    echo json_encode("a");
} catch (PDOException $e) {
    die("PDO Error:" . $e->getMessage());
}
