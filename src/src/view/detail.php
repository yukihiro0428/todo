<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/Todo.php';
require_once __DIR__ . '/../controller/TodoController.php';

$action = new TodoController;
$todo = $action->detail();
require 'header.php';
?>
<section class="common">
	<h2>詳細画面</h2>
	<p class="common-link"><a class="to-index_link" href="./index.php">一覧画面へ</a></p>
	<table>
		<thead>
			<tr>
				<th>タイトル</th>
				<th>詳細</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td scope="row"><?php echo $todo['title'] ?></td>
				<td><?php echo $todo['detail'] ?></td>
			</tr>
		</tbody>
	</table>
	<div>
		<button class="edit-btn"><a href="./edit.php?todo_id=<? echo $todo['id']; ?>">編集</a></button>
	</div>
</section>

</body>

</html>
