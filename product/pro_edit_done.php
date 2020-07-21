<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 商品追加完了</title>
</head>
<body>
    <?php
        // データベースサーバーのエラートラップ
        try {
            // 前画面から受け取ったデータを変数にコピー
            $pro_code = $_POST['code'];
            $pro_name = $_POST['name'];
            $pro_price = $_POST['price'];

            /* デバッグ用
            print $pro_name.'<br />';
            print $pro_price.'<br />';
            exit();
            */

            // 入力データに安全対策を施す
            $pro_code = htmlspecialchars($pro_code, ENT_QUOTES, 'UTF-8');
            $pro_name = htmlspecialchars($pro_name, ENT_QUOTES, 'UTF-8');
            $pro_price = htmlspecialchars($pro_price, ENT_QUOTES, 'UTF-8');

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってレコードを追加する
            $sql = 'UPDATE mst_product SET name=?, price=? WHERE code=?';
            $stmt = $dbh->prepare($sql);
            $data[] = $pro_name;
            $data[] = $pro_price;
            $data[] = $pro_code;
            $stmt->execute($data);

            // データベースから切断する
            $dbh = null;

            // 「修正しました」を画面に表示する
            print "修正しました。<br />";

        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>

    <a href="pro_list.php">戻る</a>
</body>
</html>