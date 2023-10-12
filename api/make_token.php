<?php
ini_set('max_execution_time', 600);
ini_set('max_input_time', 600);

echo 'max_execution_time = '.ini_get('max_execution_time').'<br>max_input_time = '.ini_get('max_input_time');
set_time_limit(600);

$conn = mysqli_connect('####', '###', '###', '###');

if (!$conn)
{
	die('Нет соединения');
}

$res = mysqli_query($conn, "SELECT * FROM `pribor2`");

while ($rows[] =  mysqli_fetch_assoc($res));

$count_res = mysqli_num_rows($res);
echo "<br>count_res= ".$count_res."<br>";

$i = 1;
// var_dump($rows);
foreach ($rows as $row)
{
	// echo "SELECT * FROM `token_pribor` WHERE `id_pribor` = ".$row['id']."<br>";
	$res_token = mysqli_query($conn, "SELECT * FROM `token_pribor` WHERE `id_pribor` = ".$row['id']);
	$row_token = mysqli_fetch_assoc($res_token);
	// $res_token = mysqli_query($conn, "SELECT * FROM `token_pribor` WHERE `id_pribor` = 7");
	// var_dump($res_token);
	// echo $res_token."<br>";
	// echo "INSERT INTO `token_pribor` SET id_pribor=".$row['id'].", token=".md5((string)rand()."asdf435fjh")."<br>";

	if (empty($row_token))
	{
		echo "INSERT INTO `token_pribor` SET id_pribor=".$row['id'].", token='".md5((string)rand()."#####")."<br>";
		mysqli_query($conn, "INSERT INTO `token_pribor` SET id_pribor=".$row['id'].", token='".md5((string)rand()."####")."'");
	}
	$i++;
	echo $i."<br>";
}
echo "<br>Готово! i= ".($i-1)."<br>";
?>