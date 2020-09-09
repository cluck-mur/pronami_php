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
        print '商品を評価していただくにはログインが必要です。<br /><br />';
        print '<form>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '</form>';
        exit();
        
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
    <title>ろくまる農園 商品評価フォーム継続</title>
</head>
<body>
    <?php
        try {
            // 共通関数を読み込む
            require_once("../common/common.php");
            // 安全対策
            $post = sanitize($_POST);
            // 前画面での入力値を変数へ代入
            $pro_code = $post['procode'];
            $pro_name = $post['proname'];
            $pro_price = $post['proprice'];
            $pro_gazou_name = $post['progazouname'];
            $pro_rating = $post['prorating'];
            $pro_comment = $post['procomment'];
    
            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /*
             * DBをロックする
             */
            $sql = 'LOCK TABLES dat_rating WRITE';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            /**
             * 商品評価データを登録する
             */
            $lastmembercode = 0;
            $sql = 'INSERT INTO dat_rating (code_product, code_member, rating, comment) VALUE (?, ?, ?, ?)';
            $stmt = $dbh->prepare($sql);
            $data = array();    // 配列クリア
            $data[] = $pro_code;
            $data[] = $_SESSION['member_code'];
            $data[] = $pro_rating;
            $data[] = $pro_comment;
            $stmt->execute($data);

            /*
            * DBが割り振った注文コードをDBから取り出す
            */
            $sql = 'SELECT LAST_INSERT_ID()';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastmembercode = $rec['LAST_INSERT_ID()'];

            /*
             * DBロックを解除する
             */
            $sql = 'UNLOCK TABLES';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // DB切断
            $dbh = null;

            print '商品評価を登録しました。ありがとうございました。<br />';
            print '<br />';

            /**
             * 商品一覧画面に戻る
             */
            //print '<a href="shop_product.php?procode='.$pro_code.'">商品情報画面へ</a>';
            print '<a href="shop_list.php">商品一覧画面へ</a>';
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }
    ?>
</body>
</html>