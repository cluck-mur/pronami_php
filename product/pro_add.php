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
    <title>ろくまる農園 商品追加</title>
</head>
<body>
    商品追加<br />
    <br />
    <form method="post" action="pro_add_check.php" enctype="multipart/form-data">
        商品名を入力してください。<br />
        <input type="text" name="name" style="width:200px"><br />
        価格を入力してください。<br />
        <input type="text" name="price" style="width:50px"><br />
        画像を選んでください。<br />
        <input type="file" name="gazou" style="width:400px"><br />
        <br />
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>
</body>
</html>