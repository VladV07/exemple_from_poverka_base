<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, intial-scale=1.0">
  <style>
	#myBtn {
	display: none;
	position: fixed;
	bottom: 20px;
	right: 30px;
	z-index: 99;
	font-size: 18px;
	border: none;
	outline: none;
	background-color: transparent;
	color: green;
	cursor: pointer;
	padding: 15px;
	border-radius: 4px;
	}

	#myBtn:hover {
	color: white;
	background-color: green;
	}
  </style>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>ХИМКО поверка</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

</head>
<style> 
body 
{
  overflow-y: scroll;
}
@media screen and (min-width: 1240px) 
{
	.container
	{
		min-width: 1240px;
	}
}
</style>
<body>
	<div class="container">

		<?php require_once "../navbar/navbar.php"; ?>

		<?php

		require_once("../Classes/ClassPoverka.php");

		$json = array();
		date_default_timezone_set('Europe/Moscow');

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			$poverka = new Poverka;

			$id_poverka = base64_decode($_GET['id_poverka']);

			$id_pribor = base64_decode($_GET['id_pribor']);

			if (!empty($id_poverka) && is_numeric($id_poverka))
			{
				if (!$poverka->getResultQuery("SELECT * FROM `poverka` WHERE `id` = ".$id_poverka))
					echo $poverka->getConnError();
				$poverka->getPrintResult();
			}

			if (!empty($id_pribor) && is_numeric($id_pribor))
			{
				if (!$poverka->getResultQuery("SELECT * FROM `poverka` WHERE `id_pribor` = ".$id_pribor." ORDER BY `poverka`.`id` DESC"))
					echo $poverka->getConnError();
				$poverka->getPrintResult();
			}

		}
		else
		{
			$json['error'] = "Not valid.";
			echo 'Ошибка данных!';
		}

		?>
	</div>
	<br>
	<p class="text-center text-secondary">Copyright © ООО "ХИМКО" 2022-2023</p>

<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>