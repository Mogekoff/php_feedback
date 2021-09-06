<?php
	require_once('db.php');

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$message = pg_escape_string(htmlspecialchars(stripslashes(trim($_POST['message']))));

	$status = 'OK';
	$status_code = 200;
	$status_text = 'Запрос получен и сохранен.';

	$phone_regex = "/^\+7\d{10}$|^[7-8]\d{10}$/";
	$email_regex = "/^\w+@\w+\.\w+$/";

	if(!preg_match($phone_regex,$phone)) {
		$status = "ERROR";
		$status_code = 422;
		$status_text = 'Номер телефона указан в неправильном формате.';
		http_response_code(422);
	}
	else if(!preg_match($email_regex,$email)) {
		$status = "ERROR";
		$status_code = 422;
		$status_text = 'Адрес электронной почты указан в неправильном формате.';
		http_response_code(422);
	}
	else if(strlen($message)>1000) {
		$status = "ERROR";
		$status_code = 422;
		$status_text = 'Текст сообщения превышает 1000 символов.';
		http_response_code(422);
	}
	else if (!pg_query("INSERT INTO creds (email,phone,message) VALUES ('$email', '$phone', '$message')")){
		$status = "ERROR";
		$status_code = 500;
		$status_text = 'Внутренняя ошибка сервера.';
		http_response_code(500);
	}

	$json_response = json_encode(array(
		"status" => $status,
		"status_code" => $status_code,
		"status_text" => $status_text
	),JSON_UNESCAPED_UNICODE);

	echo $json_response;