<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/index.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <title>友達検索ページ</title>
</head>

<body>
    <header id="account_header">
        <nav id="account_nav">
            <ul><a href="account_main.php">HOME</a></ul>
            <ul><a href="friend_search.php">友達追加</a></ul>
            <ul><a href="setting.php">設定</a></ul>
        </nav>
    </header>
    <section>
        <form action="friend_search.php" method="POST">
            <input type="text" placeholder="ID検索" name="id" required>
            <input type="submit" value="OK" name="submit">
        </form>
    </section>
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
           <input type='submit' name='ok' class='friendinput' value='登録'>
           <input type='submit' name='ng' class='friendinput' value='やめる'><br>
           </form>
FTOUROKU;
            }

            if ($row == 0) {
                echo "該当なし";
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
           <input type='submit' id='talkjump' class='friendinput' value='トーク'>
           <input type='submit' class='friendinput' value='もどる'><br>
FTOUROKU;
    } catch (PDOException $e) {
        die("PDO Error:" . $e->getMessage());
    }
}


?>