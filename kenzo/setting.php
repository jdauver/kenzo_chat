<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/index.css"> -->
    <link rel="stylesheet" href="css/setting.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <title>設定</title>
</head>

<body>
    <?php
    if (isset($_POST["update_submit"])) {

        $s_id = $_SESSION['id'];

        try {
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
            // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
            $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_POST["name"] != "") {
                $array[0] = $_POST['name'];
            } elseif ($_POST["name"] == "") {
                $r = $db->query("SELECT * FROM kenzo_account WHERE id='$s_id'");
                foreach ($r as $s_val) {
                    $array[0] = $s_val["name"];
                }
            }

            if ($_POST["pass"] != "") {
                $array[1] = $_POST['pass'];
            } elseif ($_POST["pass"] == "") {
                $r = $db->query("SELECT * FROM kenzo_account WHERE id='$s_id'");
                foreach ($r as $s_val) {
                    $array[1] = $s_val["pass"];
                }
            }

            if ($_FILES['img']['size'] > 0) {
                $array[2] = $_FILES['img']['name'];
            } else {
                $r = $db->query("SELECT * FROM kenzo_account WHERE id='$s_id'");
                foreach ($r as $s_val) {
                    $array[2] = $s_val["img"];
                }
            }


            if ($_FILES['imgback']['size'] > 0) {
                $array[3] = $_FILES['imgback']['name'];
            } else {
                $r = $db->query("SELECT * FROM kenzo_account WHERE id='$s_id'");
                foreach ($r as $s_val) {
                    $array[3] = $s_val["back"];
                }
            }


            $img = $_FILES['img']['name'];
            $img_tmp =  $_FILES['img']['tmp_name'];

            $back = $_FILES['imgback']['name'];
            $back_tmp =  $_FILES['imgback']['tmp_name'];

            is_uploaded_file($img);
            is_uploaded_file($img_tmp);
            is_uploaded_file($back);
            is_uploaded_file($back_tmp);

            //画像をuploadファイルに保存
            move_uploaded_file($img_tmp, 'upload/' . $img);

            //画像をuploadbackファイルに保存
            move_uploaded_file($back_tmp, 'uploadback/' . $back);
        } catch (PDOException $e) {
            die("PDO Error:" . $e->getMessage());
        }



        $names = $array[0];
        $pass = $array[1];
        $img = $array[2];
        $back = $array[3];

        $img_name = $_FILES['img']['name'];
        $img_tmp =  $_FILES['img']['tmp_name'];

        $back_name = $_FILES['imgback']['name'];
        $back_tmp =  $_FILES['imgback']['tmp_name'];

        echo <<<w
        <header id="top">
         <img src='img/q.png' class='q'>
            <nav id="account_nav">
                <ul id="ul_style">
                    <li class="li_style"><a href="account_main.php" class="a_style"><i class="fa fa-home" id="img1"></i></a>
                    </li>
                    <li class="li_style"><a href="friend_search.php" class="a_style"><i class="fa fa-user-plus" id="img2"></i></a></li>
                    <li class="li_style"><a href="setting.php" class="a_style"><i class="fa fa-cog" id="img3"></i></a></li>
                    <li class="li_style" id="id_li_style"><a class="a_style"  ><img class="touroku_img_logout"src="img/logout.png"></a>
                    </li>
                </ul>
            </nav>
    </header>

        <div class="setting">
            <h2>$_SESSION[name]さんの確認画面</h2>
        </div>

        <form class=setting_form action="" method="POST" enctype="multipart/form-data">
            <div class="group">
                <input class='input_text name' type="text" value="$names" name="name" id="name" readonly>
            </div>
            <div class="group">
                <input class='input_text pass' type="text" value="$pass" name="pass" id="pass" readonly>
            </div>

            <div class='img_wrap'>
                <div id='pv' class='pv_img'></div>
            </div>
            <div class='back_wrap'>
                <div id='pv' class='pv_back'></div>
            </div>

            <input type="hidden" value="$img_tmp" name="tmp" readonly>
            <input type="hidden" value="$back_tmp" name="backtmp" readonly>
            <input type="hidden" value="$img" name="imgsrc" readonly>
            <input type="hidden" value="$back" name="backsrc" readonly>

            <div class="button">
                <input type="submit" name="ok" id="ok" value="確定"><br>
                <button type="button" name="ng" id="ng"><a href="setting.php">やり直す</a></button>
            </div> 
            
        </form>

        <script type="text/javascript">
            $(function(){
                
                $(".pv_img").css("background-image","url(upload/$img)");
                $(".pv_back").css("background-image","url(uploadback/$back)");

                if ($(".pv_back").css("background-image").match(/uploadback\/back\.png/)) {
                    $(".pv_back").css("border", "solid 1px black");

                } else {
                    $(".pv_back").css("border", "none");

                }
             });

            </script>

w;
        // }
    } elseif ($_POST['ok']) {


        try {
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
            // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
            $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $img = $_POST["imgsrc"];
            $img_tmp = $_POST["tmp"];

            $back = $_POST["backsrc"];
            $back_tmp = $_POST["backtmp"];



            //SQLを準備
            $r = $db->prepare("UPDATE kenzo_account SET name=:name,img=:img,pass=:pass,back=:back WHERE id='{$_SESSION['id']}'");


            //$_POST["name"]、$_POST["img"]、$_POST["pass"]、$_POST["back"]、が先ほどのreadonlyの情報
            $r->bindParam(':name', $_POST["name"]);
            $r->bindParam(':img', $_POST["imgsrc"]);
            $r->bindParam(':pass', $_POST["pass"]);
            $r->bindParam(':back', $_POST["backsrc"]);


            //SQLを実行
            $r->execute();

            $_SESSION['name'] = $_POST['name'];
            $_SESSION['img'] = $_POST['imgsrc'];
            $_SESSION['back'] = $_POST['backsrc'];

            echo <<<js
                <script>
                    window.location.href = "account_main.php";
                </script>
js;
        } catch (PDOException $e) {
            die("PDO Error:" . $e->getMessage());
        }
    } else {
        unset($_SESSION["file_img"]);
        unset($_SESSION["file_back"]);
        //ホーム画面の設定
        try {
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
            // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
            $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $zibun = $db->query("SELECT * FROM kenzo_account WHERE id='$_SESSION[id]'");
            foreach ($zibun as $zibunval) {
                $name = $zibunval["name"];
                $img = $zibunval["img"];
                $back = $zibunval["back"];
            }
            echo <<< MOD
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
        <div class="setting">
            <h2>アカウント設定</h2>
            <p>アカウント情報を変更できます</p>
        </div>

        <form class=setting_form action="" id=updateform method="POST" enctype="multipart/form-data">

            <div class="group">
                <input class='input_text name' type="text" name="name" placeholder="ニックネーム" class="set_input">
            </div>

            <div class="group">
                 <input class='input_text pass' type="text" name="pass" placeholder="パスワード" class="set_input2">
                 <p>※英数字６文字以上20文字未満</p>
            </div>

            <div class='img_wrap'>
                <div id='pv' class='pv_img'></div>
                <label class="setting_label">
                    <div class="file_img">
                        <input type="file" name="img" id="file_img" class="set_input3" accept="image/*">
                    </div>
                </label>
               
            </div>
            <div class='back_wrap'>
                <div id='pv' class='pv_back'></div>
                <label class="setting_label">
                    <div class="file_back">
                        <input type="file" name="imgback" id="file_back" class="set_input4" accept="image/*">
                    </div> 
                </label>
            </div>
            <div class="button">
                <button type="submit" name="update_submit" id="update_submit">変更</button><br>
                <button type="reset">やり直す</button>
            </div>
        </form>
MOD;


            echo <<<IMG
            <script type="text/javascript">
            $(function(){

                $(".pv_img").css("background-image","url(upload/$img)");
                $(".pv_back").css("background-image","url(uploadback/$back)");

                if ($(".pv_back").css("background-image").match(/uploadback\/back\.png/)) {
                    $(".pv_back").css("border", "solid 1px black");

                } else {
                    $(".pv_back").css("border", "none");

                }

             });

            </script>
IMG;
        } catch (PDOException $e) {
            die("PDO Error:" . $e->getMessage());
        }
    }

    ?>



</body>

</html>