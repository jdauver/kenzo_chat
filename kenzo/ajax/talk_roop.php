<?php
// 0.1秒ごとにトーク内容を抽出するajax 　　index2.jsから送られてくる
session_start();
try {
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
    // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
    $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');
    $sql = "SELECT * FROM kenzo_talk WHERE (id='$_SESSION[id]' AND id2='$_SESSION[id2]' AND num>$_POST[id]) OR (id='$_SESSION[id2]' AND id2='$_SESSION[id]' AND num>$_POST[id]) ORDER BY date,time";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
        if ($message["img"]) {
            if ($message["id"] == $_SESSION["id"]) {
                $talk[] = "<div id='$message[num]' class='zibun $message[date] talk'><span class='time'>" . $message['time'] . "</span> <img src='talk_img/$message[img]' class='zibun-img'>　<div class='zibun-topuga'></div></div>";
            } else {
                $talk[] = "<div id='$message[num]' class='aite $message[date] talk'><div class='aite-topuga'></div>　<img src='talk_img/$message[img]' class='aite-img'> <span class='time'>" . $message['time'] . "</span></div>";
            }
        } else {
            if ($message["id"] == $_SESSION["id"]) {
                $talk[] = "<div id='$message[num]' class='zibun $message[date] talk'><span class='time'>" . $message['time'] . "</span> <span class='zibun-message'>" . $message['talk'] . "</span>　<div class='zibun-topuga'></div></div>";
            } else {
                $talk[] = "<div id='$message[num]' class='aite $message[date] talk'><div class='aite-topuga'></div>　<span class='aite-message'>" . $message['talk'] . "</span> <span class='time'>" . $message['time'] . "</span></div>";
            }
        }

        $num[] = $message["num"];
    }

    // $q=count($talk);
    // if($q>0){
    $data_arr = array($talk, $num, $_SESSION["img"], $_SESSION["img2"]);
    echo json_encode($data_arr);
    // }

} catch (PDOException $e) {
    die("PDO Error:" . $e->getMessage());
}
