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
        // 入力文字チェック；半角数字以外はエラー
        if (preg_match("/\A[0-9]+\z/", $post['kazu'.$i]) == 0) {
            print '数量に誤りがあります。<br />';
            print '<a href="shop_cartlook.php">カートに戻る</a>';
            exit();
        }
        // 数量チェック；1以上10以下の範囲外だったらエラー
        if ($post['kazu'.$i] < 1 || 10 < $post['kazu'.$i]) {
            print '数量は必ず 1個以上、10個までです。<br />';
            print '<a href="shop_cartlook.php">カートに戻る</a>';
            exit();
        }
        $kazu[] = $post['kazu'.$i];
    }

    $cart = $_SESSION['cart'];
    for ($i = $max; $i >= 0; $i--) {
        if(isset($post['sakujyo'.$i]) == true) {
            // 削除処理
            array_splice($cart, $i, 1);
            array_splice($kazu, $i, 1);
        }
    }

    $_SESSION['cart'] = $cart;
    $_SESSION['kazu'] = $kazu;
    header('Location:shop_cartlook.php');
    exit();
?>
