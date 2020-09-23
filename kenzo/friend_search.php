<?php
session_start();
?>
<!-- みんなでまとめてるやつ 
css付いてない-->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="css/index.css"> -->
    <link rel="stylesheet" href="css/etcetera.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>

    <title>友達検索ページ</title>
</head>

<body>
    <header id="top">
        <nav id="account_nav">
            <ul id="ul_style">
                <li class="li_style"><a href="account_main.php" class="a_style"><i class="fa fa-home" id="img1"></i></a>
                </li>
                <li class="li_style"><a href="friend_search.php" class="a_style"><i class="fa fa-user-plus" id="img2"></i></a></li>
                <li class="li_style"><a href="setting.php" class="a_style"><i class="fa fa-cog" id="img3"></i></a></li>
                <li class="li_style"><a href="login.php" class="a_style"><i class="fa fa-sign-out" id="img4"></i></a>
                </li>
            </ul>
        </nav>
    </header>

    <section>
        <form action="friend_search.php" method="POST">
            <input type="text" placeholder="ID検索" name="id" required>
            <input type="submit" value="OK" name="submit">
        </form>
    </section>

    <!-- <section>
        <form action="friend_search.php" method="POST" class="form_style" id="form_style">
            <div id="search-wrap">
                <input type="search" placeholder="ID検索" name="id" required>
                <div id="fri-search" class="search"></div>
                <br>
            </div>

            <input type="button" value="探す" class="btn btn--red btn--radius btn--cubic" id="sagasu"><i class="fas fa-position-right"></i>

        </form>
    </section> -->


</body>

</html>

<?php


//値の確認
if (isset($_POST["submit"])) {
    try {
        //データーベースに接続
        $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
        // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
        // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




        if ($_POST["id"] != "") { //入力有無を確認
            $stmt = $db->query("SELECT * FROM kenzo_account WHERE id = '$_POST[id]'"); //SQL文を実行して、結果を$stmtに代入する。


            foreach ($stmt as $row) {
                // データベースのフィールド名で出力

                $friend_name = $row["name"];
                $friend_img = $row["img"];
            }

            if ($row > 0) {
                echo <<<FTOUROKU
            <img src='upload/$friend_img' class='friendimg'>
            <p class='friendname'>$friend_name</p>

           <form action="friend_search.php" method="post">
           <input type='hidden' name='id' value='$_POST[id]'>
           <input type='hidden' name='name' value='$friend_name'>
           <input type='hidden' name='img' value='$friend_img'>


           <input type='submit' name='ok' class='friendinput' value='登録' class="friendinput btn btn--red btn--radius btn--cubic syo-btn"><i class="fas fa-position-right"></i>

           
           <input type='submit' name='ng' class='friendinput' value='やめる' class="syo-btn friendinput btn btn--red btn--radius btn--cubic"><i class="fas fa-position-right"></i><br>
           </form>
FTOUROKU;
            }

            if ($row == 0) {
                echo "<p class='messege'>該当なし</p>";
            }
        }
    } catch (PDOException $e) {
        die("PDO Error:" . $e->getMessage());
    }
} else if (isset($_POST["ok"])) {
    try {
        $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
        // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
        // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare(
            "INSERT INTO tomo_$_SESSION[id] (id)" . 'VALUES(:id)'
        );

        $stmt->bindParam(':id', $_POST['id']);
        $stmt->execute();

        $stmt = $db->prepare(
            "INSERT INTO tomo_$_POST[id] (id)" . 'VALUES(:id)'
        );

        $stmt->bindParam(':id', $_SESSION['id']);
        $stmt->execute();

        $_SESSION["id2"] = $_POST['id'];

        echo <<<FTOUROKU
            <img src='upload/$_POST[img]' class='friendimg'>
            <p class='friendname'>$_POST[name]</p>
           <input type='submit' id='talkjump' class='friendinput' value='トーク' class="friendinput btn btn--red btn--radius btn--cubic syo-btn"><i class="fas fa-position-right"></i>
           <input type='submit' class='friendinput' value='もどる' class="friendinput btn btn--red btn--radius btn--cubic syo-btn"><i class="fas fa-position-right"></i><br>
FTOUROKU;
        if ($_SESSION["id2"] != $_POST['id']) {
            echo "<p class='messege'>すでに友達になっています</p>";
        }
    } catch (PDOException $e) {
        die("PDO Error:" . $e->getMessage());
    }
}


?>