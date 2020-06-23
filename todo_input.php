<?php
session_start();
// check_session_id();
include('functions.php');
$user_id = $_SESSION['id'];
$pdo = connect_to_db();




// DB接続の設定
// DB名は`gsacf_x00_00`にする
$dbn = 'mysql:dbname=life_log;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
    // ここでDB接続処理を実行する
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
}

// データ取得SQL作成


// $sql = 'SELECT * FROM life_log_table';
$sql = 'SELECT * FROM life_log_table LEFT OUTER JOIN (SELECT todo_id, COUNT(id) AS cnt FROM like_table GROUP BY todo_id) AS likes ON life_log_table.id = likes.todo_id';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();



// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";
    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    foreach ($result as $record) {



        $output .= "<ul id='list'>";
        $output .= "<li class='item'>";
        $output .= "<a href='like_create.php? user_id={$user_id}&todo_id={$record["id"]}'><i class='fas fa-star'></i></a>";
        // $output .= "<td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like{$record["cnt"]}</a></td>";

        $output .= "<p class='selected_task'>{$record["todo"]}</p>";
        // $output .= "<i class='fas fa-edit'></i>";
        $output .= "<i class='far fa-trash-alt'></i>";

        $output .= "</i>";
        $output .= "</ul>";
    }
    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($record);
}
?>




<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" media="screen and (max-width:480px)">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <title>log</title>
</head>

<body>
    <img class="daily_background" src="背景2.jpg" alt="">
    <div class="wrapper">
        <header>
            <h1 style="color: white;">タスク</h1>
        </header>


        <div class="incomplete_list">
            <ul id="list">
                <li class="item">
                    <i class="fas fa-star"></i>
                    <p id="selected_task"></p>
                    <!-- <i class="fas fa-edit"></i> -->
                    <i class="far fa-trash-alt"></i>
                </li>
            </ul>
            <?= $output ?>
            <!-- <ul id="list">
                <li class="item">
                    <i class="far fa-circle"></i>

                    <input class="text"></input>
                    <i class="far fa-trash-alt"></i>
                </li>
            </ul> -->

        </div>

        <form action="todo_create.php" method="POST">
            <fieldset>
                <div class="add_itemBox">
                    <ul id="add-item list">
                        <li class="additem item">
                            <i class="fas fa-plus-circle"></i>
                            <input name=todo class="text addtext" placeholder="タスクを追加"></input>
                            <button id="send">送信</button>
                        </li>
                    </ul>
                </div>
            </fieldset>
        </form>
    </div>

    <script>
        // $(function() {
        $('.selected_task').on("click", function() {
            let data = $(this).text();
            localStorage.setItem('data', data)

            location.href = "https://localhost/11_11_yuichiro_niijima/todo_edit.php";

        });

        // });

        $(".fa-star").on("click", function() {
            alert("ok")
            // $(this).remove("fa-star:before");
            // $(this).add("click_color");


            $(this).toggleClass("click_color");
        })
    </script>

</body>

</html>