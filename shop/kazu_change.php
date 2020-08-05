<?php
    /**
     * セッションチェック
     */
    // セッション開始
    session_start();
    // ページを変える度に合言葉を変える
    session_regenerate_id(true);

    require_once('../common/common.php');
    $post = sanitize($_POST);
    $max = $post['max'];
    for ($i = 0; $i < $max; $i++) {
        $kazu[] = $post['kazu'.$i];
    }

    $_SESSION['kazu'] = $kazu;
    header('Location:shop_cartlook.php');
    exit();
?>
