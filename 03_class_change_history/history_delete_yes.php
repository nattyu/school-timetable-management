<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
require_once('../db.php');

// DB接続
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "<span class='error'>エラーがありました。</span><br>";
    echo $e->getMessage();
    exit();
}

$str = $_POST['chk'];
$str = trim($str, "()");

$chk_array = explode(",", $str);
$placeholders = implode(',', array_fill(0, count($chk_array), '?'));
$stmt_delete_history = $pdo->prepare("DELETE FROM class_change_history WHERE id IN ($placeholders)");

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../header.css">
    <link rel="stylesheet" href="../practices_Bootstrap/css/bootstrap.min.css">
    <title>削除完了</title>
</head>
<body>
    <?php include('../practices_Bootstrap/index.html'); ?>
    <main class="main-contents">
        <?php if (isset($_POST['yes'])) {
            $stmt_delete_history->execute($chk_array);
            echo '<p>削除完了しました</p>';
        } else if (isset($_POST['no'])) {
            echo '「いいえ」が押されたため、削除しませんでした';
        } ?>
        <a href="./change-history.php">変更履歴確認ページ</a>
        <div class="link_area">
            <a href="../00_home_page/home-page.html" class="links">ホーム画面</a>
            <a href="../01_class_change_page/class-change-page.php" class="links">授業変更ページ</a>
            <a href="../02_show_class_table/access.php" class="links">時間割確認ページ</a>
        </div>
    </main>
    <script src="../practices_Bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>