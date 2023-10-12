<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	require_once("../Classes/ClassSQL.php");

	$json = array();
	date_default_timezone_set('Europe/Moscow');

	class ConnectSqlData
	{
		public $serv;
		public $login;
		public $pass;
		public $base_name;
	}

	$conn = new ConnectSqlData;

	$conn->serv = '####';
	$conn->login = '####';
	$conn->pass = '####';
	$conn->base_name = '####';

	function check_valid_token($id_pribor, $token, $conn)
	{
		$token_pribor = new SQL;
		$token_pribor->setConnect($conn->serv, $conn->login, $conn->pass, $conn->base_name);
		$token_pribor->getResultQueryArray("SELECT token FROM token_pribor WHERE id_pribor = ".$id_pribor);
		if ($token_pribor->getRowsArray()[0]['token'] == $token)
		{
			return true;
		}
		return false;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'GET')
	{
		$valid = false;

		$poverka = new SQL;
		$pribor = new SQL;
		$arshin = new SQL;

		$poverka->setConnect($conn->serv, $conn->login, $conn->pass, $conn->base_name);
		$pribor->setConnect($conn->serv, $conn->login, $conn->pass, $conn->base_name);
		$arshin->setConnect($conn->serv, $conn->login, $conn->pass, 'arshin');

		$token = $_GET['token'];

		$id_pribor = base64_decode($_GET['id']);

		if ($token && is_numeric($id_pribor))
		{
			$valid = check_valid_token($id_pribor, $token, $conn);
		}

		if ($valid)
		{
			if ($poverka->getResultQueryArray("SELECT pr.nb_pribor, tp.type, pr.date date_pribor, pr.reg_number, st.status, p.type_pr, p.type_sv, p.date_poverka  FROM poverka p 
			INNER JOIN status st ON st.id = p.id_status
			INNER JOIN pribor2 pr ON pr.id = p.id_pribor
			INNER JOIN type_pribor tp ON tp.id = pr.type_pribor_id 
			WHERE p.id_pribor = ".$id_pribor." ORDER BY p.id DESC LIMIT 1"))
			{
				if ($poverka->getRowsArray()[0] == null)
				{
					$pribor->getResultQueryArray("SELECT pr.nb_pribor, tp.type, pr.date date_pribor, pr.reg_number
					FROM pribor2 pr
					INNER JOIN type_pribor tp ON tp.id = pr.type_pribor_id 
					WHERE pr.id = ".$id_pribor." ORDER BY pr.id DESC LIMIT 1");
					$row = array();
					$row[0] = $pribor->getRowsArray()[0];
					$row[0]['status'] = null;
					$row[0]['type_pr'] = null;
					$row[0]['type_sv'] = null;
					$row[0]['date_poverka'] = null;
					$row[0]['arshin'] = false;
				}
				else
				{
					$row = $poverka->getRowsArray();
					$short_type_pribor = substr($row[0]['type'], 0, 8);
					$arshin->getResultQueryArray("SELECT * FROM `arshin_api` 
					WHERE `arshin_api`.`mi_number` = '".$row[0]['nb_pribor']."' 
					AND `arshin_api`.`mi_modification` LIKE '%".$short_type_pribor."%' 
					ORDER BY `arshin_api`.`verification_date` DESC LIMIT 1");
					$keys = array_keys($arshin->getRowsArray()[0]);
					for ($i = 0; $i < count($arshin->getRowsArray()[0]) ; $i++)
					{
						$row[0] += array($keys[$i] => $arshin->getRowsArray()[0][$keys[$i]]);
					}
					$row[0]['arshin'] = true;
				}
				$row[0]['error'] = null;
				$json = $row[0];
				
			}
			else
			{
				$json['error'] = $poverka->getConnError();
			}

		}
		else
		{
			$json['error'] = "Not valid.";
		}

	}
	else
	{
		$json['error'] = "Not valid.";
	}

	print(json_encode($json, JSON_UNESCAPED_UNICODE));
?>