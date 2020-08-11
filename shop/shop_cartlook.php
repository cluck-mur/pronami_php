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
            if (isset($_SESSION['cart']) == true) {
                // セッションからカート情報を取り出す
                $cart = $_SESSION['cart'];
                $kazu = $_SESSION['kazu'];
                $max = count($cart);
            } else {
                $max = 0;
            }

            if ($max == 0) {
                print 'カートに商品が入っていません。<br />';
                print '<br />';
                print '<a href="shop_list.php">商品一覧へ戻る</a>';
                exit();
            }

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
    <form method="post" action="kazu_change.php">
    <br />
    <a href="shop_form.html">ご購入手続きへ進む</a><br />
    <table border="1">
    <tr>
    <td>商品</td>
    <td>商品画像</td>
    <td>価格</td>
    <td>数量</td>
    <td>小計</td>
    <td>削除</td>
    </tr>
    <?php for ($i = 0; $i < $max; $i++) { ?>
        <tr>
        <td><?php print $pro_name[$i]; ?></td>
        <td><?php print $pro_gazou[$i]; ?></td>
        <td><?php print $pro_price[$i].'円'; ?></td>
        <td><input type="text" name="kazu<?php print $i; ?>" value="<?php print $kazu[$i]; ?>"></td>
        <td><?php print $pro_price[$i] * $kazu[$i]; ?>円</td>
        <td><input type="checkbox" name="sakujyo<?php print $i; ?>"></td>
        <br />
        </tr>
    <?php } ?>
    </table>

        <input type="hidden" name="max" value="<?php print $max; ?>">
        <input type="submit" value="数量変更"><br />
        <input type="button" onclick="history.back()" value="戻る">
    </form>
    
</body>
</html>