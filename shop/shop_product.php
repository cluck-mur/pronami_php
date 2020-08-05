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
            // 選択された商品コードを受け取る
            $pro_code = $_GET['procode'];

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってデータベースからスタッフリストを取得する
            $sql = 'SELECT name, price, gazou FROM mst_product WHERE code=?';
            $stmt = $dbh->prepare($sql);
            $data[] = $pro_code;
            $stmt->execute($data);

            // 取得したデータを変数にコピー
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $pro_name = $rec['name'];
            $pro_price = $rec['price'];
            $pro_gazou_name = $rec['gazou'];

            // データベースから切断する
            $dbh = null;

            // もし画像ファイルがあったら表示のタグを準備する
            if ($pro_gazou_name == "") {
                $disp_gazou = "";
            } else {
                $disp_gazou = '<img src="../product/gazou/'.$pro_gazou_name.'">';
            }
            print '<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br /><br />';
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>

    商品情報参照<br />
    <br />
    商品コード<br />
    <?php
        print $pro_code;
    ?>
    <br />
    商品名<br />
    <?php
        print $pro_name;
    ?>
    <br />
    価格<br />
    <?php
        print $pro_price;
    ?>
    円
    <br />
    <?php print $disp_gazou; ?>
    <br />
    <br />
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>
    
</body>
</html>