<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="http://localhost/task_app/assets/css/style.css">
</head>
<body>
    <!-- 共通ヘッダー -->
<?php require('/Applications/MAMP/htdocs/task_app/components/header.php')?>
    <h2 class="c-heading">プロジェクト一覧</h2>
    <?php
    require('/Applications/MAMP/htdocs/task_app/project/project.php');


    $project = new Project($dbh);
    
    try {
        // プロジェクトの取得
        $projects = $project->getAllProjects();
    } catch (Exception $e) {
        echo "<p>エラーが発生しました: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
        exit();
    }
    ?>

<?php if (count($projects) > 0): ?>
    <ul class="p-projects__list">
        <?php foreach ($projects as $project): ?>
            <li class="p-projects__list__item">
                <a href="http://localhost/task_app/project/show.php?id=<?php print $project['id'] ?>">
                    <h3><?php echo htmlspecialchars($project['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                </a>
                <p><?php echo htmlspecialchars($project['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                <p>作成日: <?php echo htmlspecialchars($project['created_at'], ENT_QUOTES, 'UTF-8'); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>プロジェクトはありません</p>
    <a href="http://localhost/task_app/project/create.php">プロジェクト作成</a>
<?php endif; ?>
</body>
</html>