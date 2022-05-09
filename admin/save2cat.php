<?php
	// подключение библиотек
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	
	if(!addItemToCatalog($_GET["title"], $_GET["author"], $_GET["pubyear"], $_GET["price"]))
		{
			echo 'Произошла ошибка при добавлении товара в каталог';
		}
		else
		{
			header("Location: add2cat.php");
			exit;
		}
