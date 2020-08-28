<?php
    // 外部参照
    require_once('../common/common.php');
    $post = sanitize($_POST);

    try {
        // 前画面から受け取ったデータを変数にコピー
        $member_email = $post['email'];
        $member_pass = $post['pass'];

        // パスワードをハッシュ化する
        $member_pass = md5($member_pass);

        // データベースに接続
        $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL文を使って指定されたスタッフのデータを取得する
        $sql = 'SELECT code, name FROM dat_member WHERE email=? AND password=?';
        $stmt = $dbh->prepare($sql);
        $data[] = $member_email;
        $data[] = $member_pass;
        $stmt->execute($data);

        // データベースから切断する
        $dbh = null;

        // 取得したデータを変数にコピー
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);

        // 認証チェック
        if ($rec == false) {
            /**
             * スタッフデータをDBから取得する処理が失敗した場合
             **/
            print 'メールアドレスかパスワードが間違っています。<br />';
            print '<a href="member_login.html">戻る</a>';
        } else {
            /**
             * スタッフデータをDBから取得する処理が成功した場合
             **/
            // セッションにログインOKという証拠を残す
            session_start();
            $_SESSION['member_login'] = 1;
            $_SESSION['member_code'] = $rec['code'];
            $_SESSION['member_name'] = $rec['name'];
            header('Location:shop_list.php');
            exit();
        }
        
    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        print $e.'<br />';
        // 強制終了
        exit();
    }
?>
