<?php
ini_set("display_errors", 0);
error_reporting(E_ALL);
require_once('submit.php');

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
        <h3 class="row">変更内容：自習</h3>
        <div id="container-give" class="block">
            <!-- 行 -->
            <p class="before-title row my-3">自習にする授業を選択</p>
            <div class="container-form">
                <!-- 行 -->
                <form class="before row align-items-center my-3" action="" method="POST">
                    <!-- クラス選択 -->
                    <p class="col-1 m-0">クラス</p>
                    <select name="class-select" class="selection-area col-2">
                        <option value="" hidden>クラスを選択</option>
                        <?php for ($i = 0; $i < count($result_class); $i++){
                            if ((string)$result_class[$i][0] == $_POST["class-select"]) {
                                echo "<option value='" . $result_class[$i][0] . "' selected>" . $result_class[$i][1] . "</option>" ;
                            } else {
                                echo "<option value='" . $result_class[$i][0] . "'>" . $result_class[$i][1] . "</option>" ;
                            }
                        } ?>
                    </select>
                    <!-- 日付選択 -->
                    <p class="col-1 m-0">日付</p>
                    <input class="col-2" type="date" name="day-select" value="<?php if (!empty($_POST["day-select"])) echo $_POST["day-select"]; ?>">
                    <!-- 時間選択 -->
                    <p class="col-1 m-0">時間</p>
                    <select name="time-select" class="selection-area col-2">
                        <option value="" hidden>時間を選択</option>
                        <?php for ($i = 0; $i < count($result_time); $i++){
                            if ($result_time[$i][0] == $_POST["time-select"]) {
                                echo "<option value='" . $result_time[$i][0] . "' selected>" . $result_time[$i][1] . "</option>" ;
                            } else {
                                echo "<option value='" . $result_time[$i][0] . "'>" . $result_time[$i][1] . "</option>" ;
                            }
                        } ?>
                    </select>
                    <!-- 表示ボタン -->
                    <input class="col-2 ms-4" type="submit" name="submit" value="授業表示">
                </form>
            </div>
            <!-- 行 -->
            <div class="searched-class row my-3">
                <p class="subject col-1">教科：</p><p class="col-2"><?php if (!empty($_POST["class-select"])) echo $result_before_subject[$_POST["class-select"] - 1][$selected_column]; ?></p>
                <p class="teacher col-1">担当：</p><p class="col-2"><?php if (!empty($_POST["class-select"])) echo $result_before_teacher[$_POST["class-select"] - 1][$selected_column]; ?></p>
                <p class="place col-1">教室：</p><p class="col-2"><?php if (!empty($_POST["class-select"])) echo $result_before_place[$_POST["class-select"] - 1][$selected_column]; ?></p>
            </div>
            <!-- 行 -->
            <p class="after-title row my-3">変更後の授業を選択</p>
            <div class="container-form">
                <!-- 行 -->
                <form class="after row my-3" action="change-result.php" method="POST">
                    <!-- 教科選択 -->
                    <p class="col-1 m-0">教科</p>
                    <select name="subject-select" class="selection-area col-2">
                        <option value="" hidden>教科を選択</option>
                        <?php for ($i = 0; $i < count($result_after_subject); $i++){
                            if ($result_after_subject[$i][0] == $_POST["subject-select"]) {
                                echo "<option value='" . $result_after_subject[$i][0] . "' selected>" . $result_after_subject[$i][0] . "</option>" ;
                            } else {
                                echo "<option value='" . $result_after_subject[$i][0] . "'>" . $result_after_subject[$i][0] . "</option>" ;
                            }
                        } ?>
                    </select>
                    <!-- 担当選択 -->
                    <p class="col-1 m-0">担当</p>
                    <select name="teacher-select" class="selection-area col-2">
                        <option value="" hidden>担当を選択</option>
                        <?php for ($i = 0; $i < count($result_after_teacher); $i++){
                            if ($result_after_teacher[$i][0] == $_POST["teacher-select"]) {
                                echo "<option value='" . $result_after_teacher[$i][0] . "' selected>" . $result_after_teacher[$i][0] . "</option>" ;
                            } else {
                                echo "<option value='" . $result_after_teacher[$i][0] . "'>" . $result_after_teacher[$i][0] . "</option>" ;
                            }
                        } ?>
                    </select>
                    <!-- 教室選択 -->
                    <p class="col-1 m-0">教室</p>
                    <select name="place-select" class="selection-area col-2">
                        <option value="" hidden>教室を選択</option>
                        <?php for ($i = 0; $i < count($result_after_place); $i++){
                            if ($result_after_place[$i][0] == $_POST["place-select"]) {
                                echo "<option value='" . $result_after_place[$i][0] . "' selected>" . $result_after_place[$i][0] . "</option>" ;
                            } else {
                                echo "<option value='" . $result_after_place[$i][0] . "'>" . $result_after_place[$i][0] . "</option>" ;
                            }
                        } ?>
                    </select>
                    <!-- 授業変更ボタン -->
                    <input class="col-2 ms-4" type="submit" name="submit" value="授業変更">
                </form>
            </div>
        </div>
    </main>
    <script src="../practices_Bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
