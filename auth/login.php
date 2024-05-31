<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <!-- CSS -->
    <link rel="stylesheet" href="http://localhost/task_app/assets/css/style.css">
</head>

<body>
    <div class="c-form --01">
        <h2 class="c-form__title">ログイン</h2>
        <form class="c-form__form" action="login_check.php" method="post">
            <div class="c-form__group">
                <label for="mail">ID</label>
                <input type="text" name="mail" id="mail" required>
            </div>
            <div class="c-form__group">
                <label for="pass">パスワード</label>
                <input type="password" name="pass" id="pass" required>
            </div>
            <input class="c-form__button" type="submit" value="ログイン">
        </form>
        <a href="http://localhost/task_app/auth/register.php">新規ユーザー登録</a>
    </div>
</body>

</html>
