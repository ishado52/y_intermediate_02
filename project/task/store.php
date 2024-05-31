<?php
require('/Applications/MAMP/htdocs/task_app/project/task/Task.php');
require('/Applications/MAMP/htdocs/task_app/db/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = $_POST['project_id'];
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $order_num = $_POST['order_num'];
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');

    try {
        $task = new Task($dbh);
        $task->createTask($project_id, $title, $description, $order_num, $status);
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')]);
    }
}
?>
