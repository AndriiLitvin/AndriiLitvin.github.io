<?php 
function getVar($name)
{
	return isset($_POST[$name]) ? trim($_POST[$name]) : null;
}

$data=array(
	'name' 	 => getVar('name'),
	'email'  => getVar('email'),
	'phone'  => getVar('phone')
);

$to = implode(",", [
	"info@greenfirm.pro",
]);

$headers = "Content-type: text/plain;charset=utf-8"; 
$subject = "=?UTF-8?B?".base64_encode("Заявка на регистрацию")."?=";

$send_data = $data;
unset($send_data['name']);

array_walk($send_data, function(&$val, $key) {
	$val = "$key: $val";
});

$message = implode("\r\n", $send_data);

$status = mail($to, $subject, $message);

header('Location: /nextstep/index.html');