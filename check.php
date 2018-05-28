<?
    // скрипт перевірки логіна

    // з'єднання з БД
    include 'connect.php';

    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
        $query = $mysqli -> query("SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
        $userdata = mysqli_fetch_assoc($query);

        if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])){
            setcookie("id", "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
            print "Щось не вийшло"."<br>";
            echo $userdata['user_hash']."<br>";
            echo $_COOKIE['hash']."<br>";
            echo $userdata['user_id']."<br>";
            echo $_COOKIE['id']."<br>";
            echo $userdata['user_ip']."<br>";
            echo $_SERVER['REMOTE_ADDR']."<br>";
        } else{
            print "Привіт, ".$userdata['user_login'].". Все працює! <br>";
            echo $userdata['user_hash']."<br>";
            echo $_COOKIE['hash']."<br>";
            echo $userdata['user_id']."<br>";
            echo $_COOKIE['id']."<br>";
            echo $userdata['user_ip']."<br>";
            echo $_SERVER['REMOTE_ADDR']."<br>";
        }
    } else{
        print "Ввімкніть куки <br>";
        echo $userdata['user_hash']."<br>";
        echo $_COOKIE['hash']."<br>";
        echo $userdata['user_id']."<br>";
        echo $_COOKIE['id']."<br>";
        echo $userdata['user_ip']."<br>"    ;
        echo $_SERVER['REMOTE_ADDR']."<br>";
    }
?>