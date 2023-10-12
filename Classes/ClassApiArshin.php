<?php
try
{
	class ApiArshin
	{
		private $conn;
		private $query;
		private $count;
		private $result;
		private $rows;
		private $count_result;
		private $arr_to_add;
		private $count_0;
		private $count_1;

		public function setCount($count)
		{
			$this->count = $count;
		}

		public function setArrToAdd($arr_to_add)
		{
			$this->arr_to_add = $arr_to_add;
		}

		public function getConnect()
		{
			$this->conn = mysqli_connect('###', '###', '###', '###');
			if (!$this->conn)
				return false;
			else
				return true;
		}

		public function getResultQuery($query)
		{
			if ($this->getConnect())
			{
				$this->query = $query;
				$this->result = mysqli_query($this->conn, $this->query);
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

		public function getCountInsert()
		{
			if ($this->count_0)
				return $this->count_0;
			else
				return false;
		}

		public function getCountUpdate()
		{
			if ($this->count_1)
				return $this->count_1;
			else
				return false;
		}

		public function addToSql()
		{
			if (!isset($this->arr_to_add))
				return false;
			if ($this->getConnect())
			{
				$count_0 = 0;
				$count_1 = 0;
				foreach ($this->arr_to_add as $arr)
				{
					$query = "SELECT * FROM `arshin_api` WHERE `vri_id`='".$arr['vri_id']."'";
					if (!$this->getResultQueryArray($query))
						return false;
					
					if ($this->count_result == 0)
					{
						$arr['applicability'] == '' ? $applicability = 0 : $applicability = $arr['applicability'];
						empty($arr['valid_date']) ? $valid_date = 'NULL' : $valid_date = "STR_TO_DATE('{$arr['valid_date']}', '%d.%m.%Y')";
						
						$this->result = mysqli_query($this->conn,"INSERT INTO `arshin_api` SET 
						`vri_id` = '{$arr['vri_id']}', `org_title` = '{$arr['org_title']}',
						`mit_number` = '{$arr['mit_number']}', `mit_title` = '{$arr['mit_title']}',
						`mit_notation` = '{$arr['mit_notation']}', `mi_modification` = '{$arr['mi_modification']}',
						`mi_number` = '{$arr['mi_number']}', `verification_date` = STR_TO_DATE('{$arr['verification_date']}', '%d.%m.%Y'),
						`valid_date` = ".$valid_date.", `result_docnum` = '{$arr['result_docnum']}',
						`applicability` = '{$applicability}'");
						
						$count_0++;
					}
					elseif ($this->count_result > 0)
					{
						$arr['applicability'] == '' ? $applicability = 0 : $applicability = $arr['applicability'];
						empty($arr['valid_date']) ? $valid_date = 'NULL' : $valid_date = "STR_TO_DATE('{$arr['valid_date']}', '%d.%m.%Y')";
						$this->result = mysqli_query($this->conn,"UPDATE `arshin_api` SET 
						`org_title` = '{$arr['org_title']}',
						`mit_number` = '{$arr['mit_number']}', `mit_title` = '{$arr['mit_title']}',
						`mit_notation` = '{$arr['mit_notation']}', `mi_modification` = '{$arr['mi_modification']}',
						`mi_number` = '{$arr['mi_number']}', `verification_date` = STR_TO_DATE('{$arr['verification_date']}', '%d.%m.%Y'),
						`valid_date` = ".$valid_date.", `result_docnum` = '{$arr['result_docnum']}',
						`applicability` = '{$applicability}' WHERE `vri_id` = '{$arr['vri_id']}'");
						$count_1++;
					}
				}
				$this->count_0 = $count_0;
				$this->count_1 = $count_1;

			}
			else
			{
				return false;
			}
		
		}
	}
}
catch (Exception $e)
{
	echo $e->getMessage();
}
?>