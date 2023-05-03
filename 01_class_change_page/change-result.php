<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once('./submit.php');
require_once('../db.php');

date_default_timezone_set ('Asia/Tokyo');

$stmt_before_info = $pdo->prepare('SELECT class_data, day_data, time_data, date_data FROM temporary_data_storage');
$stmt_before_info->execute();

$result_before_info = $stmt_before_info->fetchAll(PDO::FETCH_NUM);

$last_rec = count($result_before_info) - 1;
$class_data = $result_before_info[$last_rec][0];
$day_data = $result_before_info[$last_rec][1];
$time_data = $result_before_info[$last_rec][2];
$date_data = $result_before_info[$last_rec][3];

$before_column = $day_data . '_' . $time_data;

$stmt_search_class = $pdo->prepare("SELECT class_item_ja FROM class_list where class_list.id = '" . $class_data . "'");
$stmt_search_day = $pdo->prepare("SELECT day_item_ja FROM day_list where day_list.day_item_en = '" . $day_data . "'");
$stmt_search_time = $pdo->prepare("SELECT time_item_ja FROM time_list where time_list.time_item_en = '" . $time_data . "'");

$stmt_search_class->execute();
$stmt_search_day->execute();
$stmt_search_time->execute();

$result_searched_class = $stmt_search_class->fetch(PDO::FETCH_ASSOC);
$result_searched_day = $stmt_search_day->fetch(PDO::FETCH_ASSOC);
$result_searched_time = $stmt_search_time->fetch(PDO::FETCH_ASSOC);

$insert_class_name = $result_searched_class["class_item_ja"];
$insert_class_day = $result_searched_day["day_item_ja"];
$insert_class_time = $result_searched_time["time_item_ja"];
$insert_before_subject = $result_before_subject[$class_data - 1][$before_column];
$insert_before_teacher = $result_before_teacher[$class_data - 1][$before_column];
$insert_before_place = $result_before_place[$class_data - 1][$before_column];
$insert_after_subject = $_POST["subject-select"];
$insert_after_teacher = $_POST["teacher-select"];
$insert_after_place = $_POST["place-select"];

$insert_change_date = date('Y-m-d');

$stmt_insert_change_data = $pdo->prepare(
    "INSERT INTO class_change_history (
        change_status , 
        change_date , 
        class_name , 
        class_day ,  
        class_time , 
        before_subject , 
        before_teacher , 
        before_place , 
        after_subject , 
        after_teacher , 
        after_place , 
        create_at 
    ) VALUES('give', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())"
);

$stmt_insert_change_data->execute([
    "$date_data",
    "$insert_class_name",
    "$insert_class_day",
    "$insert_class_time",
    "$insert_before_subject",
    "$insert_before_teacher",
    "$insert_before_place",
    "$insert_after_subject",
    "$insert_after_teacher",
    "$insert_after_place"
]);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="change-result-style.css">
    <link rel="stylesheet" href="../header.css">
    <link rel="stylesheet" href="../practices_Bootstrap/css/bootstrap.min.css">
    <title>時間割変更確定画面</title>
</head>
<body>
    <?php include('../practices_Bootstrap/index.html'); ?>
    <main class="main-contents">
        <h1>時間割変更を登録しました</h1>
        <div class="class_info">
            <p>クラス：<?php echo htmlspecialchars($result_searched_class["class_item_ja"], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>曜日：<?php echo htmlspecialchars($result_searched_day["day_item_ja"], ENT_QUOTES, 'UTF-8'); ?></p>
            <p>時間：<?php echo htmlspecialchars($result_searched_time["time_item_ja"], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <div class="result_window">
            <div class="before">
                <p>変更前</p>
                <p>教科：<?php echo htmlspecialchars($result_before_subject[$class_data - 1][$before_column], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>担当：<?php echo htmlspecialchars($result_before_teacher[$class_data - 1][$before_column], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>教室：<?php echo htmlspecialchars($result_before_place[$class_data - 1][$before_column], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <p class="arrow">→</p>
            <div class="after">
                <p>変更前</p>
                <p>教科：<?php echo htmlspecialchars($_POST["subject-select"], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>担当：<?php echo htmlspecialchars($_POST["teacher-select"], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>教室：<?php echo htmlspecialchars($_POST["place-select"], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        </div>
    </main>
    <script src="../practices_Bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
