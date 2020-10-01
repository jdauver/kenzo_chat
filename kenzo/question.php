<?php
session_start();
// ログイン切れてたらログインページに---------
if (!isset($_SESSION['name'])) {
    echo <<<kireta
    <script>
        alert("もう一度ログインしてください");
        window.location.href = 'login.php';
    </script>
kireta;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/question.css">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>使用方法</title>

</head>

<body>
    <header id="top">
        <a href="question.php"><img src='img/q.png' class='q'></a>
        <nav id="account_nav">
            <ul id="ul_style">
                <li class="li_style"><a href="account_main.php" class="a_style"><i class="fa fa-home" id="img1"></i></a>
                </li>
                <li class="li_style"><a href="friend_search.php" class="a_style"><i class="fa fa-user-plus" id="img2"></i></a></li>
                <li class="li_style"><a href="setting.php" class="a_style"><i class="fa fa-cog" id="img3"></i></a></li>
                <li class="li_style" id="id_li_style"><a class="a_style"><img class="touroku_img_logout" src="img/logout.png"></a>
                </li>
            </ul>
        </nav>
    </header>

    <section>
        <div class="guide">
            <h2>使用方法</h2>
        </div>

        <div class="account_main about">
            <div class="about_wrap">
                <h3>アカウントページについて</h3>
                <img class="guide_img" src="img/account_main.png" alt="">
                <p class="sita">↓</p>
                <img class="guide_img" src="img/account_main2.png" alt="">
            </div>
        </div>


        <div class="chat about">
            <div class="about_wrap">
                <h3>チャットについて</h3>
                <img class="guide_img" src="img/chat.png" alt="">
                <div class="tyui">
                    <p>※相手とのトークの内容が100件を超えた場合は古いものから削除されていきます</p>
                    <p>※画像ファイルは　JPG　GIF　PNG　のみ送信することができます</p>
                </div>
            </div>
        </div>

    </section>

</body>


</html>