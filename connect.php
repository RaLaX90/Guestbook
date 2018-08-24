<?php
	// підключаємося до БД
	$mysqli = new mysqli("localhost", "hworknet_admin", "11223344", "hworknet_test");
	// $mysqli = new mysqli("localhost", "mysql", "mysql", "hworknet_test");
	$mysqli -> query("SET NAMES 'utf8'");