<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/index.css">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/index.js"></script>
    <title>新規登録</title>
</head>

<body>





</body>

</html>

<?php
// 二番目処理ーーーーーーーーーーーーーーーーーーーーーー
if (isset($_POST["hidden"]) && !isset($_POST["hidden2"])) {


    // 配列errorにエラー内容を挿入ーーーーーーーーーーーーー

    if ($_POST["name"] == "") {
        $error[] = "<p class='error'>名前を入力してください</p>";
    }

    if ($_POST["pass"] == "") {
        $error[] = "<p class='error'>パスワードを入力してください</p>";
    }

    try {
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
        // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
        $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $name = htmlentities($_POST["name"]);
        $pass = htmlentities($_POST["pass"]);

        $qq = "SELECT COUNT(*) FROM kenzo_account WHERE pass='$pass'";
        $q = $db->query($qq);
        $kensyo = $q->fetchColumn();


        if ($kensyo > 0) {
            $error[] = "<p class='error'>そのパスワードはすでに使用されてます</p>";
        }

        $qq = "SELECT COUNT(*) FROM kenzo_account WHERE id='$id'";
        $q = $db->query($qq);
        $kensyo = $q->fetchColumn();


        if ($kensyo > 0) {
            $error[] = "<p class='error'>そのIDはすでに使用されてます</p>";
        }
    } catch (PDOException $e) {
        die("PDO Error:" . $e->getMessage());
    }




    $errors = count($error);

    // もし配列errorに一つでもエラー内容が入っていたらエラーを表示してまた登録画面へーーー
    if ($errors > 0) {

        foreach ($error as $value) {

            $evalue = $value . "<br>";
        }
        yoyaku($value);
    } else {
        $name = htmlentities($_POST["name"]);
        $pass = htmlentities($_POST["pass"]);
        $id = htmlentities($_POST["id"]);

        echo <<<KAKUNIN
        <div class="hhh">
            <h1 class="en">REGISTAR</h1>
            <p>新規登録</p>
            <div class="rogin_touroku_style">
            <a href="login.php" class="a_style"><i class="fa fa-sign-out" id="img4"></i></a>
                    </li>
            <a href='login.php'>ログイン</a>
             </div>
        </div>
        <div class="toroku">
            <hgroup>
                <h1>この内容で登録しますか？</h1>
            </hgroup>
            <form id="form" action="$_SERVER[SCRIPT_NAME]" method="POST">

                <div class="group">
                    <input type="text" id="kakunin" name="name" value="$name" readonly>
                </div>

                <div class="group">
                    <input type="pass" id="kakunin"  name="pass" value="$pass" readonly>
                </div>

                <div class="group">
                    <input type="text" id="kakunin"  name="id" value="$id" readonly>
                </div>
                

                <input type="hidden" name="hidden2">
                <input type="submit" id="submit" value="確定">
                
                <button class="back"><a href="$_SERVER[SCRIPT_NAME]">やり直す</a></button>
            </form>
        </div>
KAKUNIN;
    }
} else if (isset($_POST["hidden2"])) {

    // 登録完了画面　データベースへデータを入れるーーーーーーーーーーーーーー
    try {
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
        // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
        $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = htmlentities($_POST["name"]);
        $pass = htmlentities($_POST["pass"]);
        $id = htmlentities($_POST["id"]);


        $img = "hito.png";


        $stmt = $db->prepare(
            'INSERT INTO kenzo_account(name,pass,id,img)' .
                'VALUES(:name,:pass,:id,:img)'
        );


        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':img', $img);


        $stmt->execute();



        $query = "CREATE TABLE " . "tomo_" . $id . "(id VARCHAR(255))";
        $db->query($query);

        echo <<<TEXT
                <div class="hhh">
                    <h1 class="en">REGISTAR</h1>
                    <p>新規登録</p>
                </div>

                <div class="tx">
                    <h2>登録が完了しました</h2>
            <div class="rogin_touroku_style1">
                <a href="login.php" class="a_style"><i class="fa fa-sign-out" id="img4"></i></a></li>
                <a href='login.php'>ログイン</a>
             </div>
                </div>


TEXT;
    } catch (PDOException $e) {
        die("PDO Error:" . $e->getMessage());
    }
} else {
    yoyaku($evalue);
}





function yoyaku($evalue)
{


    try {
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
        // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
        $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("PDO Error:" . $e->getMessage());
    }


    echo <<<END
        <div class="hhh">
            <h1 class="en">REGISTAR</h1>
            <p>新規登録</p>
            <div class="rogin_touroku_style">
            <a href="login.php" class="a_style"><i class="fa fa-sign-out" id="img4"></i></a>
                    </li>
            <a href='login.php'>ログイン</a>
             </div>
        </div>
        <div class="toroku">
            <div class="evalue">$evalue</div>
            <hgroup>
                
            </hgroup>
            <form id="form" action="$_SERVER[SCRIPT_NAME]" method="POST">
                <div class="group">
                    <input type="text" id="name" name="name" placeholder="お名前" required="required">
                </div>
                <div class="group">
                    <input type="password" id="pass" name="pass" placeholder="パスワード"  required="required">
                <p class="touroku_p_style">※英数字６文字以上20文字未満</p>
                </div>
                <div class="group">
                    <input type="text" id="id" name="id" placeholder="ID" required="required">
                <p class="touroku_p_style">※英数字６文字以上20文字未満</p>
                </div>
                <input type="hidden" name="hidden">
                <div class="touroku_submit">
                <input type="submit" id="submit" value="登録する">
                </div>
                </div>

        
                
            </form>
        </div>
       

END;
}


?>