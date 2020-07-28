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
    <title>ろくまる農園 スタッフ追加</title>
</head>
<body>
    スタッフ追加<br />
    <br />
    <form method="post" action="staff_add_check.php">
        スタッフ名を入力してください。<br />
        <input type="text" name="name" style="width:200px"><br />
        パスワードを入力してください。<br />
        <input type="password" name="pass" style="width:100px"><br />
        パスワードをもう一度入力してください。<br />
        <input type="password" name="pass2" style="width:100px"><br />
        <br />
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>
</body>
</html>