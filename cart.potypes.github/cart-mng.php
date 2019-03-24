<?php
	if($mysqli = new mysqli('ip', 'user', 'password', "db name", 'port')) {
	} else {
		echo 'error 0';
	}
	if ($_GET['a'] == 'add') {
		if ($mysqli->query("SELECT * FROM `".$_COOKIE["PHPSESSID"]."`")) {
			$result = $mysqli->query("SELECT * FROM items WHERE id=".(int)$_GET['id']);
			if ($result->num_rows == 1) {
				$item = $result->fetch_assoc();
				$mysqli->query("INSERT INTO `".$_COOKIE["PHPSESSID"]."`(`id-item`,`name`,`price`,`src`,`type`) VALUES (".(int)$item['id'].", '".$mysqli->real_escape_string($item['name'])."', ".(int)$item['price'].",'".$mysqli->real_escape_string($item['src'])."', ".(int)$item['type'].")");
				header("Location: http://".$_SERVER['HTTP_HOST']."/protypes/cart/cart.php");
			} else {
				echo 'Аааа, нет такого предмета!';
				exit;
			}
		} else {
			$mysqli->query("CREATE TABLE `".$_COOKIE["PHPSESSID"]."`(`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `id-item` int(11) NOT NULL, `name` text NOT NULL, `price` int(11) NOT NULL, `src` text NOT NULL, `type` int(11) NOT NULL)");
			$result = $mysqli->query("SELECT * FROM items WHERE id=".(int)$_GET['id']);
			if ($result->num_rows == 1) {
				$item = $result->fetch_assoc();
				$mysqli->query("INSERT INTO `".$_COOKIE["PHPSESSID"]."`(`id-item`,`name`,`price`,`src`,`type`) VALUES (".(int)$item['id'].", '".$mysqli->real_escape_string($item['name'])."', ".(int)$item['price'].",'".$mysqli->real_escape_string($item['src'])."', ".(int)$item['type'].")");
				header("Location: http://".$_SERVER['HTTP_HOST']."/protypes/cart/cart.php");
			} else {
				echo 'Аааа, нет такого предмета!';
				exit;
			}
		}
	}
	if ($_GET['a'] == 'delete') {
		$mysqli->query("DELETE FROM `".$_COOKIE["PHPSESSID"]."` WHERE id=".(int)$_GET['id']);
		header("Location: http://".$_SERVER['HTTP_HOST']."/protypes/cart/cart.php");
	}
	if ($_GET['a'] == 'clear') {
		$mysqli->query("DROP TABLE `".$_COOKIE["PHPSESSID"]."`");
		header("Location: http://".$_SERVER['HTTP_HOST']."/protypes/cart/cart.php");
	}
?>