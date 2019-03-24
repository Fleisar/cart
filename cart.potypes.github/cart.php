<?php
if (isset($_COOKIE['PHPSESSID'])) {
} else {
	session_start();
}
if($mysqli = new mysqli('ip', 'user', 'password', "db name", 'port')) {
	
} else {
	echo 'error 0';
}
?>
<style>
body {
	margin: 30px 20px 30px 20px;
}
.header {
	position: fixed;
	left: 0;
	top: 0;
	width: 100%;
	height: 20px;
	background: #999;
	overflow: hidden;
}
.login {
	position: absolute;
	right: 0;
	display: inline-block;
}
.header > a {
	padding-left: 10px;
	color: #fff;
}
.categories {
	background: #bbb;
	padding: 10px;
}
.categories > a {
	padding: 8px;
	color: #fff;
}
.categories > a:hover {
	background: #999;
	color: #fff;
}
.content {
	box-shadow: 0 0 0 1px #f00;
	margin-top: 20px;
}
.cart {
	height: 18px;
	overflow: hidden;
	background: #000;
	color: #fff;
	display: inline-block;
	width: 280px;
	position: fixed;
	bottom: 20px;
	right: 20px;
	padding: 2px;
}
.cart:hover {
	height: auto;
}
.cart > .items {
	background: #444;
}
.cart > a {
	color: #fff;
}
</style>
<html>
	<head>
		<meta charset="utf-8">
		<title>sandbox.fleis.xyz | CART</title>
	</head>
	<body>
		<div class="header">
			<a>Вай магазин! Покупай что хош!</a>
			<?php
				$result = $mysqli->query("SELECT * FROM users WHERE session='".$_COOKIE['PHPSESSID']."'");
				if ($result->num_rows == 1) {
					echo '
						<div class="login">
							<a href="/protypes/cart/shop-panel.php">Panel</a>
						</div>
					';
				} else {
					echo '
						<div class="login">
							<form action="/core.php" method="POST">
								<input type="text" name="login">
								<input type="password" name="password">
								<button>Войти!</button>
							</from>
						</div>
					';
				}
			?>
		</div>
		<div class="categories">
			<?php
			$result = $mysqli->query("SELECT * FROM categories");
			if ($result->num_rows == 0) {
				echo '<a>Тутачки ничего нет!</a>';
			} else {
				while ($categories = $result->fetch_assoc()) {
					echo '
						<a href="http://'.$_SERVER['HTTP_HOST'].'/protypes/cart/cart.php?sort='.$categories['id'].'">'.$categories['name'].'</a>
					';
				}
			}
			?>
		</div>
		<div class="content">
			<?php
				if (isset($_GET['sort'])) {
					$result = $mysqli->query("SELECT * FROM categories WHERE id=".$_GET['sort']);
					$row = $result->fetch_assoc();
					echo '<h2>'.$row['name'].'</h2>';
					$result = $mysqli->query("SELECT * FROM items WHERE type='".(int)$_GET['sort']."' ORDER BY id DESC");
				} else {
					$result = $mysqli->query("SELECT * FROM items ORDER BY id DESC");
				}
				if ($result->num_rows == 0) {
					echo 'И тутачки ничего нет :D';
				} else {
					while ($item = $result->fetch_assoc()) {
						echo '
							<div class="item">
								<img src="/protypes/cart/d/'.$item['img'].'.jpg">
								<a>'.$item['name'].' | Цена: '.$item['price'].'</a>
								<a href="/protypes/cart/cart-mng.php?a=add&id='.$item['id'].'">Добавить в лукошко</a>
							</div>
						';
					}
				}
			?>
		</div>
		<div class="cart">
			<a>Лукошко</a>
			<div class="items">
				<?php
					$cost = 0;
					$result = $mysqli->query("SELECT * FROM ".$_COOKIE['PHPSESSID']);
					if ($result->num_rows == 0) {
						echo 'Тут пусто';
					} else {
						while ($item = $result->fetch_assoc()) {
							$cost = $cost + $item['price'];
							echo '
								<div class="item">
									<a>'.$item['name'].' | '.$item['price'].'</a>
									<a href="/protypes/cart/cart-mng.php?a=delete&id='.$item['id'].'">Выкинуть</a>
								</div>
							';
						}
					}
				?>
			</div>
			<a>Итого: <?php echo $cost;?></a>
			</br>
			<a href="/protypes/cart/cart-mng.php?a=clear">Выкинуть всё</a>
			<a href="/protypes/cart/buy.php">Взять</a>
		</div>
	</body>
</html>