<!DOCTYPE html>
<html>
	<head> 
		<title> Test </title>
		<link rel="stylesheet" href="style.css">
		<link rel="shortcut icon" href="ico.ico" type="image/x-icon">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://use.fontawesome.com/6854e2086f.js"></script>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Гостьова книга</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="#" data-toggle="modal" data-target="#myModal_about">Про автора</a></li>
					<li><a href="#" data-toggle="modal" data-target="#myModal_contact">Контакти</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="modal fade" id="myModal_about" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Про автора</h4>
				</div>
				<div class="modal-body">
					Автор цієї сторінки — Богдан Щербаков, який навчається в групі ПС-46. <br> Створено спеціально для О.О.
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myModal_contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Контакти</h4>
				</div>
				<div class="modal-body">
					<a href="https://t.me/gmastrbit" target="_blank"><i class="fa fa-telegram" aria-hidden="true"></i> Telegram</a> <br>
					<a href="https://vk.com/gmastrbit" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i> VK</a> <br>
					<a href="https://www.facebook.com/gmastrbit" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</a> <br>
					<a href="https://www.behance.net/gmastrbit" target="_blank"><i class="fa fa-behance" aria-hidden="true"></i> Behance</a> <br>
					<a href="mailto:gmastrbit@gmail.com" target="_blank"> <i class="fa fa-envelope" aria-hidden="true"></i> email</a>
				</div>
			</div>
		</div>
	</div>

	<div class="all">
		<h1><i class="fa fa-comments" aria-hidden="true"></i> Залиште коментар</h1>
		<br>

		<form>
			<div class="form-group">
				<label for="inputName">Ім'я або нікнейм</label>
				<input class="form-control" type="text" id="inputName" placeholder="Петро Іванов">
			</div>
			<div class="form-group">
				<label for="inputComment">Текст коментаря:</label>
				<textarea class="form-control" rows="5" id="inputComment" placeholder="Прекрасний приклад використання фреймворку Bootstrap для власних цілей."></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Надіслати <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
		</form>
		
		<br>
		<h1><i class="fa fa-eye" aria-hidden="true"></i> Перегляд всіх коментарів</h1>
		<br>

		<div class="panel panel-default">
			<div class="panel-heading">
				Петро Сагайдачний, 15.02.2018, 17:36
			</div>
			<div class="panel-body">
				Дуже класний сайт! Рекомендую.
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				Петро Сагайдачний, 15.02.2018, 17:36
			</div>
			<div class="panel-body">
				Дуже класний сайт! Рекомендую.
			</div>
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>