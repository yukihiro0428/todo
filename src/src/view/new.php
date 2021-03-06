<?php
require_once __DIR__ . '/../model/Todo.php';
require_once __DIR__ . '/../controller/TodoController.php';
require_once __DIR__ . '/../validation/TodoValidation.php';

session_start();
//セッション情報の取得
if (!empty($_SESSION['error_msgs'])) {
	$error_msgs = $_SESSION['error_msgs'];
	//セッション削除
	unset($_SESSION['error_msgs']);
} else {
	$error_msgs = '';
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$action = new TodoController;
	$action->new();
}
$title = '';
$detail = '';
if ($_SERVER["REQUEST_METHOD"] === "GET") {
	if (isset($_GET['title'])) {
		$title = $_GET['title'];
	}
	if (isset($_GET['detail'])) {
		$detail = $_GET['detail'];
	}
}
require 'header.php';
?>

<?php if ($error_msgs) : ?>
	<div>
		<ul class="errors-lists">
			<?php foreach ($error_msgs as $error_msg) : ?>
				<li><?php echo $error_msg; ?></li>
			<?php endforeach ?>
		</ul>
	</div>
<?php endif; ?>
<section class="common">
	<h2>新規作成画面</h2>
	<p class="common-link"><a class="to-index_link" href="./index.php">一覧画面へ</a></p>
	<form action="./new.php" method="post">
		<div>
			<h3>タイトル</h3>
			<p><input type="text" name="title" value="<?php echo $title; ?>"></p>
		</div>
		<div>
			<h3>詳細</h3>
			<p><textarea name="detail" id="" cols="30" rows="10"><?php echo $detail; ?></textarea></p>
		</div>
		<button class="entry-btn" type="submit">登録</button>
	</form>
</section>
</body>

</html>
