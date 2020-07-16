<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 スタッフリスト</title>
</head>
<body>
<?php
        // データベースサーバーのエラートラップ
        try {
            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってデータベースからスタッフリストを取得する
            $sql = 'SELECT name FROM mst_staff WHERE 1';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // データベースから切断する
            $dbh = null;

            // スタッフ一覧を表示する
            print 'スタッフ一覧<br /><br />';

            while (true) {
                // $stmtから1レコード取り出す
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rec == false) {
                    break;
                }
                print $rec['name'];
                print '<br />';
            }
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>
</body>
</html>