<?php
$conn = mysqli_connect('#####', '#####', '#####', '#####');

function check_valid_token($id_pribor, $token, $conn)
{
	$res = mysqli_query($conn, "SELECT token FROM token_pribor WHERE id_pribor = ".$id_pribor);
	$row = mysqli_fetch_array($res);
	if ($row['token'] == $token)
	{
		return true;
	}
	return false;
}

if (!$conn)
	die('Нет соединения');

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$email = $_GET['email'];
	$id_pribor = $_GET['id'];
	$token = $_GET['token'];

	if ($token && is_numeric($id_pribor))
	{
		$valid = check_valid_token($id_pribor, $token, $conn);
	}

	// echo "email= ".$email."<br>";
	// echo "id_pribor= ".$id_pribor."<br>";
	// echo "token= ".$token."<br>";
	// echo "valid= ".$valid."<br>";


	echo "<br><h2>Удаление из рассылки ХИМКО электронного адресса ".$email." .</h2><br>";
	if (filter_var($email, FILTER_VALIDATE_EMAIL) != false && $valid)
	{
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		// echo "email= ".$email."<br>";
		$result = mysqli_query($conn, "INSERT INTO black_list_email (email)
			SELECT '".$email."' FROM DUAL
		WHERE NOT EXISTS (SELECT id FROM black_list_email WHERE email = '".$email."')");
		
		if ($result == 1)
			echo "<p>Готово! Вы больше не будете получать уведомления о состоянии прибора на Ваш почтовый ящик ".$email."</p><br>";
		else
			echo "<p>Произошла ошибка при удалении почового ящика из рассылки.</p><br>";
	}
	else
	{
		echo "<p>Невалидные данные!</p><br>";
	}

}


?>