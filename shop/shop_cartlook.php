<?php
    /**
     * セッションチェック
     */
    // セッション開始
    session_start();
    // ページを変える度に合言葉を変える
    session_regenerate_id(true);
    if (isset($_SESSION['member_login']) == false) {
        /**
         * もしログインの証拠がなかったら
         */
        print 'ようこそゲスト様　';
        print '<a href="member_login.html">会員ログイン</a><br />';
        print '<br />';
    } else {
        print 'ようこそ';
        print $_SESSION['member_login'];
        print '様　';
        print '<a href="member_login.php">ログアウト</a><br />';
        print '<br />';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 商品詳細情報</title>
</head>
<body>
<?php
        // データベースサーバーのエラートラップ
        try {
            // セッションからカート情報を取り出す
            $cart = $_SESSION['cart'];
            $max = count($cart);

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            foreach ($cart as $key => $val) {
                $sql = 'SELECT code, name, price, gazou FROM mst_product WHERE code=?';
                $stmt = $dbh->prepare($sql);
                $data[0] = $val;
                $stmt->execute($data);

                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                $pro_name[] = $rec['name'];
                $pro_price[] = $rec['price'];
                if ($rec['gazou'] == '') {
                    $pro_gazou[] = '';
                } else {
                    $pro_gazou[] = '<img src="../product/gazou/'.$rec['gazou'].'">';
                }
            }
            // DB切断
            $dbh = null;
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>
    カートの中身<br />
    <br />
    <?php for ($i = 0; $i < $max; $i++) { ?>
        <?php print $pro_name[$i]; ?>
        <?php print $pro_gazou[$i]; ?>
        <?php print $pro_price[$i].'円'; ?>
        <br />
    <?php } ?>

    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>
    
</body>
</html>