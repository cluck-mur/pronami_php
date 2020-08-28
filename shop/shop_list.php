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
        print $_SESSION['member_name'];
        print '様　';
        print '<a href="member_logout.php">ログアウト</a><br />';
        print '<br />';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 ショップ商品リスト</title>
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

            while (true) {
                // $stmtから1レコード取り出す
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rec == false) {
                    break;
                }
                // 商品のリンクを並べる
                print '<a href="shop_product.php?procode='.$rec['code'].'">';
                print $rec['name'].'---';
                print $rec['price'].'円';
                print '</a>';
                print '<br />';

            }
            // カートを見るへのリンク
            print '<br />';
            print '<a href="shop_cartlook.php">カートを見る</a><br />';
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>

</body>
</html>