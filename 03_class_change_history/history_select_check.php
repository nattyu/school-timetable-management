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

$chk = $_POST['chk'];

$placeholders = implode(',', array_fill(0, count($chk), '?'));

$stmt_checked_history = $pdo->prepare("SELECT * FROM class_change_history WHERE id IN ($placeholders)");
$stmt_checked_history->execute($chk);
$result_checked_history = $stmt_checked_history->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="change_history_style.css">
    <link rel="stylesheet" href="../header.css">
    <link rel="stylesheet" href="../practices_Bootstrap/css/bootstrap.min.css">
    <title>履歴編集画面</title>
</head>
<body>
    <?php include('../practices_Bootstrap/index.html'); ?>
    <main class="main-contents">
        <?php if (isset($_POST['edit_btn'])) { ?>
            <div class="edit_area">
                <p>選択した履歴を編集してください</p>
            </div>
        <?php } else if (isset($_POST['delete_btn'])) { ?>
            <p>本当に以下の履歴を削除しますか</p>
            <hr>
            <form action="history_delete_yes.php" method="POST">
                <input type="hidden" name="chk" value="<?php echo '(' . implode(", ", $_POST['chk']) . ')' ; ?>">
                <?php for ($i = 0; $i < count($result_checked_history); $i++) { ?>
                    <div class="history_item">
                        <div class="histories">
                            <small>更新日時：<?php echo $result_checked_history[$i]['create_at']; ?></small>
                            <p><?php echo 'クラス：' . $result_checked_history[$i]['class_name'] . '　授業変更日：' . date('Y年m月d日',  strtotime($result_checked_history[$i]['change_date'])) . '（' . $result_checked_history[$i]['class_day'] . '）' . '　時間：' . $result_checked_history[$i]['class_time'];?></p>
                            <div class="before_after_area">
                                <div class="before">
                                    <p>変更前</p>
                                    <p>教科：<?php echo $result_checked_history[$i]['before_subject']; ?></p>
                                    <p>担当：<?php echo $result_checked_history[$i]['before_teacher']; ?></p>
                                    <p>教室：<?php echo $result_checked_history[$i]['before_place']; ?></p>
                                </div>
                                <p class="arrow">→</p>
                                <div class="after">
                                    <p>変更前</p>
                                    <p>教科：<?php echo $result_checked_history[$i]['after_subject']; ?></p>
                                    <p>担当：<?php echo $result_checked_history[$i]['after_teacher']; ?></p>
                                    <p>教室：<?php echo $result_checked_history[$i]['after_place']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
                <input type="submit" value="はい" name="yes" class="btn"><input type="submit" value="いいえ" name="no" class="btn">
            </form>
        <?php } ?>
    </main>
    <script src="../practices_Bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
