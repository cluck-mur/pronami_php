<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 商品追加チェック</title>
</head>
<body>
    <?php
        // 前画面からデータを受け取る
        $pro_name = $_POST['name'];
        $pro_price = $_POST['price'];

        // 入力データへ安全対策を施す
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

        if ($pro_name == '' || preg_match('/\A[0-9]+\z/', $pro_price) == 0) {
            // もし入力に問題があったら "戻る"ボタンだけを表示する
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '</form>';
        } else {
            print '上記の商品を追加します。<br />';
            print '<form method="post" action="pro_add_done.php">';
            print '<input type="hidden" name="name" value='.$pro_name.'>';
            print '<input type="hidden" name="price" value='.$pro_price.'>';
            print '<br />';
            print '<input type="button" onclick="history.back()" value="戻る">';
            print '<input type="submit" value="OK">';
            print '</form>';
        }
    ?>
</body>
</html>