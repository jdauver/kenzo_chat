<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta name="robots" content="nofollow">
    <!-- <link rel="icon" type="image/x-icon" href="image/favicon.ico"> -->
    <!-- <link rel="stylesheet" href="css/index.css"> -->
    <link rel="stylesheet" href="css/account_main.css">

    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>アカウントページ</title>
</head>

<body>
</body>


</html>
<?php

try {
    $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
    // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
    // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
    // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $qq = "SELECT COUNT(*) FROM tomo_$_SESSION[id]";
    $q = $db->query($qq);
    $kensyo = $q->fetchColumn();


    $zibun = $db->query("SELECT * FROM kenzo_account WHERE id='$_SESSION[id]'");
    foreach ($zibun as $zibunval) {
        $name = $zibunval["name"];
        $img = $zibunval["img"];
        $back = $zibunval["back"];
    }
    echo <<< MAIN

 
    <header id="top">
            <nav id="account_nav">
                <ul id="ul_style">
                    <li class="li_style"><a href="account_main.php" class="a_style"><i class="fa fa-home" id="img1"></i></a>
                    </li>
                    <li class="li_style"><a href="friend_search.php" class="a_style"><i class="fa fa-user-plus" id="img2"></i></a></li>
                    <li class="li_style"><a href="setting.php" class="a_style"><i class="fa fa-cog" id="img3"></i></a></li>
                    <li class="li_style"><a href="login.php" class="a_style"><img class="touroku_img_logout"src="img/logout.png"></a>
                    </li>
                </ul>
            </nav>
    </header>


    <section id="section_account">

        <div id="section_img" class="section_account_img_style" style="background-image: url('upload/$_SESSION[img]');">
        </div>

        <div id="section_name">
            <h2>{$_SESSION['name']}</h2>
        </div>
        </div>

    </section>

   

    <section id="friend_style">

        <div id="cursor" class="display">
            <div class="friend_p_box">
                <p class="friend_p">友達</p>
                <p class="friend_p">{$kensyo}</p>
            </div>
            <img id='friend_id' class="friend_img" src='img/down1.png'>
        </div>

    
        <div id="scroll_info">
        <div id="scroll_box">

MAIN;



    $friend = $db->query("SELECT * FROM tomo_$_SESSION[id]");
    $i = 0;
    foreach ($friend as $value) {
        $f_array[] = $value["id"];


        $f_table = $db->query("SELECT * FROM kenzo_account WHERE id='$f_array[$i]'");

        foreach ($f_table as $val) {
            echo <<<FRIEND
            <div class="friend{$i} friends">

                <div class="friend_imgs" style="background-image: url('upload/$val[img]');"></div>
                <p>$val[name]</p>
                <input id="hiddenimg" type="hidden" value="$val[img]">
                <input id="hiddenid" type="hidden" value="$val[id]">
                
            </div>

FRIEND;
        }
        $i++;
        /* 友達の画像を背景に出しているソース------------ */
    }

    echo <<<UNDER
            <div id='upstyle'>
                <img id='friend_id1' class='friend_img' src='img/up1.png'>
            </div>
        </div>
        </div>
        
    </section>
UNDER;
} catch (PDOException $e) {
    die("PDO Error:" . $e->getMessage());
}

?>