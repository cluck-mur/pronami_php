<?php
    /**
     * セッションチェック
     */
    // セッション開始
    session_start();
    // ページを変える度に合言葉を変える
    session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 ご注文手続き継続</title>
</head>
<body>
    <?php
        try {
            // 共通関数を読み込む
            require_once("../common/common.php");
            // 安全対策
            $post = sanitize($_POST);
            // 前画面での入力値を変数へ代入
            $onamae = $post['onamae'];
            $email = $post['email'];
            $postal1 = $post['postal1'];
            $postal2 = $post['postal2'];
            $address = $post['address'];
            $tel = $post['tel'];

            //**********************************
            // メール本文を変数に格納 (ここから)
            $honbun = '';   // 初期化
            $honbun .= $onamae."様\n\nこのたびはご注文ありがとうございました。\n";
            $honbun .= "\n";
            $honbun .= "ご注文商品\n";
            $honbun .= "--------------\n";

            $cart = $_SESSION['cart'];
            $kazu = $_SESSION['kazu'];
            $max = count($cart);

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            for ($i = 0; $i < $max; $i++) {
                $sql = 'SELECT name, price FROM mst_product WHERE code=?';
                $stmt = $dbh->prepare($sql);
                $data[0] = $cart[$i];
                $stmt->execute($data);

                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                $name = $rec['name'];
                $price = $rec['price'];
                $suryo = $kazu[$i];
                $shokei = $price * $suryo;

                $honbun .= $name." ";
                $honbun .= $price."円 x ";
                $honbun .= $suryo."個 = ";
                $honbun .= $shokei."円\n";
            }

            /*
             * 注文データをDBの注文テーブルと注文詳細テーブルに追加する
             */
            $sql = 'INSERT INTO data_sales (code_member, name, email, postal1, postal2, address, tel) VALUES (?,?,?,?,?,?,?)';
            $stmt = $dbh->prepare($sql);
            $data = array();    // 配列クリア
            $data[] = 0;    // 会員コード
            $data[] = $onamae;
            $data[] = $email;
            $data[] = $postal1;
            $data[] = $postal2;
            $data[] = $address;
            $data[] = $tel;
            $stmt->execute($data);

            /*
             * 注文コードを取り出す
             */
            $sql = 'SELECT LAST_INSERT_ID()';
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastcode = $rec['LAST_INSERT_ID()'];

            // DB切断
            $dbh = null;

            $honbun .= "送料は無料です。\n";
            $honbun .= "--------------\n";
            $honbun .= "\n";
            $honbun .= "代金は以下の口座にお振込みください。\n";
            $honbun .= "ろくまる銀行 やさい支店 普通口座 1234567\n";
            $honbun .= "\n";
            $honbun .= "□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□\n";
            $honbun .= "　～安心野菜のろくまる農園～\n";
            $honbun .= "\n";
            $honbun .= "〇〇件六丸郡六丸村 123-4\n";
            $honbun .= "電話 090-6060-xxxx\n";
            $honbun .= "メール info@rokumarunouen.co.jp\n";
            $honbun .= "□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□□\n";
            //
            // メール本文を変数に格納 (ここまで)
            //**********************************
            /*
            print '<br />';
            print nl2br($honbun);
            */

            /*
             * お客様へメールを送信する
             */
            $title = 'ご注文ありがとうございます。';
            $header = 'From: info@rokumarunouen.co.jp';
            $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail($email, $title, $honbun, $header);

            /*
             * お店側へメールを送信する
             */
            $title = 'お客様からご注文がありました。';
            $header = 'From: '.$email;
            $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            mb_send_mail('info@rokumarunouen.co.jp', $title, $honbun, $header);

            print $onamae.'様<br />';
            print 'ご注文ありがとうございました。<br />';
            print $email.'にメールを送りましたのでご確認ください。<br />';
            print $postal1.'-'.$postal2.'<br />';
            print $address.'<br />';
            print $tel.'<br />';
        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }
    ?>
</body>
</html>