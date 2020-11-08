<?php
//モデルファイルは、DBから値を取得したり、保存したりする処理を記述
class Todo
{
	//プロパティ
	public $pdo;
	public $id;
	public $title;
	public $detail;
	public $status;

	public function __construct()
	{
		$this->dbConnect();
	}
	public function dbConnect()
	{
		$dbHost = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] . ';charset=utf8';
		$dbUsername = $_ENV['DB_USERNAME'];
		$dbPassword = $_ENV['DB_PASSWORD'];
		try {
			$this->pdo = new PDO($dbHost, $dbUsername, $dbPassword);
		} catch (PDOException $e) {
			echo 'データベースにアクセス出来ません！' . $e->getMessage();
			exit;
		}
	}


	//メソッド
	public function getId()
	{
		return $this->id;
	}
	public function setId($id)
	{
		$this->id = $id;
	}
	public function getTitle()
	{
		return $this->title;
	}
	public function setTitle($title)
	{
		$this->title = $title;
	}
	public function getDetail()
	{
		return $this->detail;
	}
	public function setDetail($detail)
	{
		$this->detail = $detail;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function findByQuery($query)
	{
		$stmt = $this->pdo->query($query);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function findAll()
	{
		$query = "SELECT * FROM todos";
		$stmt = $this->pdo->query($query);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function findById($todo_id)
	{
		$query = sprintf('SELECT * FROM todos WHERE id = %s', $todo_id);
		$stmh = $this->pdo->query($query);
		if ($stmh) {
			$result = $stmh->fetch(PDO::FETCH_ASSOC);
		} else {
			$result = [];
		}
		return $result;
	}

	public function isExistById($todo_id)
	{
		$query = sprintf('SELECT * FROM todos WHERE id = %s', $todo_id);
		$stmt = $this->pdo->query($query);
		if (!$stmt) {
			return false;
		}
		return true;
	}

	public function save()
	{
		$query = sprintf(
			"INSERT INTO todos
			 (title, detail, status, created_at, updated_at)
			VALUES ('%s', '%s', 0, now(), now());",
			$this->title,
			$this->detail
		);

		try {
			//トランゼクション開始
			$this->pdo->beginTransaction();

			$stmt = $this->pdo->prepare($query);
			$stmt->execute();
			//コミット
			$this->pdo->commit();
		} catch (PDOException $e) {
			//ロールバック
			$this->pdo->rollBack();
			//エラーメッセージ出力
			echo $e->getMessage();
		}
	}

	public function update()
	{
		$query = sprintf(
			"UPDATE todos SET title = '%s', detail = '%s' WHERE id = '%s';",
			$this->title,
			$this->detail,
			$this->id
		);
		try {
			//トランザクション開始
			$this->pdo->beginTransaction();

			$stmt = $this->pdo->prepare($query);
			$stmt->execute();
			//コミット
			$this->pdo->commit();
		} catch (PDOException $e) {
			//ロールバック
			$this->pdo->rollBack();
			//エラーメッセージ出力
			echo $e->getMessage();
		}
	}

	public function delete()
	{
		try {
			//トランザクション開始
			$this->pdo->beginTransaction();
			$query = sprintf('DELETE FROM todos WHERE id = %s', $this->id);

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			$this->pdo->commit();
		} catch (PDOException $e) {
			//ロールバック
			$this->pdo->rollBack();

			echo $e->getMessage();
			$result = false;
		}
		return $result;
	}
	public function completion()
	{
		try {
			//トランザクション開始
			$this->pdo->beginTransaction();
			$query = sprintf(
				"UPDATE todos SET completed_at = now() WHERE id = '%s';",
				$this->id
			);

			$stmt = $this->pdo->prepare($query);
			$result = $stmt->execute();

			$this->pdo->commit();
		} catch (PDOException $e) {
			//ロールバック
			$this->pdo->rollBack();

			echo $e->getMessage();
			$result = false;
		}
		return $result;
	}
}
