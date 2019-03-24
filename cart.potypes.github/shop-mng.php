<?php
if($mysqli = new mysqli('ip', 'user', 'password', "db name", 'port')) {
	
} else {
	echo 'error 0';
}
	if ($_GET['a'] == 'cat-add') {
		if (isset($_POST['name'])) {
			$result = $mysqli->query("SELECT * FROM categories WHERE name='".$mysqli->real_escape_string($_POST['name'])."'");
			if ($result->num_rows != 1) {
				$mysqli->query("INSERT INTO `categories`(`name`) VALUES ('".$mysqli->real_escape_string($_POST['name'])."')");
				header("Location: http://".$_SERVER['HTTP_HOST'].'/protypes/cart/shop-panel.php?');
			}
		} else {
			echo 'Чего то не хватает <img src="https://i.imgur.com/Z5i4aSc.png">';
		}
	}
	if ($_GET['a'] == 'cat-del') {
		if ($_GET['id'] != '') {
			$mysqli->query("DELETE FROM `categories` WHERE id=".(int)$_GET['id']);
			header("Location: http://".$_SERVER['HTTP_HOST'].'/protypes/cart/shop-panel.php?a=reload');
		}
	}
	if ($_GET['a'] == 'add-prod') {
		if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['type'])) {
			$result = $mysqli->query("SELECT * FROM `item` WHERE name='".$mysqli->real_escape_string($_POST['name'])."'");
			if ($result->num_rows != 1) {
				$mysqli->query("INSERT INTO `items`(`name`,`price`,`type`) VALUES ('".$mysqli->real_escape_string($_POST['name'])."', ".(int)$_POST['price'].", ".(int)$_POST['type'].")");
				header("Location: http://".$_SERVER['HTTP_HOST'].'/protypes/cart/shop-panel.php?a=reload');
			} else {
				echo 'Такой предмет уже есть! ъеь!';
			}
		} else {
			echo 'Чего то не хватает <img src="https://i.imgur.com/Z5i4aSc.png">';
		}
	}
	if ($_GET['a'] == 'upd-prod') {
		if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['type'])) {
			$result = $mysqli->query("SELECT * FROM `item` WHERE name='".$mysqli->real_escape_string($_POST['name'])."'");
			if ($result->num_rows == 1) {
				$mysqli->query("UPDATE `items` SET name='".$mysqli->real_escape_string($_POST['name'])."' price=".(int)$_POST['price']." type=".(int)$_POST['type']." WHERE id=".(int)$_POST['id']);
				header("Location: http://".$_SERVER['HTTP_HOST'].'/protypes/cart/shop-panel.php?a=reload');
			} else {
				echo 'Такого предмета нет!';
			}
		} else {
			echo 'Чего то не хватает <img src="https://i.imgur.com/Z5i4aSc.png">';
		}
	}
	if ($_GET['a'] == 'del-prod') {
		if ($_GET['id'] != '') {
			$mysqli->query("DELETE FROM `items` WHERE id=".(int)$_GET['id']);
			header("Location: http://".$_SERVER['HTTP_HOST'].'/protypes/cart/shop-panel.php?a=reload');
		}
	}
	if ($_GET['a'] == 'add-code') {
		if (isset($_POST['code'])) {
			$result = $mysqli->query("SELECT * FROM codes WHERE code=".(int)$_POST['code']);
			if ($result->num_rows != 1) {
				$mysqli->query("INSERT INTO `codes`(`code`) VALUES (".(int)$_POST['code'].")");
				header("Location: http://".$_SERVER['HTTP_HOST'].'/protypes/cart/shop-panel.php?a=reload');
			} else {
				echo 'Такой код уже есть!';
			}
		} else {
			echo 'Чего то не хватает <img src="https://i.imgur.com/Z5i4aSc.png">';
		}
	}
	if ($_GET['a'] == 'del-code') {
		if ($_GET['id'] != '') {
			$mysqli->query("DELETE FROM codes WHERE id=".(int)$_GET['id']);
			header("Location: http://".$_SERVER['HTTP_HOST'].'/protypes/cart/shop-panel.php?a=reload');
		}
	}
	// 0_o памагити!!
?>