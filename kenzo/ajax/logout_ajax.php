<?php
/* ログアウトのボタンを押したときにセッションを切るプログラム */
session_start();
$_SESSION = array();
session_destroy();


echo json_encode($a);

?>