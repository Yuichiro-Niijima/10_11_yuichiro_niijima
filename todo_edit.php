<?php
// 送信データのチェック
// var_dump($_GET);
// exit();
session_start();

// 関数ファイルの読み込み
include("functions.php");
check_session_id();

$id = $_GET["id"];

$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM life_log_table WHERE id=:id';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    
    exit();
} else {
    // 正常にSQLが実行された場合は指定の11レコードを取得
    // fetch()関数でSQLで取得したレコードを取得できる
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" media="screen and (max-width:480px)">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>log</title>
</head>

<body>
    <form action="todo_update.php" method="POST" class="timer_page">
        <fieldset>
            <img class="daily_background" src="背景2.jpg" alt="">

            <div>
                <p class="timer_title" id="timer_title" name="todo" value="<?= $record["todo"]?>"></p>
            </div>


            <div class=" timer_Box" id="startBtn">
                <a class="btn-circle-fishy" id="timer" class="time" name="timer">25:00</a>
            </div>


            <div class="analysis_button_Box">
                <button class="analysis_button" id="resetBtn">Done</button>
                <!-- <a href="#" class="analysis_button" id="finish_button">終了</a> -->
            </div>
            <input type="hidden" name="id" value="<?= $record["id"] ?>">
        </fieldset>

    </form>



    <!------------------------------------->

    <!--          javascript             -->

    <!------------------------------------->



    <script>
        let data = localStorage.getItem('data')
        // alert(data);
        $("#timer_title").text(data);


        let startTime;
        let timeLeft;
        let timeToCountDown = 1500 * 1000;
        let timerId;
        let isRunning = false;

        function updateTimer(t) {
            let d = new Date(t);
            let m = d.getMinutes();
            let s = d.getSeconds();
            let ms = d.getMilliseconds();
            m = ('0' + m).slice(-2);
            s = ('0' + s).slice(-2);
            // ms = ('00' + ms).slice(-3);
            timer.textContent = m + ":" + s;
            // timer.textContent = m + ":" + s + "." + ms;
        }

        function countDown() {
            timerId = setTimeout(function() {
                // let elaspedTime = Date.now() - startTime;
                timeLeft = timeToCountDown - (Date.now() - startTime);
                if (timeLeft < 0) {
                    isRunning = false;
                    startBtn.textContent = "Start"
                    clearTimeout(timerId);
                    timeLeft = 0;
                    timeToCountDown = 0;
                    updateTimer(timeLeft);
                    return;
                }
                // console.log(timeLeft);
                updateTimer(timeLeft);

                countDown();
            }, 10);
        }

        $("#startBtn").on("click", function() {
            if (isRunning == false) {
                isRunning = true;
                // startBtn.textContent = "Stop";
                startTime = Date.now();
                countDown();
            } else {
                isRunning = false;
                // startBtn.textContent = "Start";
                timeToCountDown = timeLeft;
                clearTimeout(timerId);
            }

        });

        $("#resetBtn").on("click", function() {
            // $("#timer").text("25:00");
            clearTimeout(timerId);
            timeToCountDown = 1500 * 1000;
            updateTimer(timeToCountDown);

        });
    </script>

</body>

</html>