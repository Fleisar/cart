<?php
if($mysqli = new mysqli('ip', 'user', 'password', "db name", 'port')) {
	
} else {
	echo 'error 0';
}
if ($_GET['a'] == 'reload') {
	header("Location: http://".$_SERVER['HTTP_HOST']."/protypes/cart/shop-panel.php");
}
?>
<style>
body {
	margin: 30px 0 0 0;
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
.header > a {
	padding-left: 10px;
	color: #fff;
}
.item-config {
	height: 0;
	overflow: hidden;
	position: absolute;
}
.item-name:hover + .item-config {
	height: auto;
}
.item-config:hover {
	height: auto;
}
.codes, .categories, .product {
	display: inline-block;
}
.codes, .categories {
	width: 50%;
	height: 300px;
}
.codes {
	position: absolute;
	right: 0;
}
.categories {
	position: absolute;
	left: 0;
}
.categories-items {
	overflow: scroll;
	height: calc(300px - 17.89px - 21.11px);
}
.codes-item {
	overflow: scroll;
	height: calc(300px - 17.89px - 21.11px);
}
.product {
	margin-top: 300px;
	width: 100%;
	height: calc(100% - 300px);
	overflow: hidden;
}
.product-items {
	width: 100%;
	height: calc(100% - 36.67px - 21.11px - 42.88px);
}
</style>
<html>
	<head>
		<meta charset="utf-8">
		<title>sandbox.fleis.xyz | SHOP PANEL</title>
	</head>
	<body>
		<div class="header">
			<a>Вай магазин! Покупай что хош!</a>
		</div>
		<div class="categories">
			<a>Категории</a>
			<div class="categories-items">
				<?php
					$result = $mysqli->query("SELECT * FROM categories");
					if ($result->num_rows != 0) {
						while ($categorie = $result->fetch_assoc()) {
							echo '
								<div class="categorie">
									<a>'.$categorie['name'].'</a>
									<a href="/protypes/cart/shop-mng.php?a=cat-del&id='.$categorie['id'].'">Убрать</a>
								</div>
							';
						}
					} else {
						echo 'Добавь категории!';
					}
				?>
			</div>
			<div class="categories-add">
				<form action="shop-mng.php?a=cat-add" method="POST">
					Название: <input type="text" name="name">
					<button>Добавить</button>
				</form>
			</div>
		</div>
		<div class="codes">
			<a>Коды регистрации</a>
			<div class="codes-item">
				<?php
					$result = $mysqli->query("SELECT * FROM codes");
					if ($result->num_rows != 0) {
						while ($code = $result->fetch_assoc()) {
							echo '
								<div class="code">
									<a>'.$code['code'].'</a>
									<a href="/protypes/cart/shop-mng.php?a=del-code&id='.$code['id'].'">Нафиг</a>
								</div>
							';
						}
					} else {
						echo 'Тю-тю';
					}
				?>
			</div>
			<form action="/protypes/cart/shop-mng.php?a=add-code" method="POST">
				Код: <input type="text" name="code">
				<button>Добавить</button>
			</form>
		</div>
		<div class="product">
		<h1>Товар</h1>
			<div class="product-items">
				<?php
					$result = $mysqli->query("SELECT * FROM items");
					if ($result->num_rows != 0) {
						while ($item = $result->fetch_assoc()) {
							echo '
								<div class="item">
									<a href="/protypes/cart/shop-mng.php?a=del-prod&id='.$item['id'].'">Нафиг</a>
									<a class="item-name">'.$item['name'].'</a>
									<div class="item-config">
										<form action="/protypes/cart/shop-mng.php?a=upd-prod" method="POST">
											<input type="hidden" name="id" value="'.$item['id'].'">
											<input type="text" name="name" value="'.$item['name'].'">
											<input type="text" name="price" value="'.$item['price'].'">
											<select name="type">
							';
							$tmp = $mysqli->query("SELECT * FROM categories");
							if ($tmp->num_rows != 0) {
								while ($categorie = $tmp->fetch_assoc()) {
									if ($categorie['id'] == $item['type']) {
										echo '<option value='.$categorie['id'].' selected>'.$categorie['name'].'</option>';
									} else {
										echo '<option value='.$categorie['id'].'>'.$categorie['name'].'</option>';
									}
								}
							} else {
								echo '<option>Пусто</option>';
							}
							echo '
											</select>
											<button>Изменить</button>
										</form>
									</div>
								</div>
							';
						}
					} else {
						echo 'Нетю тут ничего :/';
					}
				?>
			</div>
			<div class="product-add">
				<form action="shop-mng.php?a=add-prod" method="POST">
					Название: <input type="text" name="name">
					Цена: <input type="text" name="price">
					Категория: <select name="type">
						<?php
							$result = $mysqli->query("SELECT * FROM categories");
							if ($result->num_rows != 0) {
								while ($categorie = $result->fetch_assoc()) {
									echo '<option value='.$categorie['id'].'>'.$categorie['name'].'</option>';
								}
							} else {
								echo '<option>Пусто</option>';
							}
						?>
					</select>
					<button>Добавить</button>
				</form>
			</div>
		</div>
	</body>
</html>