<?php
    // Страница регистрации нового пользователя

    // Соединямся с БД
    $link = mysqli_connect("localhost", "mysql", "mysql", "hworknet_test");

    if(isset($_POST['submit'])){
        $err = [];

        // проверям логин
        if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login'])){
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
        }

        if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30){
            $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
        }

        // проверяем, не сущестует ли пользователя с таким именем
        $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
        if(mysqli_num_rows($query) > 0){
            $err[] = "Пользователь с таким логином уже существует в базе данных";
        }

        // Если нет ошибок, то добавляем в БД нового пользователя
        if(count($err) == 0){

            $login = $_POST['login'];

            // Убераем лишние пробелы и делаем двойное хеширование
            $password = md5(md5(trim($_POST['password'])));

            mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
            header("Location: login.php"); 
            exit();
        }
        else {
            $message1 = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            foreach($err AS $error) {
                $message2 = $error."<br>";
                $message3 = "</div>";
            }
        }
        $message = $message1.$message2.$message3;
    }
?>
<!DOCTYPE html>
<html>
    <head> 
        <title> Гостьова книга </title>
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
                <a class="navbar-brand" href="http://hwork.net/guestbook/">Гостьова книга</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="login.php">Вхід</a></li>
                    <li class="active"><a href="register.php">Реєстрація</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="all">
         <?php echo $message; ?>
        <h1><i class="fa fa-user-plus" aria-hidden="true"></i> Реєстрація </h1>
        <br>
        <form method="POST">
            <div class="form-group">
                <label for="inputName">Логін</label>
                <input required class="form-control" type="text" name="login">
            </div>
            <div class="form-group">
                <label for="inputComment">Пароль</label>
                <input required class="form-control" type="password" name="password">
            </div>
            <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-plus" aria-hidden="true"></i> Зареєструватися</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>