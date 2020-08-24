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
    <title>ろくまる農園 ショップ管理トップメニュー</title>
</head>
<body>
    ショップ管理トップメニュー<br />
    <br />
    <a href="../staff/staff_list.php">スタッフ管理</a>
    <br />
    <a href="../product/pro_list.php">商品管理</a>
    <br />
    <a href="../order/order_download.php">注文ダウンロード</a>
    <br />
    <a href="../staff_login/staff_logout.php">ログアウト</a>
</body>
</html>