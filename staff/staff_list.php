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
    <title>ろくまる農園 スタッフリスト</title>
</head>
<body>
    <?php
        // データベースサーバーのエラートラップ
        try {
            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってデータベースからスタッフリストを取得する
            $sql = 'SELECT code, name FROM mst_staff WHERE 1';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            // データベースから切断する
            $dbh = null;

            //
            // スタッフ一覧を表示する
            //
            print 'スタッフ一覧<br /><br />';
            // 分岐画面へ移行する
            print '<form method="post" action="staff_branch.php">';

            while (true) {
                // $stmtから1レコード取り出す
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($rec == false) {
                    break;
                }
                // ラジオボタンでスタッフを選べるようにする
                print '<input type="radio" name="staffcode" value="'.$rec['code'].'">';
                print $rec['name'];
                print '<br />';
            }
            print '<input type="submit" name="disp" value="参照">';
            print '<input type="submit" name="add" value="追加">';
            print '<input type="submit" name="edit" value="修正">';
            print '<input type="submit" name="delete" value="削除">';
            print '</form>';
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>
    <br />
    <a href="../staff_login/staff_top.php">トップメニューへ</a>
    
</body>
</html>