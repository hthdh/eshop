<?php
	require "inc/lib.inc.php";
	require_once "inc/config.inc.php";

	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$customer = session_id();
	$dt = time();
	
	$order = "$name|$email|$phone|$address|$customer|$dt\n";
	
	file_put_contents(ORDER_LOG, $order, FILE_APPEND);

	saveOrder($dt);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>