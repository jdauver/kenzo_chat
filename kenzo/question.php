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
    <script src="https://unpkg.com/scrollreveal"></script>
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
            <h2>ガイド</h2>
        </div>


    </section>

</body>


</html>