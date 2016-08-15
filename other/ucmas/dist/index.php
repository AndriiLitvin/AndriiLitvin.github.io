<?php

$data = array(
	'name' => '',
	'yourname' => '',
	'phone' => '',
	'city' => '',
	'metro' => '',
);

if (isset($_POST['data'])) {
	$data = (array) json_decode($_POST['data']);
}

$message = "Регистрация: \n";
$message .= "Имя ребенка: {$data['name']} \n";
$message .= "Ваше имя: {$data['yourname']} \n";
$message .= "Телефон: {$data['phone']} \n";
$message .= "Город: {$data['city']} \n";
$message .= "Ваша станция метро: {$data['metro']} \n";

$to = "";
$headers = "Content-type: text/plain;charset=utf-8"; 
$subject = "=?UTF-8?B?".base64_encode("Заявка на регистрацию")."?=";

$status = mail($to, $subject, $message);
