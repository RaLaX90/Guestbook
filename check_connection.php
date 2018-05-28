<?php
	// з'єднання з БД
    include 'connect.php';

	// перевірка з'єданння
	if ($mysqli -> connect_errno) {
		   	printf("Connection error.: %s\n", $mysqli->connect_error);
		   	exit();
		} else {
			echo "Connection nice.";
		}
?>