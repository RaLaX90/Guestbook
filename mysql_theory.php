<?php

// підключення до БД
	$mysqli = new mysqli("localhost", "root", "", "myBase");
	$mysqli -> query("SET NAMES 'utf8'");

// перевірка з'єднання
	// if ($mysqli -> connect_errno) {
    //    	printf("Соединение не удалось: %s\n", $mysqli->connect_error);
    //    	exit();
	// } else {
	// 	echo "Connection nice.";
	// }

// основний код

	// додавання записів
		// $success = $mysqli -> query ("INSERT INTO `users` (`login`, `password`, `reg_date`) VALUES ('new_user1', '".md5("12345")."', '".time()."') 	");
		// echo $success;

		// for ($i = 1; $i < 10; $i++){
		// 	$mysqli -> query ("INSERT INTO `users` (`login`, `password`, `reg_date`) VALUES ('user$i', '".md5("$i*$i")."', '".time()."') 	");
		// }
		
		// $mysqli -> query ("INSERT INTO `myBase`.`users` (`id`, `login`, `password`, `reg_date`) VALUES (NULL, 'edel11', MD5('123123'), UNIX_TIMESTAMP())");

	// оновлення записів
		// $mysqli -> query ("UPDATE `myBase`.`users` SET `reg_date` = '111111' WHERE `users`.`id` = 14;");
		// $mysqli -> query ("UPDATE `myBase`.`users` SET `reg_date` = '5' WHERE `users`.`id` <= 5;");
		// $mysqli -> query ("UPDATE `myBase`.`users` SET `reg_date` = '0' WHERE `login` = 'shop' OR ((`id` > 4) AND (`id` < 8)) ");

	// видалення записів
		// $mysqli -> query ("DELETE FROM `myBase`.`users` WHERE `users`.`id` = 10");

	// вибірка записів 
	// function printResult($result_set){
	// 	while(($row = $result_set -> fetch_assoc()) != false){
	// 		print_r($row);
	// 		//echo $row["login"]; // виведен логіни лише
	// 		echo "<br>";
	// 	}
	// 	// echo "Кількість записів = ".$result_set -> num_rows."<br>";
	// }

	// вивести потрібний запис із таблиці
	// $query = mysql_query("SELECT `text` FROM `pass`", $db);
	// $array = mysql_fetch_array($query);
	// $passw = $array[0];
	
	// вивести всі логіни, паролі, дати
	// $result_set = $mysqli -> query("SELECT * FROM `users`");
	// printResult($result_set);

	// вивести лише id і лоіни
	// $result_set = $mysqli -> query("SELECT `id`, `login` FROM `users`");
	// $result_set = $mysqli -> query("SELECT `id`, `login` FROM `users` WHERE `id` > 7");
	// printResult($result_set);

	//	сортування id по зростанню цифри
	// $result_set = $mysqli -> query("SELECT * FROM `users` WHERE `id` < 8 ORDER BY `id` ASC"); // ASC - зростання, DESC - убування
	// printResult($result_set);

	// сортування логіна по алфавіту по зростанню
	// $result_set = $mysqli -> query("SELECT * FROM `users` WHERE `id` < 8 ORDER BY `login` ASC");
	// printResult($result_set);

	// LIMIT 0, 2 - почати вибірку з 0 запису і закінчити 2 записом (від 0 до 2)
	// $result_set = $mysqli -> query("SELECT * FROM `users` WHERE `id` < 8 LIMIT 0, 2");
	// printResult($result_set);

	// LIKE - подобіє, схоже
	// $result_set = $mysqli -> query("SELECT * FROM `users` WHERE `login` LIKE '%ser%'");
	// printResult($result_set);

	// COUNT 
	// $result_set = $mysqli -> query("SELECT COUNT(`id`) FROM `users`");
	// printResult($result_set);

// закриття з'єднання
	$mysqli -> close();

?>