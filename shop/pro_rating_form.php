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
    <title>ろくまる農園 商品評価入力</title>
</head>
<body>
    <?php
        require_once('../common/common.php');
        $post = sanitize($_POST);
        $pro_code = $post['procode'];
        $pro_name = $post['proname'];
        $pro_price = $post['proprice'];
        $pro_gazou_name = $post['progazouname'];
        // もし画像ファイルがあったら表示のタグを準備する
        if ($pro_gazou_name == "") {
            $disp_gazou = "";
        } else {
            $disp_gazou = '<img src="../product/gazou/'.$pro_gazou_name.'">';
        }
    ?>

    商品評価<br />
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
    評価を入力してください<br />
    <form method="post" action="pro_rating_check.php">
        <input type="hidden" name="procode" value="<?php print $pro_code; ?>">
        <input type="hidden" name="proname" value="<?php print $pro_name; ?>">
        <input type="hidden" name="proprice" value="<?php print $pro_price; ?>">
        <input type="hidden" name="progazouname" value="<?php print $pro_gazou_name; ?>">
        <select name="prorating">
            <option value="5">5</option>
            <option value="4">4</option>
            <option value="3">3</option>
            <option value="2">2</option>
            <option value="1">1</option>
        </select>
        <br />
        <textarea name="procomment" rows="9" cols="60"" maxlength="256" style="margin:2pt 0pt"></textarea> 
        <br />
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>
    <!--
    <br />
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>
    -->
</body>
</html>