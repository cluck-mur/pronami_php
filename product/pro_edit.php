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
    <title>ろくまる農園 商品情報修正</title>
</head>
<body>
<?php
        // データベースサーバーのエラートラップ
        try {
            // 選択されたスタッフコードを受け取る
            $pro_code = $_GET['procode'];

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってデータベースから商品リストを取得する
            $sql = 'SELECT name, price, gazou FROM mst_product WHERE code=?';
            $stmt = $dbh->prepare($sql);
            $data[] = $pro_code;
            $stmt->execute($data);

            // 取得したデータを変数にコピー
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $pro_name = $rec['name'];
            $pro_price = $rec['price'];
            $pro_gazou_name_old = $rec['gazou'];

            // データベースから切断する
            $dbh = null;

            // 画像があったら表示タグを生成しておく
            if ($pro_gazou_name_old == '') {
                $disp_gazou = '';
            } else {
                $disp_gazou = '<img src="./gazou/'.$pro_gazou_name_old.'">';
            }


        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>

    商品修正<br />
    <br />
    商品コード<br />
    <?php
        print $pro_code;
    ?>
    <br />
    <form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
        <input type="hidden" name="code" value="<?php print $pro_code; ?>"><br />
        <input type="hidden" name="gazou_name_old" value="<?php print $pro_gazou_name_old; ?>"><br />
        商品名<br />
        <input type="text" name="name" style="width:200px" value="<?php print $pro_name; ?>"><br />
        価格<br />
        <input type="text" name="price" style="width:50px" value="<?php print $pro_price; ?>"><br />
        <br />
        <?php print $disp_gazou; ?>
        <br />
        画像を選んでください。<br />
        <input type="file" name="gazou" style="width:400px"><br />
        <br />
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>
    
</body>
</html>