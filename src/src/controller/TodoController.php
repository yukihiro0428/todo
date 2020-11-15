<?php
//コントローラーは処理の流れを制御する処理
class TodoController
{
	public function index()
	{
		$index = new ToDo;
		return $index->findAll();
	}
	public function detail()
	{
		$todo_id = $_GET['todo_id'];
		$detail = new ToDo;
		return $detail->findById($todo_id);
	}
	public function new()
	{
		$data = array(
			'title' => $_POST['title'],
			'detail' => $_POST['detail'],
		);

		//バリデート
		$validation = new TodoValidation;
		$validation->setData($data);
		if ($validation->check() === false) {
			$error_msgs = $validation->getErrorMessages();

			//セッションにエラーメッセージを追加
			session_start();
			$_SESSION['error_msgs'] = $error_msgs;

			$params = sprintf("?title=%s&detail=%s", $data['title'], $data['detail']);
			header("Location: ./new.php" . $params);
		} elseif ($validation->check() === true) {
			$validate_data = $validation->getData();
			$title = $validate_data['title'];
			$detail = $validate_data['detail'];

			$todo = new Todo;
			$todo->setTitle($title);
			$todo->setDetail($detail);
			$result = $todo->save();
			if ($result == false) {
				$params = sprintf("?title=%s&detail=%s", $title, $detail);
				header("Location: ./new.php" . $params);
			}
			header("Location: ./index.php");
		}
	}

	public function edit()
	{
		if (!empty($_GET['todo_id'])) {
			$todo_id = $_GET['todo_id'];
		} elseif ($_GET['id']) {
			$todo_id = $_GET['id'];
		}
		$edit = new ToDo;
		$todo = $edit->findById($todo_id);
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			return $todo;
		}
		$data = array(
			'id' => $_GET['todo_id'],
			'title' => $_POST['title'],
			'detail' => $_POST['detail']
		);
		$validation = new TodoValidation;
		$validation->setData($data);
		if ($validation->check() === false) {
			$error_msgs = $validation->getErrorMessages();

			//セッションにエラ〜メッセージを追加
			session_start();
			$_SESSION['error_msgs'] = $error_msgs;
			$params = sprintf("?title=%s&detail=%s&id=%s", $data['title'], $data['detail'], $data['id']);

			header("Location: ./edit.php" . $params);
		} elseif ($validation->check() === true) {
			$validate_data = $validation->getData();
			$id = $validate_data['id'];
			$title = $validate_data['title'];
			$detail = $validate_data['detail'];

			$todo = new Todo;
			$todo->setId($data['id']);
			$todo->setTitle($title);
			$todo->setDetail($detail);
			$result = $todo->update();
			if ($result == false) {
				$params = sprintf("?title=%s&detail=%s&id=%s", $title, $detail, $id);
				header("Location: ./edit.php" . $params);
			}
			header("Location: ./index.php");
		}
	}

	public function delete()
	{
		$todo_id = $_GET['todo_id'];
		$delete = new ToDo;
		$is_exist = $delete->isExistById($todo_id);
		if (!$is_exist) {
			session_start();
			$_SESSION['error_msgs'] = [
				sprintf("id=%sに該当するレコードが存在しません", $todo_id)
			];
			header('Location: ./index.php');
		}

		$todo = new Todo;
		$todo->setId($todo_id);
		$result = $todo->delete();
		if ($result === false) {
			session_start();
			$_SESSION['error_msgs'] = [sprintf('削除に失敗しました。 id=%s', $todo_id)];
		}

		header("Location: ./index.php");
	}

	public function completion()
	{
		$todo_id = $_GET['todo_id'];
		$completion = new Todo;
		$is_exist = $completion->isExistById($todo_id);
		if (!$is_exist) {
			session_start();
			$_SESSION['error_msgs'] = [
				sprintf("id=%sに該当するレコードが存在しません", $todo_id)
			];
			header('Location: ./index.php');
		}
		$todo = new Todo;
		$todo->setId($todo_id);
		$result = $todo->completion();
		if ($result === false) {
			session_start();
			$_SESSION['error_msgs'] = [sprintf('完了処理に失敗しました。 id=%s', $todo_id)];
		}
		header("Location: ./index.php");
	}

	public function completionCancel()
	{
		$todo_id = $_GET['todo_id'];
		$completionCancel = new Todo;
		$is_exist = $completionCancel->isExistById($todo_id);
		if (!$is_exist) {
			session_start();
			$_SESSION['error_msgs'] = [
				sprintf("id=%sに該当するレコードが存在しません", $todo_id)
			];
			header('Location: ./index.php');
		}
		$todo = new Todo;
		$todo->setId($todo_id);
		$result = $todo->completionCancel();
		if ($result === false) {
			session_start();
			$_SESSION['error_msgs'] = [sprintf('完了キャンセル処理に失敗しました。 id=%s', $todo_id)];
		}
		header("Location: ./index.php");
	}

	public function escape($string)
	{
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}
}
