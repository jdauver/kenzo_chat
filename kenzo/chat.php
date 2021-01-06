<?php
session_start();
?>

<!DOCTYPE html>
<html lang="jaaa">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/chat.css">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="js/index2.js"></script>
    <link rel="stylesheet" href="css/lity.min.css">
    <script src="js/lity.min.js"></script>
    <title>チャット</title>
</head>

<body id="chat">

    <div class="message"></div>

    <div class="message_box">

        <label class="message_label">
            <div class="message_img"></div>
            <input type="file" name="img" placeholder="TOP画像" id="img" class="set_input" accept="image/*"><br>
        </label>

        <textarea name="message" class="textarea" cols="30" rows="10"></textarea>
        <img src="img/IMG_0555.PNG" id="send" name="send" height="40px">


    </div>

</body>

<?php
// ログイン切れてたらログインページに---------
if (!isset($_SESSION['name'])) {
    echo <<<kireta
    <script>
        alert("もう一度ログインしてください");
        window.location.href = 'login.php';
    </script>
kireta;
}
echo <<<HEAD
    <header class="chat_head">
        <div class="head">
            <a href="account_main.php" class="modoru">⇦</a>
            

            <h2 class="aite_name"> $_SESSION[name2]</h2>

            <div id="sitabtn"></div>
        </div><!-- head -->
    </header>
HEAD;
?>