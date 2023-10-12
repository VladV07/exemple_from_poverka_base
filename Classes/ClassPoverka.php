<?php
try
{
	class Poverka {
		private $conn;
		private $result;
		private $rows;
		private $count_result;
		private $query;

		public function getConnect()
		{
			$this->conn = mysqli_connect('###', '###', '###', '###');
			if (!$this->conn)
				return false;
			else
				return true;
		}

		public function getCountRows()
		{
			if ($this->count_result)
				return $this->count_result;
			else
				return false;
		}

		public function getResultQuery($query)
		{
			if ($this->getConnect())
			{
				$this->query = $query;
				$this->result = mysqli_query($this->conn, $query);
				if (!$this->result)
					return false;
				$this->count_result = mysqli_num_rows($this->result);
				return $this->result;
			}
			else
			{
				return false;
			}
		}

		public function getResultQueryArray($query)
		{
			if ($this->getConnect())
			{
				$this->query = $query;
				$this->result = array();
				$this->rows = array();
				$this->result = mysqli_query($this->conn, $query);
				if (!$this->result)
					return false;
				$this->count_result = mysqli_num_rows($this->result);
				while ($this->rows[] =  mysqli_fetch_assoc($this->result));
				return $this->rows;
			}
			else
			{
				return false;
			}
		}

		public function getRowsArray()
		{
			if ($this->rows)
				return $this->rows;
			else
				return false;
		}

		public function getConn()
		{
			if ($this->conn)
				return $this->conn;
			else
				return false;
		}

		public function getConnError()
		{
			if ($this->conn)
			{
				if ($this->conn->error)
					return $this->conn->error;
				else
					return "OK.";
			}
		}

		public function getPrintResult()
		{
			if ($this->result)
			{
				$result = $this->result;
				$query = $this->query;
				$start_session = false;
				require_once($_SERVER['DOCUMENT_ROOT'].'/poverka/page_output.php');
				return true;
			}
			else
				return false;
		}

		public function getQuery()
		{
			if (isset($this->query))
				return $this->query;
			else
				return false;
		}

	}

}
catch (Exception $e)
{
	echo $e->getMessage();
}


// подключение класса
// require_once("./Classes/ClassPoverka.php");

// задаем объект класса
// $poverka = new Poverka;

// получение сразу массива $poverka->getRowsArray() с результатами запроса
/*
	if (!$poverka->getResultQueryArray("SELECT * FROM `poverka` ORDER BY `poverka`.`id` DESC LIMIT 1"))
		echo $poverka->getConnError();
	var_dump($poverka->getRowsArray());
*/

// пройтись в цикле по результатам выдачи запроса
/*
	if (!$poverka->getResultQueryArray("SELECT * FROM `poverka` ORDER BY `poverka`.`id` DESC LIMIT 1"))
		echo $poverka->getConnError();
	foreach ($poverka->getRowsArray() as $row)
	{
		var_dump($row);
	}
*/

// напечатать результаты запроса
/*
	if (!$poverka->getResultQuery("SELECT * FROM `poverka` WHERE `date_naladka` IS NOT NULL ORDER BY `poverka`.`id` DESC"))
		echo $poverka->getConnError();
	$poverka->getPrintResult();
*/


?>