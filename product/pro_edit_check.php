<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 商品情報修正チェック</title>
</head>
<body>
    <?php
        // 前画面からデータを受け取る
        $pro_code = $_POST['code'];
        $pro_name = $_POST['name'];
        $pro_price = $_POST['price'];
        $pro_gazou_name_old = $_POST['gazou_name_old'];
        $pro_gazou = $_FILES['gazou'];

        // 入力データへ安全対策を施す
        $pro_code = htmlspecialchars($pro_code, ENT_QUOTES, 'UTF-8');
        $pro_name = htmlspecialchars($pro_name, ENT_QUOTES, 'UTF-8');
        $pro_price = htmlspecialchars($pro_price, ENT_QUOTES, 'UTF-8');

        if ($pro_name == '') {
            // もし商品名が入力されていなかったら "商品名が入力されていません" と表示する
            print "商品名が入力されていません<br />";
        } else {
            // もし商品名が入力されていたら商品名を表示する
            print "商品名：$pro_name<br />";
        }

        if (preg_match('/\A[0-9]+\z/', $pro_price) == 0) {
            // もし半角数字以外が入力されていたら "価格をきちんと入力してください。" と表示する
            print "価格をきちんと入力してください。<br />";
        } else {
            print "価格：$pro_price<br />";
        }

        if ($pro_gazou['size'] > 0) {
            if ($pro_gazou['size'] > 1000000) {
                print '画像サイズが大きすぎます';
            } else {
                // 画像を[gazou]フォルダにアップロードする
                move_uploaded_file($pro_gazou['tmp_name'],'./gazou/'.$pro_gazou['name']);
                // アップロードした画像を表示
                print '<img src="./gazou/'.$pro_gazou['name'].'">';
                print '<br />';
            }
        }

        if ($pro_name == '' || preg_match('/\A[0-9]+\z/', $pro_price) == 0 || $pro_gazou['size'] > 1000000) {
            // もし入力に問題があったら "戻る"ボタンだけを表示する
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '</form>';
        } else {
            print '上記のように変更します。<br />';
            print '<form method="post" action="pro_edit_done.php">';
            print '<input type="hidden" name="code" value='.$pro_code.'>';
            print '<input type="hidden" name="name" value='.$pro_name.'>';
            print '<input type="hidden" name="price" value='.$pro_price.'>';
            print '<input type="hidden" name="gazou_name_old" value='.$pro_gazou_name_old.'>';
            print '<input type="hidden" name="gazou_name" value='.$pro_gazou['name'].'>';

            print '<br />';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '<input type="submit" value="OK">';
            print '</form>';
        }
    ?>
</body>
</html>