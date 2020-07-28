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
    <title>ろくまる農園 スタッフ修正チェック</title>
</head>
<body>
    <?php
        // 前画面からデータを受け取る
        $staff_code = $_POST['code'];
        $staff_name = $_POST['name'];
        $staff_pass = $_POST['pass'];
        $staff_pass2 = $_POST['pass2'];

        // 入力データへ安全対策を施す
        $staff_name = htmlspecialchars($staff_name, ENT_QUOTES, 'UTF-8');
        $staff_pass = htmlspecialchars($staff_pass, ENT_QUOTES, 'UTF-8');
        $staff_pass2 = htmlspecialchars($staff_pass2, ENT_QUOTES, 'UTF-8');

        if ($staff_name == '') {
            // もしスタッフ名が入力されていなかったら "スタッフ名が入力されていません" と表示する
            print "スタッフ名が入力されていません<br />";
        } else {
            // もしスタッフ名が入力されていたらスタッフ名を表示する
            print "スタッフ名：$staff_name<br />";
        }

        if ($staff_pass == '') {
            // もしパスワードが入力されていなかったら "パスワードが入力されていません" と表示する
            print "パスワードが入力されていません<br />";
        }

        if ($staff_pass != $staff_pass2) {
            // もし１回目のパスワードと2回目のパスワードが一致しなかったら "パスワードが一致しません" と表示する
            print "パスワードが一致しません<br />";
        }

        if ($staff_name == '' || $staff_pass == '' || $staff_pass != $staff_pass2) {
            // もし入力に問題があったら "戻る"ボタンだけを表示する
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '</form>';
        } else {
            $staff_pass = md5($staff_pass);
            print '<form method="post" action="staff_edit_done.php">';
            print '<input type="hidden" name="code" value='.$staff_code.'>';
            print '<input type="hidden" name="name" value='.$staff_name.'>';
            print '<input type="hidden" name="pass" value='.$staff_pass.'>';
            print '<br />';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '<input type="submit" value="OK">';
            print '</form>';
        }
    ?>
</body>
</html>