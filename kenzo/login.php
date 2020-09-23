<?php
session_start();

if (isset($_POST["hidden"])) {
    try {
        $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
        // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
        // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = $_POST["name"];
        $pass = $_POST["pass"];


        $qq = "SELECT COUNT(*) FROM kenzo_account WHERE name='$name' AND pass='$pass'";

        $q = $db->query($qq);
        $kensyo = $q->fetchColumn();

        if (!$kensyo == 1) {
            $error[] = "<p class='error'>アカウント名またはパスワードが違います</p>";
        }
    } catch (PDOException $e) {
        die("PDO Error:" . $e->getMessage());
    }


    $errors = count($error);
    if ($errors > 0) {
        foreach ($error as $value) {

            $evalue = $value . "<br>";
        }
        yoyaku($value);
    } else if ($kensyo == 1) {

        try {
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
            $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
            // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
            // $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');


            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM kenzo_account WHERE name='$name' AND pass='$pass'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            foreach ($stmt as $val) {
                $_SESSION["id"] = $val["id"];
                $_SESSION["name"] = $val["name"];

                $_SESSION["img"] = $val["img"];
            }

            echo <<<ZIBUN
               
                <div class="hhh">
                    <h1 class="en">LOGIN</h1>
                    <p>ログイン</p>
                </div>

                <div class=""><h2>ログイン完了</h2></div>
                <p>{$_SESSION["name"]}さん</p>
                <a href="account_main.php">トップへ</a>
ZIBUN;
        } catch (PDOException $e) {
            die("PDO Error:" . $e->getMessage());
        }
    }
} else {
    yoyaku($evalue);
}




function yoyaku($evalue)
{
    echo <<<login
    <div class="login">
        
        <div class="hhh">
            <h1 class="en">LOGIN</h1>
            <p>ログイン</p>
        </div>
        <div class="evalue">$evalue</div>
        <form id="form" action="$_SERVER[SCRIPT_NAME]" method="POST">
            <input type="text" id="pass" name="name" required="required" placeholder="お名前">
            <input type="password" id="pass" name="pass" required="required" placeholder="パスワード">
            
            <input type="hidden" name="hidden">
            <input type="submit" id="submit" value="ログイン">
        </form>
        <a href="touroku.php">アカウントない人新規登録</a>
    </div>
    
login;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta name="robots" content="nofollow">
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="css/index.css">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <title>ログイン</title>
</head>

<body>



</body>

</html>