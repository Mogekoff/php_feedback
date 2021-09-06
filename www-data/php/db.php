<?php
	ini_set('display_errors', 1);   //вывод ошибок выключен

	$creds_json = file_get_contents("credential.json");
	$creds = json_decode($creds_json, true);

	$db_connection = pg_connect("host=".$creds['host']." dbname=".$creds['dbname']." user=".$creds['username']." password=".$creds['password']);
