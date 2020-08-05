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
    <title>ろくまる農園 スタッフ追加完了</title>
</head>
<body>
    <?php
         // 外部参照
         require_once('../common/common.php');
         $post = sanitize($_POST);

         // データベースサーバーのエラートラップ
        try {
            // 前画面から受け取ったデータを変数にコピー
            $staff_name = $post['name'];
            $staff_pass = $post['pass'];

            /* デバッグ用
            print $staff_name.'<br />';
            print $staff_pass.'<br />';
            exit();
            */

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってレコードを追加する
            $sql = 'INSERT INTO mst_staff(name,password) VALUES (?,?)';
            $stmt = $dbh->prepare($sql);
            $data[] = $staff_name;
            $data[] = $staff_pass;
            $stmt->execute($data);

            // データベースから切断する
            $dbh = null;

            // 「〇〇さんを追加しました」を画面に表示する
            print "$staff_name さんを追加しました。<br />";

        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>

    <a href="staff_list.php">戻る</a>
</body>
</html>