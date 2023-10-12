<?php
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: image/png content-type;");
require_once ("../phpqrcode/qrlib.php");

// пример: http://localhost/api/get-qr-code.php?text=http://localhost/api/api.php?id_poverka=1&level=M&size=6px
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
	$text = $_GET['text']; 				// текст, который будет закодирован в изображении.
	// $outfile = __DIR__ . '/qr.png';		// куда сохранить файл, false – вывести в браузер.
	$outfile = false;
	$level = $_GET['level'];			// уровень коррекции ошибок L M Q H
	$size = $_GET['size']; 				// размер «пикселя», по умолчанию 3px
	$margin = 2;						// отступ от краев, задаётся в единицах, указанных в $size.
	$saveandprint = false;				// если true, то изображение одновременно сохранится в файле $outfile и выведется в браузер.

	//echo $text."<br>";
	//echo $level."<br>";
	//echo $size."<br>";

	QRcode::png($text, $outfile, $level, $size, $margin, $saveandprint);


	// imagepng($outfile);


}
?>