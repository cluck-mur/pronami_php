<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 スタッフ修正or削除分岐</title>
</head>
<body>
    <?php
        // もしeditだったら
        if (isset($_POST['edit']) == true) {
            print '修正ボタンが押された';
        }
        // もしdeleteだったら
        if (isset($_POST['delete']) == true) {
            print '削除ボタンが押された';
        }
    ?>
</body>
</html>