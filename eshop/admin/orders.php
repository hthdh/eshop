<?php
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require_once "../inc/config.inc.php";


?>
<!DOCTYPE html>
<html>
<head>
	<title>Поступившие заказы</title>
	<meta charset="utf-8">
</head>
<body>
<h1>Поступившие заказы:</h1>
<?php
function getOrders(){
    global $link;
    if(!is_file(ORDER_LOG))
        return false;
    /* Получаем в виде массива персональные данные пользователей из файла */
    $orders = file(ORDER_LOG);
    /* Массив, который будет возвращен функцией */
    $allorders = [];
    foreach($orders as $order) {
        list($name, $email, $phone, $address, $orderid, $date) = explode("|", $order);
        /* Промежуточный массив для хранения информации о конкретном заказе */
        $orderinfo = [];
        /* Сохранение информацию о конкретном пользователе */
        $orderinfo["name"] = $name;
        $orderinfo["email"] = $email;
        $orderinfo["phone"] = $phone;
        $orderinfo["address"] = $address;
        $orderinfo["orderid"] = $orderid;
        $orderinfo["date"] = $date;
        /* SQL-запрос на выборку из таблицы orders всех товаров для конкретного
        покупателя */
        $sql = "SELECT title, author, pubyear, price, quantity
        FROM orders
        WHERE orderid = '$orderid' AND datetime = $date";
        /* Получение результата выборки */
        if(!$result = mysqli_query($link, $sql))
            return false;
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        /* Сохранение результата в промежуточном массиве */
        $orderinfo["goods"] = $items;
        /* Добавление промежуточного массива в возвращаемый массив */
        $allorders[] = $orderinfo;
    }
    return $allorders;
}
	$orders = getOrders();
	foreach($orders as $order){
?>
<hr>
<p><b>Заказчик</b>: <?= $order['name'] ?></p>
<p><b>Email</b>: <?= $order['email'] ?></p>
<p><b>Телефон</b>: <?= $order['phone'] ?></p>
<p><b>Адрес доставки</b>: <?= $order['address'] ?></p>
<p><b>Дата размещения заказа</b>: <?= date("d-m-Y H:i:s", $order['date']) ?></p>
<h3>Купленные товары:</h3>
<table border="1" cellpadding="5" cellspacing="0" width="90%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
</tr>
<?php
		$i = 1;
		$sum = 0;
	foreach($order['goods'] as $item){
		?>
			<tr>
				<th><?= $i ?></th>
				<th><?= $item['author'] ?></th>
				<th><?= $item['title'] ?></th>
				<th><?= $item['pubyear'] ?></th>
				<th><?= $item['price'] ?></th>
				<th><?= $item['quantity'] ?></th>
			</tr>
		<?php
		$i++;
		$sum += $item['price']*$item['quantity'];
	}
?>
</table>
<p>Всего товаров в заказе на сумму: <?echo $sum?>руб.</p>

<?
}
?>

</body>
</html>