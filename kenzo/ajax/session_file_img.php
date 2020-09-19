<?php
// 友達押したとき、その人のIDをセッションに入れる　　　　index.jsから送られてくる
session_start();
unset($_SESSION["file_img"]);
$_SESSION["file_img"] = $_POST["img"];

$img = $_POST["img"];
// ----------------------------------------------
echo json_encode($img);

    // ----------------------------------------------
