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
    <title>ろくまる農園 商品評価フォームチェック</title>
</head>
<body>
    <?php
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

        // もし画像ファイルがあったら表示のタグを準備する
        if ($pro_gazou_name == "") {
            $disp_gazou = "";
        } else {
            $disp_gazou = '<img src="../product/gazou/'.$pro_gazou_name.'">';
        }

        // チェックフラグ
        $okflg = true;

        /*
        if ($onamae == '') {
            // 名前が入力されていない場合
            print 'お名前が入力されていません。<br /><br />';
            $okflg = false;
        } else {
            print 'お名前<br />';
            print $onamae;
            print '<br /><br />';
        }
        if (preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/', $email) == 0) {
            // メールアドレスが入力されていない場合
            print 'メールアドレスを正確に入力してください。<br /><br />';
            $okflg = false;
        } else {
            print 'メールアドレス<br />';
            print $email;
            print '<br /><br />';
        }
        if (preg_match('/\A[0-9]+\z/', $postal1) == 0) {
            // 郵便番号に半角数字以外が入力されている場合
            print '郵便番号は半角数字で入力してください。<br /><br />';
            $okflg = false;
        }
        if (preg_match('/\A[0-9]+\z/', $postal2) == 0) {
            // 郵便番号に半角数字以外が入力されている場合
            print '郵便番号は半角数字で入力してください。<br /><br />';
            $okflg = false;
        } else {
            print '郵便番号<br />';
            print $postal1;
            print '-';
            print $postal2;
            print '<br /><br />';
        }
        if ($address == '') {
            print '住所が入力されていません。<br /><br />';
            $okflg = false;
        } else {
            print '住所<br />';
            print $address;
            print '<br /><br />';
        }
        if (preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $tel) == 0) {
            print '電話番号を正確に入力してください。<br /><br />';
            $okflg = false;
        } else {
            print '電話番号<br />';
            print $tel;
            print '<br /><br />';
        }

        if ($chumon == 'chumontoroku') {
            if ($pass == '') {
                print 'パスワードが入力されていません。<br /><br />';
                $okflg = false;
            }

            if ($pass != $pass2) {
                print 'パスワードが一致しません。<br /><br />';
                $okflg = false;
            }

            print '性別<br />';
            if ($danjo == 'dan') {
                print '男性';
            } else {
                print '女性';
            }
            print '<br /><br />';

            print '生まれ年<br />';
            print $birth;
            print '年代';
            print '<br /><br />';
        }
        */

        print 'この評価で登録します。よろしいですか？<br /><br />';

        print 'あなたの評価<br />';
        print '5段階のうち<br />';
        print $pro_rating;
        print '<br />';
        print 'コメント<br />';
        print $pro_comment;
        print '<br /><br />';

        print '商品情報<br />';
        print '商品コード<br />';
        print $pro_code;
        print '<br />';
        print '商品名<br />';
        print $pro_name;
        print '<br />';
        print '価格<br />';
        print $pro_price;
        print '円';
        print '<br />';
        print $disp_gazou;
        print '<br />';
        if ($okflg == true) {
            print '<form method="post" action="pro_rating_done.php">';
            print '<input type="hidden" name="procode" value="'.$pro_code.'">';
            print '<input type="hidden" name="proname" value="'.$pro_name.'">';
            print '<input type="hidden" name="proprice" value="'.$pro_price.'">';
            print '<input type="hidden" name="progazouname" value="'.$pro_gazou_name.'">';
            print '<input type="hidden" name="prorating" value="'.$pro_rating.'">';
            print '<input type="hidden" name="procomment" value="'.$pro_comment.'">';

            print '<input type="button" onclick="history.back()" value="戻る">';
            print '<input type="submit" value="OK"><br />';
            print '</form>';
        } else {
            print '<form>';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '</form>';
        }
    ?>
</body>
</html>