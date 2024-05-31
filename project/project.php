<?php
// データベース接続クラスの読み込み
require('/Applications/MAMP/htdocs/task_app/db/dbconnection.php');

class Project {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    // プロジェクト作成メソッド
    public function createProject($user_id, $name, $description, $color) {
        $sql = 'INSERT INTO projects (user_id, name, description, color_type, created_at) VALUES (?, ?, ?, ?, NOW())';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$user_id, $name, $description, $color]);
    }

    // idからプロジェクト取得メソッド
    public function getProject($project_id) {
        $sql = 'SELECT * FROM projects WHERE id = ?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$project_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 全てのプロジェクト取得メソッド
    public function getAllProjects() {
        $sql = 'SELECT * FROM projects WHERE user_id = ?';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
