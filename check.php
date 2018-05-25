<?
    // Скрипт проверки

    // Соединяемся с БД
    $link = mysqli_connect("localhost", "mysql", "mysql", "hworknet_test");

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
        $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

     //    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
     // or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0"))){

        if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])){

            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
            print "Хм, что-то не получилось"."<br>";
            echo $userdata['user_hash']."<br>";
            echo $_COOKIE['hash']."<br>";
            echo $userdata['user_id']."<br>";
            echo $_COOKIE['id']."<br>";
            echo $userdata['user_ip']."<br>";
            echo $_SERVER['REMOTE_ADDR']."<br>";
        }
        else{
            print "Привет, ".$userdata['user_login'].". Всё работает! <br>";

            echo $userdata['user_hash']."<br>";
            echo $_COOKIE['hash']."<br>";
            echo $userdata['user_id']."<br>";
            echo $_COOKIE['id']."<br>";
            echo $userdata['user_ip']."<br>";
            echo $_SERVER['REMOTE_ADDR']."<br>";
        }
    }
    else{
        print "Включите куки <br>";

        echo $userdata['user_hash']."<br>";
        echo $_COOKIE['hash']."<br>";
        echo $userdata['user_id']."<br>";
        echo $_COOKIE['id']."<br>";
        echo $userdata['user_ip']."<br>"    ;
        echo $_SERVER['REMOTE_ADDR']."<br>";
    }
?>