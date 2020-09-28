<?php
/* ログアウトのボタンを押したときにセッションを切るプログラム */
header('Content-Type: application/json');
session_start();

if ($_POST['logout'] === 'logout_ajax') {
    session_destroy();
}

echo json_encode("session clear");
