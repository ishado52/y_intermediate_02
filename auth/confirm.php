<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>
    <!-- css -->
    <link rel="stylesheet" href="http://localhost/task_app/assets/css/style.css">
</head>

<body>
    <?php
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');
    $file = $_FILES['file'];

    ?>
    <?php if ($file && $file['error'] === UPLOAD_ERR_OK) : ?>
        <?php
        $temp_file = $file['tmp_name'];
        $temp_file_data = base64_encode(file_get_contents($temp_file));
        $mime_type = mime_content_type($temp_file);
        $file_src = "data:$mime_type;base64,$temp_file_data";
        ?>
        <h2>入力内容確認</h2>
        <p>名前：<?php print $name ?></p>
        <p>メールアドレス：<?php print $mail ?></p>
        <p>パスワード：<?php print $pass ?></p>
        <p>写真：</p>
        <img src='<?php print $file_src ?>' alt='Uploaded Image' style='max-width: 300px; max-height: 300px;'>

        <form action="complete.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="name" value="<?php print $name;?>">
            <input type="hidden" name="mail" value="<?php print $mail;?>">
            <input type="hidden" name="pass" value="<?php print $pass;?>">
            <input type="hidden" name="file_data" value="<?php print $temp_file_data;?>">
            <input type="hidden" name="file_mime" value="<?php print $mime_type;?>">
            <input type="submit" value="登録">
        </form>

    <?php endif; ?>
</body>

</html>