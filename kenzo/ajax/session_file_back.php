<?php
// 友達押したとき、その人のIDをセッションに入れる　　　　index.jsから送られてくる
session_start();

unset($_SESSION["file_back"]);
$_SESSION["file_back"] = $_POST["img2"];

$a = $_POST["img2"];
// ----------------------------------------------
echo json_encode($a);
