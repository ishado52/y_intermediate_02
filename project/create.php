

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト作成</title>
       <!-- font awesome -->
       <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="http://localhost/task_app/assets/css/style.css">
</head>
<style>
    .toggle{
        display: none;
    }
</style>
<body>
<?php require('/Applications/MAMP/htdocs/task_app/components/header.php')?>
<?php
require('/Applications/MAMP/htdocs/task_app/project/project.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $color = htmlspecialchars($_POST['color'], ENT_QUOTES, 'UTF-8');
    $user_id = $_SESSION['user_id'];

    try {
        $project = new Project($dbh);
        $project->createProject($user_id, $name, $description, $color);
        echo "<p>プロジェクトが作成されました。</p>";
    } catch (Exception $e) {
        echo "<p>エラーが発生しました: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
    }
}
?>
<h2 class="c-heading">プロジェクト作成</h2>

    <div class="c-form --02">
        <form action="create.php" method="post" class="c-form__form">
            <div class="c-form__group">
                <label for="project_name">プロジェクト名</label>
                <input type="text" name="name" id="project_name">
            </div>
            <div class="c-form__group">
                <label class="js-btn_toggle">詳細設定</label>
            </div>
            <div class="js-content_toggle toggle" style="width: 100%;">
                <div class="c-form__group">
                    <label for="project_overview">プロジェクト概要</label>
                    <textarea type="text" name="description" id="project_overview"></textarea>
                </div>
                <div class="c-form__group">
                    <label for="project_color">プロジェクトカラー</label>
                    <div class="c-form__row">
                        <label class="radio-label">
                            <input type="radio" name="color" value="blue" class="radio-input radio-blue">
                            <span class="radio-custom"></span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="color" value="red" class="radio-input radio-red">
                            <span class="radio-custom"></span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="color" value="yellow" class="radio-input radio-yellow">
                            <span class="radio-custom"></span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="color" value="green" class="radio-input radio-green">
                            <span class="radio-custom"></span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="color" value="orange" class="radio-input radio-orange">
                            <span class="radio-custom"></span>
                        </label>
                    </div>
            </div>
            </div>
            <input type="submit" value="作成" class="c-form__button">
        </form>
    </div>
<script defer src="http://localhost/task_app/assets/js/create.js"></script>
</body>
</html>
