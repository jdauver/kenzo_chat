<?php
session_start();
// チャットページ開いたとき今までの履歴出す
try {
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
    // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
    $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');
    $sql = "SELECT * FROM kenzo_talk WHERE (id='$_SESSION[id]' AND id2='$_SESSION[id2]') OR (id='$_SESSION[id2]' AND id2='$_SESSION[id]') ORDER BY date,time";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
        if ($message["img"]) {
            if ($message["id"] == $_SESSION["id"]) {
                $talk[] = "<div id='$message[num]' class='zibun $message[date] talk'><span class='time'>" . $message['time'] . "</span> <div id='lity_info' src='talk_img/$message[img]' data-lity='data-lity'><img src='talk_img/$message[img]' class='zibun-img'></div>　<div class='zibun-topuga'></div></div>";
            } else {
                $talk[] = "<div id='$message[num]' class='aite $message[date] talk'><div class='aite-topuga'></div>　<div id='lity_info' src='talk_img/$message[img]' data-lity='data-lity'><img src='talk_img/$message[img]' class='aite-img'></div> <span class='time'>" . $message['time'] . "</span></div>";
            }
        } else {
            if ($message["id"] == $_SESSION["id"]) {
                $talk[] = "<div id='$message[num]' class='zibun $message[date] talk'><span class='time'>" . $message['time'] . "</span> <span class='zibun-message'>" . $message['talk'] . "</span>　<div class='zibun-topuga'></div></div>";
            } else {
                $talk[] = "<div id='$message[num]' class='aite $message[date] talk'><div class='aite-topuga'></div>　<span class='aite-message'>" . $message['talk'] . "</span> <span class='time'>" . $message['time'] . "</span></div>";
            }
        }
    }

    $data_arr = array($talk, $_SESSION["img"], $_SESSION["img2"]);
    echo json_encode($data_arr);
} catch (PDOException $e) {
    die("PDO Error:" . $e->getMessage());
}
