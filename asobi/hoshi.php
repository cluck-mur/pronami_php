<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ろくまる農園 星表示</title>
</head>
<body>
    <?php
        $mbango = $_POST['mbango'];

        $hosi['M1'] = 'カニ星雲';
        $hosi['M31'] = 'アンドロメダ大星雲';
        $hosi['M42'] = 'オリオン大星雲';
        $hosi['M45'] = 'すばる';
        $hosi['M57'] = 'ドーナツ星雲';

        foreach ($hosi as $key => $val) {
            print $key.'は'.$val;
            print '<br />';
        }

        print 'あなたが選んだ星は、'.$hosi[$mbango];        
    ?>
</body>
</html>