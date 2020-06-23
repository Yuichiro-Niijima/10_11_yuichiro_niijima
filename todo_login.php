<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit-icons.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css" />
    <link rel="stylesheet" href="style.css">
    <title>ログイン</title>
</head>

<body>
    <form action="todo_login_act.php" method="POST" class="login_form">
        <fieldset class="uk-fieldset">
            <legend>ログイン</legend>
            <div class="uk-margin">
                user_id: <input type="text" name="user_id" class="uk-input">
            </div>
            <div>
                password: <input type="text" name="password" class="uk-input">
            </div>
            <div>
                <button class="uk-button uk-button-primary uk-width-1-1">Login</button>
            </div>
            <!-- <a href="https://localhost/11_11_yuichiro_niijima/todo_input.php">or register</a> -->
        </fieldset>
    </form>

</body>

</html>