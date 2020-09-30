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
    <!-- <link rel="stylesheet" href="css/index.css"> -->
    <link rel="stylesheet" href="css/setting.css">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
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


            $name = htmlentities($_POST["name"]);
            $pass = htmlentities($_POST["pass"]);

            if ($_POST["name"] != "") {
                $array[0] = $name;
            } elseif ($_POST["name"] == "") {
                $r = $db->query("SELECT * FROM kenzo_account WHERE id='$s_id'");
                foreach ($r as $s_val) {
                    $array[0] = $s_val["name"];
                }
            }

            if ($_POST["pass"] != "") {
                $array[1] = $pass;
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





            // パスワード重複チェック
            $qq = "SELECT COUNT(*) FROM kenzo_account WHERE pass='$pass'";
            $q = $db->query($qq);
            $kensyo = $q->fetchColumn();

            if ($kensyo > 0) {
                $error[] = "<p class='error'>そのパスワードはすでに使用されてます</p>";
            }




            $img = $_FILES['img']['name'];
            $img_tmp =  $_FILES['img']['tmp_name'];

            is_uploaded_file($img);
            is_uploaded_file($img_tmp);



            //画像をuploadファイルに保存
            move_uploaded_file($img_tmp, 'upload/' . $img);
        } catch (PDOException $e) {
            die("PDO Error:" . $e->getMessage());
        }



        $names = $array[0];
        $pass = $array[1];
        $img = $array[2];

        $img_name = $_FILES['img']['name'];
        $img_tmp =  $_FILES['img']['tmp_name'];





        $errors = count($error);

        // もし配列errorに一つでもエラー内容が入っていたらエラーを表示してまた登録画面へーーー
        if ($errors > 0) {

            foreach ($error as $value) {

                $evalue = $value . "<br>";
            }
            setting($value);
        } else {
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
            <h2>変更確認画面</h2>
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
            
            <input type="hidden" value="$img_tmp" name="tmp" readonly>
            <input type="hidden" value="$img" name="imgsrc" readonly>

            <div class="button">
                <input type="submit" name="ok" id="ok" value="確定"><br>
                <button type="button" name="ng" id="ng"><a href="setting.php">やり直す</a></button>
            </div> 
            
        </form>

        <script type="text/javascript">
            $(function(){
                
                $(".pv_img").css("background-image","url(upload/$img)");
                
             });

            </script>

w;
        }
    } elseif ($_POST['ok']) {


        try {
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
            // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
            $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $img = $_POST["imgsrc"];
            $img_tmp = $_POST["tmp"];

            //SQLを準備
            $r = $db->prepare("UPDATE kenzo_account SET name=:name,img=:img,pass=:pass WHERE id='{$_SESSION['id']}'");

            //$_POST["name"]、$_POST["img"]、$_POST["pass"]、$_POST["back"]、が先ほどのreadonlyの情報
            $r->bindParam(':name', $_POST["name"]);
            $r->bindParam(':img', $_POST["imgsrc"]);
            $r->bindParam(':pass', $_POST["pass"]);

            //SQLを実行
            $r->execute();

            $_SESSION['name'] = $_POST['name'];
            $_SESSION['img'] = $_POST['imgsrc'];

            echo <<<js
                <script>
                    window.location.href = "account_main.php";
                </script>
js;
        } catch (PDOException $e) {
            die("PDO Error:" . $e->getMessage());
        }
    } else {
        setting($evalue);
    }



    function setting($evalue)
    {

        unset($_SESSION["file_img"]);
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
            }
            echo <<< MOD
        <header id="top">
         <a href="question.php"><img src='img/q.png' class='q'></a>
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
            <h2>アカウント設定</h2>
        </div>

        <div class="evalue">$evalue</div>

        <form class=setting_form action="" id=updateform method="POST" enctype="multipart/form-data">

            <div class="group">
                <input id='name' class='input_text name set_input' type="text" name="name" placeholder="ニックネーム">
                 <p class="alert">※12文字以内</p>
            </div>

            <div class="group">
                 <input id='pass' class='input_text pass set_input2' type="text" name="pass" placeholder="パスワード">
                 <p class="alert">※英数字６文字以上20文字未満</p>
            </div>

            <div class='img_wrap'>
                <div id='pv' class='pv_img'></div>
                <label class="setting_label">
                    <div class="file_img">
                        <input type="file" name="img" id="file_img" class="set_input3" accept="image/*">
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