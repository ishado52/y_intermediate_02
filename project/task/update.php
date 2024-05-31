<?php
require('/Applications/MAMP/htdocs/task_app/project/task/Task.php');
require('/Applications/MAMP/htdocs/task_app/db/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');

    try {
        $task = new Task($dbh);
        $task->updateTask($task_id, $status);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')]);
    }
}
?>
