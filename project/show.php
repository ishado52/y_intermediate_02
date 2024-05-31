<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カンバンボード</title>
    <!-- font awesome -->
    <link href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="http://localhost/task_app/assets/css/style.css">
</head>

<body>
    <!-- 共通ヘッダー -->
    <?php require('/Applications/MAMP/htdocs/task_app/components/header.php') ?>
    <!-- クラスを読み込む -->
    <?php
    require('/Applications/MAMP/htdocs/task_app/project/task/Task.php');
    require('/Applications/MAMP/htdocs/task_app/project/project.php');
    ?>

    <?php
    // URLパラメータからproject_id定義
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $project_id = $_GET['id'];

        // プロジェクト情報取得のためのクラスをnewする
        $project = new Project($dbh);

        try {
            // プロジェクトの取得
            $project = $project->getProject($project_id);
        } catch (Exception $e) {
            print "<p>エラーが発生しました: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
            exit();
        }

        // タスク情報取得のためのクラスをnew
        $task = new Task($dbh);
        try {
            // タスクの取得
            $tasks = $task->getTasks($project_id);
        } catch (Exception $e) {
            print "<p>エラーが発生しました: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
            exit();
        }
    }
    ?>
<div class="p-show__container --<?php print htmlspecialchars($project['color_type'], ENT_QUOTES, 'UTF-8'); ?>">
    
        <div class="p-show">
            <?php if ($project) : ?>
                <h1 class="p-show__heading"><?php print htmlspecialchars($project['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <?php endif ?>
            <div class="c-board">
                <div class="c-board__column" id="todo">
                    <h2 class="c-board__column__heading">未対応</h2>
                    <div class="c-board__column__tasks" id="todo-tasks"></div>
                    <button class="c-board__button" onclick="showTaskForm('todo')">タスク追加</button>
                </div>
                <div class="c-board__column" id="in-progress">
                    <h2 class="c-board__column__heading">対応中</h2>
                    <div class="c-board__column__tasks" id="in-progress-tasks"></div>
                </div>
                <div class="c-board__column" id="done">
                    <h2 class="c-board__column__heading">完了</h2>
                    <div class="c-board__column__tasks" id="done-tasks"></div>
                </div>
            </div>
        </div>
</div>

    <script>
        let taskIdCounter = 0;
        let formVisible = false;

        // タスク追加ボタン
        const showTaskForm = (columnId) => {
            if (formVisible) return;
            formVisible = true;

            const form = document.createElement('div');
            form.className = 'c-board__column__form';
            form.innerHTML = `
                <input type="text" id="task-title-${taskIdCounter}" placeholder="タイトル">
                <textarea id="task-detail-${taskIdCounter}" placeholder="詳細"></textarea>
                <div class="row">
                    <button class="save" onclick="addTask('${columnId}', ${taskIdCounter})">登録</button>
                    <button class="delete" onclick="removeTaskForm(this)">削除</button>
                </div>
            `;
            document.getElementById(`${columnId}-tasks`).appendChild(form);
            document.querySelectorAll('.c-board__button').forEach(button => button.disabled = true);
        }

        // 削除ボタン
        const removeTaskForm = (button) => {
            button.parentElement.parentElement.remove();
            formVisible = false;
            document.querySelectorAll('.c-board__button').forEach(button => button.disabled = false);
        }

        // 登録ボタン
        const addTask = (columnId, id) => {
            const title = document.getElementById(`task-title-${id}`).value;
            const detail = document.getElementById(`task-detail-${id}`).value;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "http://localhost/task_app/project/task/store.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        const task = document.createElement('div');
                        task.className = 'c-board__column__task';
                        task.draggable = true;
                        task.innerHTML = `<h3>${title}</h3>
                                         <p>${detail}</p>
                                         <i onclick="deleteTask(${response.id}, '${columnId}', ${taskIdCounter})" class="fa-solid fa-trash-can"></i>`;
                                          
                        task.id = 'task-' + taskIdCounter++;
                        task.setAttribute('data-task-id', response.id); 
                        task.addEventListener('dragstart', handleDragStart);
                        task.addEventListener('dragend', handleDragEnd);
                        document.getElementById(`${columnId}-tasks`).appendChild(task);
                        removeTaskForm(document.querySelector(`#task-title-${id}`).parentElement.querySelector('.delete'));
                    } else {
                        alert("失敗" + response.message);
                    }
                }
            };
            xhr.send(`project_id=<?php print $project_id; ?>&title=${encodeURIComponent(title)}&description=${encodeURIComponent(detail)}&order_num=${taskIdCounter}&status=${columnId}`);
        }

        // タスク削除
        const deleteTask = (taskId, columnId, id) => {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "http://localhost/task_app/project/task/delete.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        const taskElement = document.getElementById(`task-${id}`);
                        taskElement.remove();
                    } else {
                        alert("失敗" + response.message);
                    }
                }
            };
            xhr.send(`task_id=${taskId}`);
            console.log(`task_id=${taskId}`);
        }

        // ドラッグ開始(1回発火)
        const handleDragStart = (e) => {
            e.dataTransfer.setData('text/plain', e.target.id);
            e.dataTransfer.setData('task-id', e.target.getAttribute('data-task-id')); 
            e.dataTransfer.effectAllowed = 'move';
            e.target.classList.add('dragging');
        }

        // ドラッグ終了(1回発火)
        const handleDragEnd = (e) => {
            e.target.classList.remove('dragging');
        }

        // ドラッグ中
        const handleDragOver = (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        }

        // ドロップ
        const handleDrop = (e) => {
            e.preventDefault();
            const id = e.dataTransfer.getData('text/plain');
            const task = document.getElementById(id);
            const taskId = e.dataTransfer.getData('task-id'); 
            const newColumnId = e.target.parentElement.id;
            // サーバにデータ送信 
            if (task) {
                updateTask(taskId, newColumnId);
                e.target.appendChild(task);
            }
        }

        // タスク移動でajaxで更新
        const updateTask = (taskId, newColumnId) => {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "http://localhost/task_app/project/task/update.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // タスクが正常に移動した場合の処理
                        console.log("成功");
                    } else {
                        alert(response.message);
                    }
                }
            };
            xhr.send(`task_id=${taskId}&status=${newColumnId}`);
            console.log(`task_id=${taskId}&status=${newColumnId}`);
        }

        // タスクの初期表示
        document.addEventListener('DOMContentLoaded', () => {
            const tasks = <?php print json_encode($tasks); ?>;
            tasks.forEach(task => {
                const taskElement = document.createElement('div');
                taskElement.className = 'c-board__column__task';
                taskElement.draggable = true;
                taskElement.innerHTML = `<h3>${task.title}</h3>
                                         <p>${task.description}</p>
                                         <i onclick="deleteTask(${task.id}, '${task.status}', ${taskIdCounter})" class="fa-solid fa-trash-can"></i>`;
                taskElement.id = 'task-' + taskIdCounter++;
                taskElement.setAttribute('data-task-id', task.id); 
                taskElement.addEventListener('dragstart', handleDragStart);
                taskElement.addEventListener('dragend', handleDragEnd);
                document.getElementById(`${task.status}-tasks`).appendChild(taskElement);
            });
        });

        // ドラッグ＆ドロップイベント
        document.querySelectorAll('.c-board__column__tasks').forEach(column => {
            column.addEventListener('dragover', handleDragOver);
            column.addEventListener('drop', handleDrop);
        });
    </script>
    </body>

</html>
