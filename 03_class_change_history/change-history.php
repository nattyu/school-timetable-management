<?php
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

$stmt_history = $pdo->prepare('SELECT * FROM class_change_history order by id desc');
$stmt_history->execute();
$result_history = $stmt_history->fetchAll(PDO::FETCH_ASSOC);

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
    <title>授業変更履歴</title>
</head>
<body>
    <?php include('../practices_Bootstrap/index.html'); ?>
    <main class="main-contents">
        <h1>授業変更履歴</h1>
        <p>チェックした授業の削除が出来ます</p>
        <hr>
        <form action="history_select_check.php" class="history_form" method="POST">
        <input type="submit" name="delete_btn" value="選択した履歴を削除" class="btn">
            <?php for ($i = 0; $i < count($result_history); $i++) { ?>
            <div class="history_item">
                <div class="chk_area">
                    <input type="checkbox" name="chk[]" value=<?php echo '"' . $result_history[$i]['id'] . '"'; ?>>
                </div>
                <div class="histories">
                    <small>更新日時：<?php echo $result_history[$i]['create_at']; ?></small>
                    <p><?php echo 'クラス：' . $result_history[$i]['class_name'] . '　授業変更日：' . date('Y年m月d日',  strtotime($result_history[$i]['change_date'])) . '（' . $result_history[$i]['class_day'] . '）' . '　時間：' . $result_history[$i]['class_time'];?></p>
                    <div class="before_after_area">
                        <div class="before">
                            <p>変更前</p>
                            <p>教科：<?php echo $result_history[$i]['before_subject']; ?></p>
                            <p>担当：<?php echo $result_history[$i]['before_teacher']; ?></p>
                            <p>教室：<?php echo $result_history[$i]['before_place']; ?></p>
                        </div>
                        <p class="arrow">→</p>
                        <div class="after">
                            <p>変更前</p>
                            <p>教科：<?php echo $result_history[$i]['after_subject']; ?></p>
                            <p>担当：<?php echo $result_history[$i]['after_teacher']; ?></p>
                            <p>教室：<?php echo $result_history[$i]['after_place']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php } ?>
            <br>
            <input type="submit" name="delete_btn" value="選択した履歴を削除" class="btn">
        </form>
    </main>
    <script src="../practices_Bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>