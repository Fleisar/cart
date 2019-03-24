<?php
	if($mysqli = new mysqli('ip', 'user', 'password', "db name", 'port')) {
		if ($mysqli->query("SELECT * FROM users")) {
			
		} else {
			$mysqli->query("CREATE TABLE `users`(`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `login` text NOT NULL, `password` text NOT NULL, `session` text NOT NULL)");
		}
		if ($mysqli->query("SELECT * FROM codes")) {
			
		} else {
			$mysqli->query("CREATE TABLE `codes`(`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `code` int(11) NOT NULL)");
		}
	} else {
		echo 'error 0';
	}
	if ($_POST['login'] != '' && $_POST['password'] != '' && $_POST['code'] != '') {
		$result = $mysqli->query("SELECT * FROM codes WHERE code='".(int)$_POST['code']."'");
		if ($result->num_rows == 1) {
			$result = $mysqli->query("SELECT * FROM users WHERE login='".$mysqli->real_escape_string($_POST['login'])."'");
			if ($result->num_rows != 1) {
				$mysqli->query("INSERT INTO `users`(`login`,`password`,`session`) VALUES ('".$mysqli->real_escape_string($_POST['login'])."','".md5(md5($_POST['password']))."','".$_COOKIE['PHPSESSID']."')");
				header("Location: http://".$_SERVER['HTTP_HOST'].'/protypes/cart/shop-panel.php');
			} else {
				echo 'Такой логин уже есть :/';
				exit;
			}
		} else {
			echo 'А код то неверный!';
		}
	} else {
		echo 'Чего то не хватает <img src="https://i.imgur.com/Z5i4aSc.png">';
	}
?>