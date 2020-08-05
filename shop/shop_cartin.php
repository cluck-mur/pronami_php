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
            $pro_code = $_GET['procode'];

            if (isset($_SESSION['cart']) == true) {
                // セッションからカート情報を取り出す
                $cart = $_SESSION['cart'];
            }
            // カートに商品を追加する
            $cart[] = $pro_code;
            // セッションにカート情報を保存 どの画面でもカートを見られるように
            $_SESSION['cart'] = $cart;

            /*
            foreach ($cart as $key => $val) {
                print $val;
                print '<br />';
            }
            */
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>
    カートに追加しました。<br />
    <br />
    <a href="shop_list.php">商品一覧に戻る</a>
</body>
</html>