<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 商品リスト</title>
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
            $sql = 'SELECT code, name, price FROM mst_product WHERE 1';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // データベースから切断する
            $dbh = null;

            //
            // 商品一覧を表示する
            //
            print '商品一覧<br /><br />';
            // 分岐画面へ移行する
            print '<form method="post" action="pro_branch.php">';

            while (true) {
                // $stmtから1レコード取り出す
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rec == false) {
                    break;
                }
                // ラジオボタンで商品を選べるようにする
                print '<input type="radio" name="procode" value="'.$rec['code'].'">';
                print $rec['name'].'---';
                print $rec['price'].'円';
                print '<br />';
            }
            print '<input type="submit" name="disp" value="参照">';
            print '<input type="submit" name="add" value="追加">';
            print '<input type="submit" name="edit" value="修正">';
            print '<input type="submit" name="delete" value="削除">';
            print '</form>';
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>
    <br />
    <a href="../staff_login/staff_top.php">トップメニューへ</a>

</body>
</html>