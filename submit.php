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

// 変更する授業を選択するためのリストを作成するSQL実行
$stmt_class = $pdo->prepare('SELECT id , class_item_ja FROM class_list');
$stmt_day = $pdo->prepare('SELECT day_item_en , day_item_ja FROM day_list');
$stmt_time = $pdo->prepare('SELECT time_item_en , time_item_ja FROM time_list');

$stmt_class->execute();
$stmt_day->execute();
$stmt_time->execute();

$result_class = $stmt_class->fetchAll(PDO::FETCH_NUM);
$result_day = $stmt_day->fetchAll(PDO::FETCH_NUM);
$result_time = $stmt_time->fetchAll(PDO::FETCH_NUM);

// セレクトボックスから選択内容を受け取り、該当の授業を検索するSQL実行

if (!empty($_POST["class-select"]) && !empty($_POST["day-select"]) && !empty($_POST["time-select"])) {
   $selected_class = $_POST["class-select"];
   $selected_date = $_POST["day-select"];
   $selected_day = $result_day[date('N', strtotime($selected_date)) - 1][0];
   $selected_time = $_POST["time-select"];

   $stmt_insert_temporary_data = $pdo->prepare(
      "INSERT INTO temporary_data_storage (
         class_data, day_data, time_data, date_data, create_at
      ) VALUES(
         $selected_class, '$selected_day', '$selected_time', '$selected_date', now()
      )"
   );
   $stmt_insert_temporary_data->execute();

   $selected_column = $selected_day . '_' . $selected_time;
}

$stmt_before_subject = $pdo->prepare('SELECT * FROM classes_subject');
$stmt_before_teacher = $pdo->prepare('SELECT * FROM classes_teacher');
$stmt_before_place = $pdo->prepare('SELECT * FROM classes_place');

$stmt_before_subject->execute();
$stmt_before_teacher->execute();
$stmt_before_place->execute();

$result_before_subject = $stmt_before_subject->fetchAll(PDO::FETCH_ASSOC);
$result_before_teacher = $stmt_before_teacher->fetchAll(PDO::FETCH_ASSOC);
$result_before_place = $stmt_before_place->fetchAll(PDO::FETCH_ASSOC);

// 変更後の授業を選択するためのリストを作成するSQL実行
$stmt_after_subject = $pdo->prepare('SELECT subjects FROM subject_list');
$stmt_after_teacher = $pdo->prepare('SELECT teachers FROM teacher_list');
$stmt_after_place = $pdo->prepare('SELECT places FROM place_list');

$stmt_after_subject->execute();
$stmt_after_teacher->execute();
$stmt_after_place->execute();

$result_after_subject = $stmt_after_subject->fetchAll(PDO::FETCH_NUM);
$result_after_teacher = $stmt_after_teacher->fetchAll(PDO::FETCH_NUM);
$result_after_place = $stmt_after_place->fetchAll(PDO::FETCH_NUM);
?>