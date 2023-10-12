<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	ini_set('max_execution_time', 600);
	ini_set('max_input_time', 600);

	echo 'max_execution_time = '.ini_get('max_execution_time').'<br>max_input_time = '.ini_get('max_input_time');
	set_time_limit(600);

	require_once "../Classes/ClassApiArshin.php";

	$api = new ApiArshin;

	//14531-13
	//14531-95
	//14531-97
	//14531-03
	//14531-08

	// $mit_number = '14531-13';
	// $row = 100;
	// $start = 0;
	// $days = 365;

	$mit_number = 	$_GET['mit_number'];
	$row = 			$_GET['row'];
	$start =        $_GET['start'];
	$days = 		$_GET['days'];

	if (is_numeric($days))
		$date = strtotime('-'.$days.' days');
	else
		die('Ошибка days :(');
	$arr_res = array();

	$opts = stream_context_create(array( 
	    'http' => array( 
	        'timeout' => 60 
	        ) 
	    ) 
	);

	$getJsonData = file_get_contents('https://fgis.gost.ru/fundmetrology/eapi/vri?start='.$start.'&mit_number='.$mit_number.'&rows=100&verification_date_start='.date("Y-m-d", $date),false, $opts);
	$arr = json_decode($getJsonData, true, JSON_UNESCAPED_UNICODE);
	sleep(1);
	print_r($arr);


	if ($getJsonData != false)
	{
		$arr = json_decode($getJsonData, true, JSON_UNESCAPED_UNICODE);
		echo '<br> /////////////// if ($getJsonData != false) <br>';
		if ($arr['result']['count'] > 0)
		{
			$arr_res = array_merge($arr_res, $arr['result']['items']);
			$start = $arr['result']['start'];
			$count = $arr['result']['count'];
			echo '<br> /////////////// if ($arr[result][count] > 0) <br>';
			if ($count > $row)
			{
				do
				{
					echo '<br> ///////////////  if ($count > $row) do <br>';
					$start = $start + $row;
					echo '<br> start= '.$start.'<br>';
					$getJsonData = file_get_contents('https://fgis.gost.ru/fundmetrology/eapi/vri?start='.$start.'&mit_number='.$mit_number.'&rows=100&verification_date_start='.date("Y-m-d", $date),false, $opts);
					sleep(1);
					if ($getJsonData != false)
					{
						$arr = json_decode($getJsonData, JSON_UNESCAPED_UNICODE);
						// print_r($arr_res);
						// echo '<br> /////////////// <br>';
						// print_r($arr['result']['items']);
						$arr_res = array_merge($arr_res, $arr['result']['items']);
						// echo '<br> /////////////// <br>';
						// print_r($arr_res);
					}
					else
					{
						die('Ошибка обращения к api :(');
					}
				} 
				while (($count - $start) > $row);
			}
		}
		else
		{
			die('Количество записей в ответе 0.');	
		}
		// var_dump($json);
		// print_r($arr);
		// echo '<br> /////////////// <br>';
		// print_r($arr['result']['items'][99]);
		// print_r($arr_res);
		// echo '<br> /////////////// <br>';
		// print_r($arr_res[430]);
		// echo '<br> /////////////// <br>';
		// print_r($arr_res[530]);
		// echo '<br> /////////////// <br>';
		// print_r($arr_res[532]);

	} //if ($getJsonData)
	else
	{
		die('Ошибка обращения к api :(');
	}

	//  echo '<br> 1/////////////// <br>';
	// print_r($arr_res);

	echo '<br> //   count = '.$count.'    // <br>';

	// echo '<br> 2/////////////// <br>';
	$api->setArrToAdd($arr_res);
	// echo '<br> 3/////////////// <br>';
	$api->addToSql();
	// echo '<br> /4////////////// <br>';
	echo $api->getConnError();

	echo '<br> //   CountUpdate = '.$api->getCountUpdate().'    // <br>';

	if ($api->getConnError() == 'OK.' && $api->getCountUpdate() != $count)
	{
		if (isset($_GET['try']))
			$try = $_GET['try'];
		else
			$try = 1;

		$start = 0;
		$try++;

		if ($try >= 5)
			die('Попытка номер '.$try.' пора передохнуть!');

		echo "<script>window.location.href='http://localhost/api/api_arshin_get.php?mit_number=".$mit_number."&row=".$row."&start=".$start."&days=".$days."&try=".$try."';</script>";
		exit();
	}
}
else
	echo 'ERROR.';



?>