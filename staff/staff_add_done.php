<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 スタッフ追加完了</title>
</head>
<body>
    <?php
        // データベースサーバーのエラートラップ
        try {
            // 前画面から受け取ったデータを変数にコピー
            $staff_name = $_POST['name'];
            $staff_pass = $_POST['pass'];

            /* デバッグ用
            print $staff_name.'<br />';
            print $staff_pass.'<br />';
            exit();
            */

            // 入力データに安全対策を施す
            $staff_name = htmlspecialchars($staff_name, ENT_QUOTES, 'UTF-8');
            $staff_pass = htmlspecialchars($staff_pass, ENT_QUOTES, 'UTF-8');

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってレコードを追加する
            $sql = 'INSERT INTO mst_staff(name,password) VALUES (?,?)';
            $stmt = $dbh->prepare($sql);
            $data[] = $staff_name;
            $data[] = $staff_pass;
            $stmt->execute($data);

            // データベースから切断する
            $dbh = null;

            // 「〇〇さんを追加しました」を画面に表示する
            print "$staff_name さんを追加しました。<br />";

        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>

    <a href="staff_list.php">戻る</a>
</body>
</html>