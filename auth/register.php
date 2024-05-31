<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規ユーザー登録</title>
    <!-- css -->
    <link rel="stylesheet" href="http://localhost/task_app/assets/css/style.css">
</head>

<body>
    <div class="c-form --01">
        <h2 class="c-form__title">新規ユーザー登録</h2>
        <form action="confirm.php" method="post" class="c-form__form" id="js-input_form" enctype="multipart/form-data">
            <div class="c-form__group">
                <label for="js-input_name">名前</label>
                <input type="text" name="name" id="js-input_name">
            </div>
            <div class="c-form__group">
                <label for="js-input_mail">メールアドレス</label>
                <input type="text" name="mail" id="js-input_mail">
            </div>
            <div class="c-form__group">
                <label for="js-input_pass">パスワード</label>
                <input type="password" name="pass" id="js-input_pass">
            </div>
            <div class="c-form__group">
                <label for="js-input_file">写真</label>
                <input type="file" name="file" id="js-input_file">
            </div>
            <input class="c-form__button" type="submit" value="入力内容確認">
        </form>
        <a href="http://localhost/task_app/auth/login.php">登録済みの方はこちら</a>
    </div>
   <script src="http://localhost/task_app/assets/js/register.js"></script>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
            margin-left: 10px;
        }
    </style>
</body>

</html>
