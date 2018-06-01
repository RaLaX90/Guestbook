<?php
    // сторінка авторизації

    // з'єднання з БД
    include 'connect.php';

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
        $query = $mysqli -> query("SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        // перевірка на логін користувача
        if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])){
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
        } else{
            header("Location: index.php");
        }
    } 

    // функція для генерації випадкового числа
    function generateCode($length = 6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }


    if(isset($_POST['submit'])){
        // витягуємо із БД запис, в якій логін дорівнює введеному
        $query = $mysqli -> query("SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($mysqli, $_POST['login'])."' LIMIT 1");
        $data = mysqli_fetch_assoc($query);

        // порівнюємо паролі (по значенню і типу)
        if($data['user_password'] === md5(md5($_POST['password']))){
            // генеруємо випадкове число і шифруємо його подвійним md5 шифруванням
            $hash = md5(generateCode(10));

            // записуємо в БД новий хеш авторизації і ІР
            $mysqli -> query("UPDATE users SET user_hash='".$hash."' , user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."') WHERE user_id='".$data['user_id']."'");

            // встановлюємо куки
            setcookie("id", $data['user_id'], time()+60*60*24*30);
            setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true); 

            // після логіну переадресація на головну
            header("Location: index.php"); 
            exit();
        } else{
            $message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Ви ввели невірний логін або пароль</div>';
        }
    }
?>
<!DOCTYPE html>
<html>
    <head> 
        <title> Гостьова книга </title>
        <!-- Global site tag (gtag.js) - Google Analytics -->
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
                    <li class="active"><a href="login.php">Вхід</a></li>
                    <li><a href="register.php">Реєстрація</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="all">
    <?php echo $message; ?>
     <h1><i class="fa fa-sign-in" aria-hidden="true"></i> Вхід в акаунт </h1>
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
                <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-arrow-right" aria-hidden="true"></i> Ввійти</button>
            </form>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>