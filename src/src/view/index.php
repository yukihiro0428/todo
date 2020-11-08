<?php
require_once __DIR__ . '/../model/Todo.php';
require_once __DIR__ . '/../controller/TodoController.php';

//削除処理
if (isset($_GET['action_delete']) & !empty($_GET['action_delete']) === true) {
	$action = new TodoController;
	$todo_list = $action->delete();
}
//完了処理
if (isset($_GET['action_completion']) & !empty($_GET['action_completion']) === true) {
	$action = new TodoController;
	$todo_list = $action->completion();
}
$action = new TodoController;
$todo_list = $action->index();

require 'header.php';
?>
<section class="common">
	<h2>一覧画面</h2>
	<p class="common-link"><a class="to-new_link" href="./new.php">新規作成画面へ</a></p>
	<h2>アプリ概要</h2>
	<p>リストの内容をクリックすると詳細画面へ飛びます</p>
	<?php if ($todo_list) : ?>
		<ul>
			<?php foreach ($todo_list as $todo) : ?>
				<li>
					<a href="./detail.php?todo_id=<?php echo $todo['id']; ?>">
						<?php echo $action->escape($todo['title']); ?>
					</a>
					<button class="delete_btn" data-id="<?php echo $todo['id']; ?>">削除ボタン</button>
					<p class="completion"><button class="completion_btn" data-id="<?php echo $todo['id']; ?>">完了ボタン</button>
						<?php if (isset($todo['completed_at'])) : ?>
							<span>タスク完了時刻：<?php echo $todo['completed_at'] ?></span>
						<?php endif; ?>
					</p>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<div>データなし</div>
	<?php endif; ?>


</section>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</body>

</html>
<script>
	//削除処理
	$('.delete_btn').on('click', function() {
		let message = "id='" + $(this).data('id') + "'を消しますか";
		let judge = confirm(message);
		if (judge == true) {
			let todo_id = $(this).data('id');
			window.location.href = "./index.php?action_delete=delete&todo_id=" + todo_id;
		} else if (judge == false) {
			window.location.href = "./index.php";
		}
	});
	//完了処理
	$('.completion_btn').on('click', function() {
		let message = "id='" + $(this).data('id') + "'の実行を完了しますか";
		let judge = confirm(message);
		if (judge == true) {
			let todo_id = $(this).data('id');
			window.location.href = "./index.php?action_completion=completion&todo_id=" + todo_id;
		} else if (judge == false) {
			window.location.href = "./index.php";
		}
	});
</script>
