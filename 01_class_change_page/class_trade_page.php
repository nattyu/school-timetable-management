<?php
ini_set("display_errors", 0);
error_reporting(E_ALL);
require_once('submit_trade.php');

// DB接続
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "<span class='error'>エラーがありました。</span><br>";
    echo $e->getMessage();
    exit();
}

date_default_timezone_set ('Asia/Tokyo');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="change-style.css">
    <link rel="stylesheet" href="../header.css">
    <link rel="stylesheet" href="../practices_Bootstrap/css/bootstrap.min.css">
    <title>授業変更ページ</title>
</head>
<body>
    <?php include('../practices_Bootstrap/index.html'); ?>
    <main class="main-contents container-fruid ms-2 ms-sm-5 maxWidth">
        <!-- 行 -->
        <h1 class="row">授業変更ページ</h1>
        <!-- 行 -->
        <h3 class="row">変更内容：交換</h3>
        <!-- 行 -->
        <p class="before-title row my-3">交換する授業①を選択</p>
        <div class="container-form">
            <!-- 行 -->
            <form class="before row align-items-center my-3" action="" method="POST">
                <!-- クラス選択 -->
                <p class="col-1 m-0">クラス</p>
                <select name="class-select_1" class="selection-area col-2">
                    <option value="" hidden>クラスを選択</option>
                    <?php for ($i = 0; $i < count($result_class); $i++){
                        if ((string)$result_class[$i][0] == $_POST["class-select_1"]) {
                            echo "<option value='" . $result_class[$i][0] . "' selected>" . $result_class[$i][1] . "</option>" ;
                        } else {
                            echo "<option value='" . $result_class[$i][0] . "'>" . $result_class[$i][1] . "</option>" ;
                        }
                    } ?>
                </select>
                <!-- 日付選択 -->
                <p class="col-1 m-0">日付</p>
                <input class="col-2" type="date" name="day-select_1" value="<?php if (!empty($_POST["day-select_1"])) echo $_POST["day-select_1"]; ?>">
                <!-- 時間選択 -->
                <p class="col-1 m-0">時間</p>
                <select name="time-select_1" class="selection-area col-2">
                    <option value="" hidden>時間を選択</option>
                    <?php for ($i = 0; $i < count($result_time); $i++){
                        if ($result_time[$i][0] == $_POST["time-select_1"]) {
                            echo "<option value='" . $result_time[$i][0] . "' selected>" . $result_time[$i][1] . "</option>" ;
                        } else {
                            echo "<option value='" . $result_time[$i][0] . "'>" . $result_time[$i][1] . "</option>" ;
                        }
                    } ?>
                </select>
            </form>
        </div>
        <!-- 行 -->
        <div class="searched-class row my-3">
            <p class="subject col-1">教科：</p><p class="col-2"><?php if (!empty($_POST["class-select_1"])) echo $result_before_subject[$_POST["class-select_1"] - 1][$selected_column]; ?></p>
            <p class="teacher col-1">担当：</p><p class="col-2"><?php if (!empty($_POST["class-select_1"])) echo $result_before_teacher[$_POST["class-select_1"] - 1][$selected_column]; ?></p>
            <p class="place col-1">教室：</p><p class="col-2"><?php if (!empty($_POST["class-select_1"])) echo $result_before_place[$_POST["class-select_1"] - 1][$selected_column]; ?></p>
        </div>
        <!-- 行 -->
        <p class="after-title row my-3">交換する授業②を選択</p>
        <div class="container-form">
            <!-- 行 -->
            <form class="before row align-items-center my-3" action="" method="POST">
                <!-- クラス選択 -->
                <p class="col-1 m-0">クラス</p>
                <select name="class-select_2" class="selection-area col-2">
                    <option value="" hidden>クラスを選択</option>
                    <?php for ($i = 0; $i < count($result_class); $i++){
                        if ((string)$result_class[$i][0] == $_POST["class-select_2"]) {
                            echo "<option value='" . $result_class[$i][0] . "' selected>" . $result_class[$i][1] . "</option>" ;
                        } else {
                            echo "<option value='" . $result_class[$i][0] . "'>" . $result_class[$i][1] . "</option>" ;
                        }
                    } ?>
                </select>
                <!-- 日付選択 -->
                <p class="col-1 m-0">日付</p>
                <input class="col-2" type="date" name="day-select_2" value="<?php if (!empty($_POST["day-select_2"])) echo $_POST["day-select_2"]; ?>">
                <!-- 時間選択 -->
                <p class="col-1 m-0">時間</p>
                <select name="time-select_2" class="selection-area col-2">
                    <option value="" hidden>時間を選択</option>
                    <?php for ($i = 0; $i < count($result_time); $i++){
                        if ($result_time[$i][0] == $_POST["time-select_2"]) {
                            echo "<option value='" . $result_time[$i][0] . "' selected>" . $result_time[$i][1] . "</option>" ;
                        } else {
                            echo "<option value='" . $result_time[$i][0] . "'>" . $result_time[$i][1] . "</option>" ;
                        }
                    } ?>
                </select>
            </form>
        </div>
        <!-- 行 -->
        <div class="searched-class row my-3">
            <p class="subject col-1">教科：</p><p class="col-2"><?php if (!empty($_POST["class-select_2"])) echo $result_before_subject[$_POST["class-select_2"] - 1][$selected_column]; ?></p>
            <p class="teacher col-1">担当：</p><p class="col-2"><?php if (!empty($_POST["class-select_2"])) echo $result_before_teacher[$_POST["class-select_2"] - 1][$selected_column]; ?></p>
            <p class="place col-1">教室：</p><p class="col-2"><?php if (!empty($_POST["class-select_2"])) echo $result_before_place[$_POST["class-select_2"] - 1][$selected_column]; ?></p>
        </div>
    </main>
    <script src="../practices_Bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
