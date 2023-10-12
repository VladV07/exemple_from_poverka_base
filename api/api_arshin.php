<?php
	ini_set('max_execution_time', 600);
	ini_set('max_input_time', 600);

	echo 'max_execution_time = '.ini_get('max_execution_time').'<br>max_input_time = '.ini_get('max_input_time');
	set_time_limit(600);

	define("FILE_LOG", "log.txt");


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

	if (!$argc == 5)
		die('error argc');

	$mit_number = 	$argv[1];
	$row = 			$argv[2];
	$start =        $argv[3];
	$days = 		$argv[4];
	$try = 			0;

	echo "mit_number= ".$mit_number."\n";
	echo "row= ".$row."\n";
	echo "start= ".$start."\n";
	echo "days= ".$days."\n";

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

start:
	$getJsonData = file_get_contents('https://fgis.gost.ru/fundmetrology/eapi/vri?start='.$start.'&mit_number='.$mit_number.'&rows=100&verification_date_start='.date("Y-m-d", $date),false, $opts);
	$arr = json_decode($getJsonData, true, JSON_UNESCAPED_UNICODE);
	sleep(1);
	// print_r($arr);


	if ($getJsonData != false)
	{
		$arr = json_decode($getJsonData, true, JSON_UNESCAPED_UNICODE);
		// echo '<br> /////////////// if ($getJsonData != false) <br>';
		if ($arr['result']['count'] > 0)
		{
			$arr_res = array_merge($arr_res, $arr['result']['items']);
			$start = $arr['result']['start'];
			$count = $arr['result']['count'];
			// echo '<br> /////////////// if ($arr[result][count] > 0) <br>';
			if ($count > $row)
			{
				do
				{
					// echo '<br> ///////////////  if ($count > $row) do <br>';
					$start = $start + $row;
					// echo '<br> start= '.$start.'<br>';
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
						file_put_contents(FILE_LOG, "\nОшибка обращения к api :(\n", FILE_APPEND);
						die('Ошибка обращения к api :(');
					}
				} 
				while (($count - $start) > $row);
			}
		}
		else
		{
			file_put_contents(FILE_LOG, "\nКоличество записей в ответе 0.\n", FILE_APPEND);
			die('Количество записей в ответе 0.');	
		}
		// var_dump($json);
		// print_r($arr);
		// echo '<br> /////////////// <br>';
		print_r($arr['result']['items'][0]);
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
		file_put_contents(FILE_LOG, "\nОшибка обращения к api :(\n", FILE_APPEND);
		die('Ошибка обращения к api :(');
	}

	//  echo '<br> 1/////////////// <br>';
	// print_r($arr_res);

	echo "//   count = ".$count."\n";

	// echo '<br> 2/////////////// <br>';
	$api->setArrToAdd($arr_res);
	// echo '<br> 3/////////////// <br>';
	$api->addToSql();
	// echo '<br> /4////////////// <br>';
	echo $api->getConnError();
	echo "//   CountInsert = ".$api->getCountInsert()."\n";
	echo "//   CountUpdate = ".$api->getCountUpdate()."\n";
	echo "//   CountSum = ".($api->getCountUpdate() + $api->getCountInsert())."\n";

	$str_add = "\n".date("Y-m-d H:i:s")." Start:\n";
	$str_add.= "    mit_number = ".$mit_number."  row = ".$row." / start = ".$start." / days = ".$days."\n";
	$str_add.= "    try = ".$try."\n";
	$str_add.= "    Count = ".$count."\n";
	$str_add.= "    CountInsert = ".$api->getCountInsert()."\n";
	$str_add.= "    CountUpdate = ".$api->getCountUpdate()."\n";
	$str_add.= "    CountSum = ".($api->getCountUpdate() + $api->getCountInsert());
	$str_add.= "    ConnError = ".$api->getConnError()."\n";
	file_put_contents(FILE_LOG, $str_add, FILE_APPEND);

	if ($api->getConnError() == 'OK.' && $api->getCountUpdate() != $count)
	{

		$start = 0;
		$try++;
		$arr_res = array();
		$str_add = "";
		if ($try >= 5)
		{
			file_put_contents(FILE_LOG, "Попытка номер ".$try." пора передохнуть!\n", FILE_APPEND);
			die("Попытка номер ".$try." пора передохнуть!\n");
		}

		goto start;
	}



?>