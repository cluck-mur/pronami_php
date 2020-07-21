<?php
    // もしdispだったら
    if (isset($_POST['disp']) == true) {
        if (isset($_POST['procode']) == false) {
            header('Location:pro_ng.php');
            exit();
        }
        // 商品参照画面へ
        $pro_code = $_POST['procode'];
        header('Location:pro_disp.php?procode='.$pro_code);
        exit();
    }
    // もしaddだったら
    if (isset($_POST['add']) == true) {
        // スタッフ追加画面へ
        header('Location:pro_add.php');
        exit();
    }
    // もしeditだったら
    if (isset($_POST['edit']) == true) {
        if (isset($_POST['procode']) == false) {
            header('Location:pro_ng.php');
            exit();
        }
        // スタッフ修正画面へ
        $pro_code = $_POST['procode'];
        header('Location:pro_edit.php?procode='.$pro_code);
        exit();
    }
    // もしdeleteだったら
    if (isset($_POST['delete']) == true) {
        if (isset($_POST['procode']) == false) {
            header('Location:pro_ng.php');
            exit();
        }
        // スタッフ削除画面へ
        $pro_code = $_POST['procode'];
        header('Location:pro_delete.php?procode='.$pro_code);
        exit();
    }
?>
