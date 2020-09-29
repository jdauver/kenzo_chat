<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/friend_search.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <title>友達検索ページ</title>
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

    <main>
        <section>
            <h2>友達を探す</h2>
            <p>ID名から友達を探す</p>
            <form action="friend_search.php" method="POST" class="form_style" id="form_style">
                <div id="search-wrap">
                    <input type="search" placeholder="ID検索" name="id" required>
                    <div id="fri-search" class="search"></div>
                    <br>
                </div>

                <input type="button" value="探す" class="btn btn--red btn--radius btn--cubic" id="sagasu"><i class="fas fa-position-right"></i>

            </form>
        </section>


        <?php



        //値の確認
        if (isset($_POST["id"])) {
            try {
                //データーベースに接続
                $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
                // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
                // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');


                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



                if ($_POST["id"] != "") { //入力有無を確認

                    if ($_POST["id"] == $_SESSION['id']) {
                        echo "<p class='messege'>自分は友達にできません</p>";
                    } else {

                        $stmt = $db->query("SELECT * FROM kenzo_account WHERE id = '$_POST[id]'");
                        //SQL文を実行して、結果を$stmtに代入する。


                        foreach ($stmt as $row) {
                            // データベースのフィールド名で出力
                            $friend_name = $row["name"];
                            $friend_img = $row["img"];
                        }


                        if ($row > 0) {
                            echo <<<FTOUROKU
         <div class='ftouroku'>

         <div class="search_img" style="background-image: url('upload/$friend_img');">
        </div>
            <p class='friendname'>$friend_name</p>
           <form action="friend_search.php" id='touroku_form' method="post">
           <input type='hidden' name='id' value='$_POST[id]'>
           <input type='hidden' name='name' value='$friend_name'>
           <input type='hidden' name='img' value='$friend_img'>


           <input type='submit' name='ok' id='touroku' value='登録' class="friendinput btn btn--red btn--radius btn--cubic syo-btn"><i class="fas fa-position-right"></i>


           <input type='button' id="yameru" name='ng' value='やめる' class="syo-btn friendinput btn btn--red btn--radius btn--cubic"><i class="fas fa-position-right"></i><br>
           </form>
        </div>

FTOUROKU;
                        }
                        if ($row == 0) {
                            echo "<p class='messege'>該当なし</p>";
                        }
                    }
                    // 自分は友達にできない



                }
            } catch (PDOException $e) {
                die("PDO Error:" . $e->getMessage());
            }
        }


        // 友達登録したとき
        if (isset($_POST["ok"])) {

            echo <<<kesu
    <script>
    $(function () {

        $(".ftouroku").html("");
    });
    </script>
kesu;

            try {
                $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
                // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
                // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                // すでに友達になっているか確認
                // $qq = "SELECT COUNT(*) FROM tomo_$_SESSION[id] where id='$_POST[id]'";
                // $q = $db->query($qq);
                // $kensyo = $q->fetchColumn();
                // 以下は本番でkensho==0に変える

                if ($kensyo < 1000) {
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
             <div class="search_img" style="background-image: url('upload/$friend_img');">
        </div>
            <p class='friendname'>$_POST[name]</p>

           <input type='submit' value='トーク' id="search_talk" class="friendinput btn btn--red btn--radius btn--cubic syo-btn"><i class="fas fa-position-right"></i>


           <input type='button' id='modoru' value='もどる' class="friendinput btn btn--red btn--radius btn--cubic syo-btn"><i class="fas fa-position-right"></i><br>

           
        <div class="friend_talk">
            <input id="frimg" type="hidden" value="$friend_img">
             <input id="frid" type="hidden" value='$_POST[id]'>
             <input id="friname" type="hidden" value="$friend_name">
        </div> 

FTOUROKU;
                } else {
                    echo "<p class='messege'>すでに友達になっています</p>";
                }
            } catch (PDOException $e) {
                die("PDO Error:" . $e->getMessage());
            }
        }


        ?>
    </main>
</body>

</html>