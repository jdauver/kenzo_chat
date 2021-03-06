<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/index.css">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>ログイン</title>
</head>

<body>
</body>

</html>
<?php
if (isset($_POST["hidden"])) {
    try {
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', '1234');
        // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
        // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
        $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');


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
            // $db = new PDO('mysql:host=localhost; dbname=kenzo_chat', 'root', 'root');
            // $db = new PDO('mysql:host=127.0.0.1; dbname=kenzo_chat', 'root');
            $db = new PDO('mysql:host=mysql1.php.xdomain.ne.jp; dbname=jdauver_kenzo', 'jdauver_kawa', 'jannedolls1227');

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM kenzo_account WHERE name='$name' AND pass='$pass'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            foreach ($stmt as $val) {
                $_SESSION["id"] = $val["id"];
                $_SESSION["name"] = $val["name"];

                $_SESSION["img"] = $val["img"];
                $_SESSION["back"] = $val["back"];
            }

            echo <<<ZIBUN
               
                <div class="hhh">
                    <h1 class="en">LOGIN</h1>
                    <p>ログイン</p>
                </div>

                <div class="login_kanryou"><h2>ログイン完了</h2>
                <p>{$_SESSION["name"]}さん</p>
                <a href="account_main.php">トップへ</a>
                </div>
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
            <div class="rogin_touroku_style">
             <a href="touroku.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>新規登録</a>
             </div>
        </div>
        <div class="evalue">$evalue</div>
        <form id="form" action="$_SERVER[SCRIPT_NAME]" method="POST">
            <input type="text" id="login_name" name="name" required="required" placeholder="お名前">
            <input type="password" id="login_pass" name="pass" required="required" placeholder="パスワード">
            
            <input type="hidden" name="hidden">
            <div class="touroku_submit">
            <input type="submit" id="submit" value="ログイン">
            </div>
        </form>
    </div>
    
login;
}
?>