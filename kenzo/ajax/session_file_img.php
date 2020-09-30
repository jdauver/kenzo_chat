<?php

session_start();
unset($_SESSION["file_img"]);
$_SESSION["file_img"] = $_POST["img"];

$img = $_POST["img"];
// ----------------------------------------------
echo json_encode($img);

    // ----------------------------------------------
