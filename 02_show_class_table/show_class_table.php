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

$stmt_subject = $pdo->prepare('SELECT * FROM classes_subject');
$stmt_teacher = $pdo->prepare('SELECT * FROM classes_teacher');
$stmt_place = $pdo->prepare('SELECT * FROM classes_place');
$stmt_subject->execute();
$stmt_teacher->execute();
$stmt_place->execute();

$result_subject = $stmt_subject->fetchAll(PDO::FETCH_NUM);
$result_teacher = $stmt_teacher->fetchAll(PDO::FETCH_NUM);
$result_place = $stmt_place->fetchAll(PDO::FETCH_NUM); 

$num_arr = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth'];

$defalt_class_num = 0;

if (!isset($_POST['class'])) {
   $defalt_class_num = 0;
} else {
   $defalt_class_num = (int)$_POST['class'] - 1;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="class_table_style.css">
   <link rel="stylesheet" href="../header.css">
   <link rel="stylesheet" href="../practices_Bootstrap/css/bootstrap.min.css">
   <title>クラス別時間割表</title>
</head>
<body>
   <?php include('../practices_Bootstrap/index.html'); ?>
   <main class="main-contents">
      <div class="title">
         <h1>クラス別時間割表</h1>
         <form action="" method="POST">
            <select name="class" id="">
               <?php 
                  for ($i = 0; $i < count($result_subject) ; $i++){
                     if ($defalt_class_num == $i) {
                        echo '<option value="' . htmlspecialchars($result_subject[$i][0], ENT_QUOTES, 'UTF-8') . '" selected>' . htmlspecialchars($result_subject[$i][1], ENT_QUOTES, 'UTF-8') . '</option>';
                     } else {
                        echo '<option value="' . htmlspecialchars($result_subject[$i][0], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($result_subject[$i][1], ENT_QUOTES, 'UTF-8') . '</option>';
                     }
                  }
               ?>
            </select>
            <input type="submit" value="時間割表示">
         </form>
      </div>
      
      <div class="container-table">
         <div class="days">
            <p>月</p>
            <p>火</p>
            <p>水</p>
            <p>木</p>
            <p>金</p>
         </div>
         <div class="container-grid">
            <div class="times">
               <p>1</p>
               <p>2</p>
               <p>3</p>
               <p>4</p>
               <p>5</p>
               <p>6</p>
            </div>
            <div class="grid-area">
               <?php for ($i = 1; $i <= 6; $i++) {
                  for ($j = 0; $j < 5; $j++) {
                     echo '<div class="item">';
                        echo '<p class="subject">' . htmlspecialchars($result_subject[$defalt_class_num][$i + 1 + 6 * $j], ENT_QUOTES, 'UTF-8') . '</p>';
                        echo '<p class="teacher">' . htmlspecialchars($result_teacher[$defalt_class_num][$i + 1 + 6 * $j], ENT_QUOTES, 'UTF-8') . '</p>';
                        echo '<p class="place">' . htmlspecialchars($result_place[$defalt_class_num][$i + 1 + 6 * $j], ENT_QUOTES, 'UTF-8') . '</p>';
                     echo '</div>';
                  }
               } ?>
            </div>
         </div>
      </div>
   </main>
   <script src="../practices_Bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>