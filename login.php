<?php
    // Страница авторизации

    // Функция для генерации случайной строки
    function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

    // Соединяемся с БД
    $link = mysqli_connect("localhost", "mysql", "mysql", "hworknet_test");

    if(isset($_POST['submit'])){
        // Вытаскиваем из БД запись, у которой логин равняется введенному
        $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
        $data = mysqli_fetch_assoc($query);

        // Сравниваем пароли
        if($data['user_password'] === md5(md5($_POST['password']))){
            // Генерируем случайное число и шифруем его
            $hash = md5(generateCode(10));

            // if(!empty($_POST['not_attach_ip'])){
                // Если пользователя выбрал привязку к IP
                // Переводим IP в строку
                // $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
            //     $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
            // } else {
            //     $insip = "";
            // }

            // Записываем в БД новый хеш авторизации и IP
            // mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");
            mysqli_query($link, "UPDATE users SET user_hash='".$hash."' , user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."') WHERE user_id='".$data['user_id']."'");

            // echo "<script> alert('".$insip."');</script>";

            // Ставим куки
            setcookie("id", $data['user_id'], time()+60*60*24*30);
            setcookie("hash", $hash, time()+60*60*24*30,null,null,null,true); // httponly !!!

            // Переадресовываем браузер на страницу проверки нашего скрипта
            // header("Location: check.php"); 
            header("Location: index.php"); 
            exit();
        } else{
            $message = '<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Вы ввели неправильный логин/пароль</div>';
        }
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
                 <!-- <div class="checkbox" style="display: none;">  -->
<!--                  <div class="checkbox" > 
                    <label> 
                        <input type="checkbox" name="not_attach_ip" checked value=""> 
                    </label> 
                </div> -->

                <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-arrow-right" aria-hidden="true"></i> Ввійти</button>
            </form>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>