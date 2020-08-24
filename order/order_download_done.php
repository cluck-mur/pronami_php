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
            $year = $_POST['year'];
            $month = $_POST['month'];
            $day = $_POST['day'];

            // データベースに接続
            $dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
            $user = 'root';
            $password = '';
            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL文を使ってデータベースからスタッフリストを取得する
            $sql = '
            SELECT
                dat_sales.code,
                dat_sales.date,
                dat_sales.code_member,
                dat_sales.name AS dat_sales_name,
                dat_sales.email,
                dat_sales.postal1,
                dat_sales.postal2,
                dat_sales.address,
                dat_sales.tel,
                dat_sales_product.code_product,
                mst_product.name AS mst_product_name,
                dat_sales_product.price,
                dat_sales_product.quantity
                
            FROM 
                dat_sales, dat_sales_product, mst_product
            WHERE
                dat_sales.code = dat_sales_product.code_sales
                AND dat_sales_product.code_product = mst_product.code
                AND substr(dat_sales.date, 1, 4) = ?
                AND substr(dat_sales.date, 6, 2) = ?
                AND substr(dat_sales.date, 9, 2) = ?';
            $stmt = $dbh->prepare($sql);
            $data[] = $year;
            $data[] = $month;
            $data[] = $day;
            $stmt->execute($data);

            // データベースから切断する
            $dbh = null;

            $csv = '注文コード,注文日時,会員番号,お名前,メール,郵便番号,住所,TEL,商品コード,商品名,価格,数量';
            $csv .= "\n";
            while (true) {
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec == false) {
                    break;
                }
                $csv .= $rec['code'];
                $csv .= ',';
                $csv .= $rec['date'];
                $csv .= ',';
                $csv .= $rec['code_member'];
                $csv .= ',';
                $csv .= $rec['dat_sales_name'];
                $csv .= ',';
                $csv .= $rec['email'];
                $csv .= ',';
                $csv .= $rec['postal1'];
                $csv .= ',';
                $csv .= $rec['postal2'];
                $csv .= ',';
                $csv .= $rec['address'];
                $csv .= ',';
                $csv .= $rec['tel'];
                $csv .= ',';
                $csv .= $rec['code_product'];
                $csv .= ',';
                $csv .= $rec['mst_product_name'];
                $csv .= ',';
                $csv .= $rec['price'];
                $csv .= ',';
                $csv .= $rec['quantity'];
                $csv .= "\n";
            }

            // CSVの内容を画面に出力する
            //print nl2br($csv);
            /**
             * CSVファイルに出力する
             */
            $file = fopen('./chumon.csv', 'w');
            $csv = mb_convert_encoding($csv, 'SJIS', 'UTF-8');
            fputs($file, $csv);
            fclose($file);

        } catch (Exception $e) {
            print 'ただいま障害により大変ご迷惑をお掛けしております。';
            print $e.'<br />';
            // 強制終了
            exit();
        }

    ?>
    <a href="chumon.csv">注文データのダウンロード</a><br />
    <br />
    <a href="order_download.php">日付選択へ</a><br />
    <br />
    <a href="../staff_login/staff_top.php">トップメニューへ</a>
    
</body>
</html>