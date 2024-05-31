<?php
require('/Applications/MAMP/htdocs/task_app/project/task/Task.php');
require('/Applications/MAMP/htdocs/task_app/db/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];

    try {
        $task = new Task($dbh);
        $task->deleteTask($task_id);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')]);
    }
}
?>
