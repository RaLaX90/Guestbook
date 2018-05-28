<?php
	// з'єднання з БД
    include 'connect.php';
    header("Location: index.php");
	// перевірка з'єданння
	if ($mysqli -> connect_errno) {
		   	printf("Connection error.: %s\n", $mysqli->connect_error);
		   	exit();
		} else {
			echo "Connection nice.";
		}
?>