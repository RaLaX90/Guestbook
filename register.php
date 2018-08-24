<?php
// Сторінка реєстрації нового користувача

// з'єднання з БД
include 'connect.php';

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    $query = $mysqli->query("SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '" . intval($_COOKIE['id']) . "' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    // Перевірка на логін користувача
    if (($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])) {
        setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");
    } else {
        header("Location: index.php");
    }
}

if (isset($_POST['submit'])) {
    $err = [];

    // Перевірка логіну
    if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['login'])) {
        $err[] = "Логін може складатися лише з букв англійського алфавіту та цифр";
    }

    if (strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30) {
        $err[] = "Логін повинен бути не менше 3-х символів і не більше 30";
    }

    // Перевіряєм чи не існує користувача з таким іменем
    $query = $mysqli->query("SELECT user_id FROM users WHERE user_login='" . mysqli_real_escape_string($mysqli, $_POST['login']) . "'");
    if (mysqli_num_rows($query) > 0) {
        $err[] = "Користувач з таким логіном вже існує в базі даних";
    }

    // Якщо немає помилок, додаємо нового користувача в БД
    if (count($err) == 0) {
        $login = $_POST['login'];

        // Прибираємо лишні пробіли і подвійно хешуємо пароль
        $password = md5(md5(trim($_POST['password'])));

        $mysqli->query("INSERT INTO users SET user_login='" . $login . "', user_password='" . $password . "'");

        // Після вдалої реєстрації перенаправлення на сторінку авторизації
        header("Location: login.php");
        exit();
    } else {
        $message1 = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        foreach ($err AS $error) {
            $message2 = $error . "<br>";
            $message3 = "</div>";
        }
    }
    $message = $message1 . $message2 . $message3;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title> Гостьова книга </title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120229196-3"></script>
    <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-120229196-3');

    </script>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="ico.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.0.3/bootstrap-show-password.min.js"></script>
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
            <div class="input-append input-group">
                <input required id="password" class="form-control" type="password" name="password" data-placement="before">
                <input type="text" class="form-control" style="display: none;">
            </div>
        </div>
        <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-plus" aria-hidden="true"></i> Зареєструватися</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="bsp.min.js"></script>
<script>
        $(function() {
          $('#password').password()
          .password('focus')
          .on('show.bs.password', function(e) {
            $('#eventLog').text('On show event');
            $('#methods').prop('checked', true);
          }).on('hide.bs.password', function(e) {
            $('#eventLog').text('On hide event');
            $('#methods').prop('checked', false);
          });
          $('#methods').click(function() {
            $('#password').password('toggle');
          });
        });

</script>
</body>
</html>