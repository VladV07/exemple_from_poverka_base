<?php
// define('SERV_NAME', 'https://192.168.111.206');
define('SERV_NAME', 'http://localhost');

include_once '../TCPDF/tcpdf.php';
require_once '../conn.php';

function print_lable($pdf, $id_pribor, $conn)
{
	$row_pribor = mysqli_fetch_array(mysqli_query($conn, "SELECT pr.id, pr.nb_pribor, tp.type, tp.id type_id, pr.date, pr.reg_number 
	FROM pribor2 pr INNER JOIN type_pribor tp 
	WHERE pr.type_pribor_id = tp.id AND pr.id =".$id_pribor));

	$token = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM token_pribor 
	WHERE id_pribor = ".$id_pribor))['token'];

	$type_id = $row_pribor['type_id'];
	$id_pribor_base64 = base64_encode($id_pribor);
	$image_url = SERV_NAME.'/api/get-qr-code.php?text=https://info.ximko.ru/info?id='.$id_pribor_base64.'%26token='.$token.'&level=M&size=6px';

	$pdf->AddPage('L');
	$x = 0;
	$y = 0;

	$pdf->SetXY(0 + $x,0 + $y);
	$pdf->SetFontSize(8);

	$pdf->SetXY(17 + $x,2.5 + $y);
	$pdf->Cell(40,3,'ООО "ХИМКО"',0,0,'');

	$pdf->SetXY(17 + $x,6 + $y);
	$pdf->SetFontSize(8);
	$pdf->Cell(40,3,$row_pribor['type'],0,0,'');

	$pdf->SetXY(17 + $x,9.5 + $y);
	$pdf->SetFontSize(8);
	if ($type_id == 1 || $type_id == 2 || $type_id == 3 ||
		$type_id == 7 || $type_id == 8 || $type_id == 9 ||
		$type_id == 10 || $type_id == 11 || $type_id == 12)
			$pdf->Cell(15,3,'ẟ = ±5%',0,0,'');
	elseif ($type_id == 4 || $type_id == 5)
			$pdf->Cell(15,3,'ẟ = ±10%',0,0,'');

	if (!(empty($row_pribor['date']) || $row_pribor['date'] == "0001-01-01"))
	{
		$pdf->SetXY(17 + $x,14.25 + $y);
		$pdf->SetFontSize(8);
		$pdf->Cell(14,2,date("Y",strtotime($row_pribor['date'])).'г.',0,0,'С');
	}

	$pdf->SetXY(17 + $x,18 + $y);
	$pdf->SetFontSize(10);
	$pdf->Cell(14,3,'№ '.$row_pribor['nb_pribor'],0,0,'');

	$pdf->SetXY(17 + $x,22.55 + $y);
	$pdf->SetFontSize(5);
	if ($type_id == 2 || $type_id == 4 || $type_id == 8 ||
		$type_id == 9 || $type_id == 11 || $type_id == 16 ||
		$type_id == 16 )
			$pdf->Cell(30,1.5,'220В 50Гц',0,0,'');
	elseif ($type_id == 1 || $type_id == 3 || $type_id == 5 ||
		$type_id == 10 || $type_id == 12 || $type_id == 18)
			$pdf->Cell(30,1.5,'авт. ист. 12В',0,0,'');
	elseif ($type_id == 7)
			$pdf->Cell(30,1.5,'12В',0,0,'');

	$pdf->SetXY(17 + $x,25.25 + $y);
	$pdf->SetFontSize(5);
	if ($type_id == 1 || $type_id == 2 || $type_id == 3 ||
		$type_id == 7 || $type_id == 8 || $type_id == 9 ||
		$type_id == 10 || $type_id == 11 || $type_id == 12)
			$pdf->Cell(30,1.5,'ТУ 4215-000-11696625-2003',0,0,'');
	elseif ($type_id == 4 || $type_id == 5)
			$pdf->Cell(30,1.5,'ТУ 9443-004-11696625-00',0,0,'');

	$pdf->ImageSVG('../Chimko.svg', 2.5 + $x, 3 + $y, 13, 0, '', '', '', 0, false);
	$pdf->Image($image_url ,2 + $x,14 + $y,14,14);

	$pdf->ImageSVG('../rostest.svg', 48 + $x, 3 + $y, 8, 8, '', '', '', 0, false);
	$pdf->write2DBarcode('id='.$id_pribor, 'DATAMATRIX', 49.5 + $x, 15 + $y, 5, 5);
	$pdf->ImageSVG('../eac.svg', 49.5 + $x, 22 + $y, 5, 5, '', '', '', 0, false);

	return $pdf;
}

function print_lable_old($id_pribor, $conn)
{
	$pdf = new TCPDF('L', 'mm', array(58,30), true, 'UTF-8');
	$pdf->SetFont('dejavusans', 'b', 14, '', true);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetAuthor('ximko');
	$pdf->SetTitle('Label XIMKO');
	$pdf->SetAutoPageBreak(false);
	$pdf->SetMargins(0,0);

	print_lable($pdf, $id_pribor, $conn);

	$pdf->Output('output.pdf', 'I');
}

function check_doble_pribor($nb_pribor, $id_type_pribor, $conn)
{
	$result_proverka = mysqli_query($conn,"SELECT * FROM `pribor2` 
	WHERE `nb_pribor` = '$nb_pribor' AND `type_pribor_id` = '$id_type_pribor'");
	$row_proverka = mysqli_fetch_array($result_proverka);
	if (!empty($row_proverka))
		die('Ошибка! Такой прибор уже добавлен!');
}

function print_lable_new($lables_ct, $id_type_pribor, $conn)
{
	$last_nb = mysqli_fetch_array(mysqli_query($conn, "SELECT *
	FROM last_nb_pribor 
	WHERE id_type_pribor =".$id_type_pribor." OR id_type_pribor_isp1 =".$id_type_pribor))['last_nb'];

	$pdf = new TCPDF('L', 'mm', array(58,30), true, 'UTF-8');
	$pdf->SetFont('dejavusans', 'b', 14, '', true);
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetAuthor('ximko');
	$pdf->SetTitle('Label XIMKO');
	$pdf->SetAutoPageBreak(false);
	$pdf->SetMargins(0,0);

	for ($i = 0; $i < $lables_ct; $i++)
	{
		$last_nb++;

		check_doble_pribor($last_nb, $id_type_pribor, $conn);

		$date_now = date('Y-m-d');
		$reg_number = "14531-13";

		mysqli_query($conn, "INSERT INTO pribor2 
		SET type_pribor_id=".$id_type_pribor.", nb_pribor=".$last_nb.", 
		date='".$date_now."', reg_number='".$reg_number."' ");

		$lastInsertId = mysqli_insert_id($conn);

		mysqli_query($conn,"INSERT INTO `token_pribor` 
		SET id_pribor=".$lastInsertId.", token='".md5((string)rand()."asdf435fjh")."'");

		mysqli_query($conn, "UPDATE last_nb_pribor 
		SET last_nb=".$last_nb."
		WHERE id_type_pribor =".$id_type_pribor." OR id_type_pribor_isp1 =".$id_type_pribor);
	
		print_lable($pdf, $lastInsertId, $conn);
	}

	$pdf->Output('output.pdf', 'I');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$pribor = $_GET['pribor'];
	$pass = "JdfuYEcsdvbwi24hfjehv5g2Ndvrdvh";
	// $get_pass = base64_decode($_GET['pass']);
	// $get_pass = $_GET['pass'];
	$get_pass = $_POST['pass'];
	if ($get_pass !== $pass)
		die('Ошибка валидации!');

	if ($pribor === 'old')
	{
		$id_pribor = $_GET['id_pribor'];

		if (empty($id_pribor) || !is_numeric($id_pribor))
			die('Ошибка!');

		print_lable_old($id_pribor, $conn);
	}
	elseif ($pribor === 'new')
	{
		$lables_ct = $_GET['lables_ct'];
		$id_type_pribor = $_GET['id_type_pribor'];

		if (empty($lables_ct) || empty($id_type_pribor) || 
			!is_numeric($lables_ct) || !is_numeric($id_type_pribor))
			die('Ошибка!');
		if (!($id_type_pribor == 1 || $id_type_pribor == 2 || $id_type_pribor == 3 ||
			$id_type_pribor == 4 || $id_type_pribor == 5 || $id_type_pribor == 9 ||
			$id_type_pribor == 10 || $id_type_pribor == 11 || $id_type_pribor == 12))
				die('Ошибка!');
		if ($lables_ct > 30)
			die('Слишком большое количество этикеток за раз!');

		print_lable_new($lables_ct, $id_type_pribor, $conn);
	}
	else
		die('Ошибка!');

}

?>