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

            /**
             * SQL文を使ってデータベースから商品情報を取得する
             */
            $sql = 'SELECT name, price, gazou FROM mst_product WHERE code=?';
            $stmt = $dbh->prepare($sql);
            $data[] = $pro_code;
            $stmt->execute($data);

            // 取得したデータを変数にコピー
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $pro_name = $rec['name'];
            $pro_price = $rec['price'];
            $pro_gazou_name = $rec['gazou'];

            /**
            * SQL文を使ってデータベースから商品評価情報を取得する
            */
            $sql = 'SELECT AVG(rating) AS pro_rating_avg, COUNT(rating) AS pro_rating_count FROM dat_rating WHERE code_product=?';
            $stmt = $dbh->prepare($sql);
            $data = array();
            $data[] = $pro_code;
            $stmt->execute($data);

            // 取得したデータを変数にコピー
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $pro_rating_avg = $rec['pro_rating_avg'];
            $pro_rating_count = $rec['pro_rating_count'];

            /**
            * SQL文を使ってデータベースから商品評価コメントを取得する
            */
            $sql = 'SELECT code_member, date, rating, comment FROM dat_rating WHERE code_product=? AND length(comment)>0 ORDER BY date DESC LIMIT 5';
            $stmt = $dbh->prepare($sql);
            $data = array();
            $data[] = $pro_code;
            $stmt->execute($data);

            // 取得したデータを変数にコピー
            $member_codes = array();
            $pro_rating_dates = array();
            $pro_ratings = array();
            $pro_rating_comments = array();

            $comment_count = 0;
            while (true) {
                // $stmtから1レコード取り出す
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rec == false) {
                    break;
                }

                $comment_count++;
                $member_codes[] = $rec['code_member'];
                $pro_rating_dates[] = $rec['date'];
                $pro_ratings[] = $rec['rating'];
                $pro_rating_comments[] = $rec['comment'];

            }

            /**
             * DBから会員名を取得
             */
            $member_names = array();
            for ($i = 0; $i < $comment_count; $i++) {
                $sql = 'SELECT name FROM dat_member WHERE code=?';
                $stmt = $dbh->prepare($sql);
                $data = array();
                $data[] = $member_codes[$i];
                $stmt->execute($data);
    
                // $stmtから1レコード取り出す
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                $member_names[] = $rec['name'];

            }

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
    評価<br />
    <?php
    print $pro_rating_avg;
    print '('.$pro_rating_count.')';
    ?>
    <form method="post" action="pro_rating_form.php">
        <input type="hidden" name="procode" value="<?php print $pro_code; ?>">
        <input type="hidden" name="proname" value="<?php print $pro_name; ?>">
        <input type="hidden" name="proprice" value="<?php print $pro_price; ?>">
        <input type="hidden" name="progazouname" value="<?php print $pro_gazou_name; ?>">
        <input type="submit" value="この商品を評価する"><br />
    </form>
    <br />
    購入者のコメント<br />
    <?php
    for($i = 0; $i < $comment_count; $i++) {
        $member_code = $member_codes[$i];
        $pro_rating_date = $pro_rating_dates[$i];
        $pro_rating = $pro_ratings[$i];
        $pro_rating_comment = $pro_rating_comments[$i];
        $member_name = $member_names[$i];

        print 'お名前<br />';
        print $member_name.'<br />';
        print '評価日付<br />';
        print $pro_rating_date.'<br />';
        print '評価<br />';
        print $pro_rating.'<br />';
        print 'コメント<br />';
        print $pro_rating_comment.'<br />';
        print '<br />';
    }
    ?>
    <br />
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>
    
</body>
</html>