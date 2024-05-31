<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了</title>
    <!-- css -->
    <link rel="stylesheet" href="http://localhost/task_app/assets/css/style.css">
</head>

<body>
    <h2>登録完了</h2>

    <?php
    try {
        // 入力データを取得およびサニタイズ
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
        $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
        $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');
        $file_data = base64_decode($_POST['file_data']);
        $file_mime = htmlspecialchars($_POST['file_mime'], ENT_QUOTES, 'UTF-8');

        // ファイルの保存ディレクトリ（ローカルファイルパス）
        $upload_dir = '../assets/images/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // ディレクトリがない場合に作成する
        }

        // ファイル名の設定
        $newfilename = date("YmdHis") . ".jpg"; // 作成日時からファイル名設定（被らないようにするため）
        $file_path = $upload_dir . $newfilename;

        // 公開URLのパス
        $file_url = 'http://localhost/task_app/assets/images/' . $newfilename;

        // DBに情報を保存
        require('../db/dbconnection.php'); // DB接続ファイルを読み込む

        // パスワードをハッシュ化
        $hashed_pass = md5($pass);

        // SQL文
        $sql = 'INSERT INTO users (name, email, password, path, created_at) VALUES (?, ?, ?, ?, NOW())';
        $stmt = $dbh->prepare($sql);
        $data = array($name, $mail, $hashed_pass, $file_url);
        $stmt->execute($data);

        // データベース接続を終了
        $dbh = null;

        // ファイルの保存
        if (file_put_contents($file_path, $file_data)) {
            print "<p>登録完了</p>";
            print "<p>名前：{$name}</p>";
            print "<p>メールアドレス：{$mail}</p>";
            print "<p>パスワード：{$pass}</p>";
            print "<p>写真：</p>";
            print "<img src='{$file_url}' alt='Uploaded Image' style='max-width: 300px; max-height: 300px;'>";
            print "<p><a href='login.php'>ログイン</a></p>";
        } else {
            print "<p>ファイルの保存に失敗しました。</p>";
        }
    } catch (Exception $e) {
        print "<p>エラーが発生しました: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
        exit();
    }
    ?>

</body>

</html>