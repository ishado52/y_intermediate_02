<?php

class Task
{
    private $dbh;

    public function __construct($dbh)
    {
        $this->dbh = $dbh;
    }



    // タスク取得メソッド
    public function getTasks($project_id)
    {
        $sql = 'SELECT * FROM tasks WHERE project_id = ?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$project_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // タスク作成メソッド
    public function createTask($project_id, $title, $description, $order_num, $status)
    {
        $sql = 'INSERT INTO tasks (project_id, title, description, order_num, status, created_at,updated_at) VALUES (?, ?, ?, ?,?,NOW(), NOW())';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$project_id, $title, $description, $order_num, $status]);
    }

    // タスク削除メソッド
    public function deleteTask($task_id)
    {
        $sql = 'DELETE FROM tasks WHERE id=?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$task_id]);
    }

    // タスクステータス更新
public function updateTask($task_id,$status)
{
    $sql = 'UPDATE tasks SET status=? WHERE id=?';
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute([$status,$task_id]);
}
}
