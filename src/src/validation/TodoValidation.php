<?php
class TodoValidation
{
	public $data;
	public $error_msgs = array();

	public function setData($data)
	{
		$this->data = $data;
	}
	public function getData()
	{
		return $this->data;
	}

	public function getErrorMessages()
	{
		return $this->error_msgs;
	}

	public function check()
	{
		$id = $this->data['id'];

		$action = new TodoController;
		$title = $this->data['title'];
		$escapeTitle = $action->escape($title);
		$detail = $this->data['detail'];
		$escapeDetail = $action->escape($detail);
		//空だったらエラ〜メッセージを追加
		if (empty($escapeTitle)) {
			$this->error_msgs[] = 'タイトルを入力してください';
		}
		if (empty($escapeDetail)) {
			$this->error_msgs[] = '詳細を入力してください';
		}
		if (count($this->error_msgs) > 0) {
			return false;
		}
		return true;
	}
}
