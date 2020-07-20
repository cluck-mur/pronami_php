<?php
    // もしdispだったら
    if (isset($_POST['disp']) == true) {
        if (isset($_POST['staffcode']) == false) {
            header('Location:staff_ng.php');
            exit();
        }
        // スタッフ参照画面へ
        $staff_code = $_POST['staffcode'];
        header('Location:staff_disp.php?staffcode='.$staff_code);
        exit();
    }
    // もしaddだったら
    if (isset($_POST['add']) == true) {
        // スタッフ追加画面へ
        header('Location:staff_add.php');
        exit();
    }
    // もしeditだったら
    if (isset($_POST['edit']) == true) {
        if (isset($_POST['staffcode']) == false) {
            header('Location:staff_ng.php');
            exit();
        }
        // スタッフ修正画面へ
        $staff_code = $_POST['staffcode'];
        header('Location:staff_edit.php?staffcode='.$staff_code);
        exit();
    }
    // もしdeleteだったら
    if (isset($_POST['delete']) == true) {
        if (isset($_POST['staffcode']) == false) {
            header('Location:staff_ng.php');
            exit();
        }
        // スタッフ削除画面へ
        $staff_code = $_POST['staffcode'];
        header('Location:staff_delete.php?staffcode='.$staff_code);
        exit();
    }
?>
