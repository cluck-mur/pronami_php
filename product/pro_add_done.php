<?php
    /**
     * セッションチェック
     */
    // セッション開始
    session_start();
    // ページを変える度に合言葉を変える
    session_regenerate_id(true);
    if (isset($_SESSION['login']) == false) {
        /**
         * もしログインの証拠がなかったら
         */
        print 'ログインされていません。<br />';
        print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
        // ここでプログラムを強制的に終了
        exit();
    } else {
        // スタッフの名前を表示する
        print $_SESSION['staff_name'].'さんログイン中<br /><br />';
    }
?>
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
            $pro_name = $_POST['name'];
            $pro_price = $_POST['price'];
            $pro_gazou_name = $_POST['gazou_name'];

            /* デバッグ用
            print $pro_name.'<br />';
            print $pro_price.'<br />';
            exit();
            */

            // 入力データに安全対策を施す
            $pro_name = htmlspecialchars($pro_name, ENT_QUOTES, 'UTF-8');
            $pro_price = htmlspecialchars($pro_price, ENT_QUOTES, 'UTF-8');

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってレコードを追加する
            $sql = 'INSERT INTO mst_product(name,price,gazou) VALUES (?,?,?)';
            $stmt = $dbh->prepare($sql);
            $data[] = $pro_name;
            $data[] = $pro_price;
            $data[] = $pro_gazou_name;
            $stmt->execute($data);

            // データベースから切断する
            $dbh = null;

            // 「〇〇を追加しました」を画面に表示する
            print "$pro_name を追加しました。<br />";

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