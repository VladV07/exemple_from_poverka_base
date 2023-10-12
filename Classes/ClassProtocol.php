<?php
try
{
	class Protocol {
		protected $conn = NULL;
		protected $result = NULL;
		protected $rows = NULL;
		protected $count_result = NULL;
		protected $query = NULL;

		public function getConnect()
		{
			if (!$this->conn)
				$this->conn = mysqli_connect('###', '###', '###', '###');
			if (!$this->conn)
				return false;
			else
				return true;
		}

		public function getResult()
		{
			if ($this->result)
				return $this->result;
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
			
		}

		public function getCountRows()
		{
			return $this->count_result;
		}

		public function setQuery($query)
		{
			$this->query = $query;
		}

	}

	class ProtocolPu1b extends Protocol {

		public function getResultQueryDefaltArray()
		{
			$this->query = "SELECT * FROM `pu1b`";
			if ($this->getConnect())
			{
				$this->result = mysqli_query($this->conn, $this->query);
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

		public function setData($json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"INSERT INTO `pu1b` SET `nb_protocol` = '{$to_set['nb_protocol']}', `date` = '{$to_set['date']}', 
				`date_poverka` = ".($to_set['date_poverka']==NULL ? "NULL" : "'{$to_set['date_poverka']}").", `type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `id_poverka` = '{$to_set['id_poverka']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`1_channel` = '{$to_set['1_channel']}',  `1_inst_expend` = '{$to_set['1_inst_expend']}',  `1_expend` = '{$to_set['1_expend']}',  `1_vol` = '{$to_set['1_vol']}',  `1_err_vol` = '{$to_set['1_err_vol']}',  
				`2_channel` = '{$to_set['2_channel']}',  `2_inst_expend` = '{$to_set['2_inst_expend']}',  `2_expend` = '{$to_set['2_expend']}',  `2_vol` = '{$to_set['2_vol']}',  `2_err_vol` = '{$to_set['2_err_vol']}',  
				`3_channel` = '{$to_set['3_channel']}',  `3_inst_expend` = '{$to_set['3_inst_expend']}',  `3_expend` = '{$to_set['3_expend']}',  `3_vol` = '{$to_set['3_vol']}',  `3_err_vol` = '{$to_set['3_err_vol']}',  
				`4_channel` = '{$to_set['4_channel']}',  `4_inst_expend` = '{$to_set['4_inst_expend']}',  `4_expend` = '{$to_set['4_expend']}',  `4_vol` = '{$to_set['4_vol']}',  `4_err_vol` = '{$to_set['4_err_vol']}',  
				`5_channel` = '{$to_set['5_channel']}',  `5_inst_expend` = '{$to_set['5_inst_expend']}',  `5_expend` = '{$to_set['5_expend']}',  `5_vol` = '{$to_set['5_vol']}',  `5_err_vol` = '{$to_set['5_err_vol']}' 
				;");
				if ($this->result)
				{
					$nb_protocol_hash = hash("crc32", (string)$this->conn->insert_id."pu1b", false);
					$this->result = mysqli_query($this->conn, "UPDATE `pu1b` SET `nb_protocol` = '$nb_protocol_hash' WHERE `id` = ".$this->conn->insert_id);
					if ($this->result)
						return true;
					else
						return false;
				}
				else
					return false;
			}
		}

		public function setUpdate($id, $json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"UPDATE `pu1b` SET  `date` = '{$to_set['date']}', 
				`type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`1_channel` = '{$to_set['1_channel']}',  `1_inst_expend` = '{$to_set['1_inst_expend']}',  `1_expend` = '{$to_set['1_expend']}',  `1_vol` = '{$to_set['1_vol']}',  `1_err_vol` = '{$to_set['1_err_vol']}',  
				`2_channel` = '{$to_set['2_channel']}',  `2_inst_expend` = '{$to_set['2_inst_expend']}',  `2_expend` = '{$to_set['2_expend']}',  `2_vol` = '{$to_set['2_vol']}',  `2_err_vol` = '{$to_set['2_err_vol']}',  
				`3_channel` = '{$to_set['3_channel']}',  `3_inst_expend` = '{$to_set['3_inst_expend']}',  `3_expend` = '{$to_set['3_expend']}',  `3_vol` = '{$to_set['3_vol']}',  `3_err_vol` = '{$to_set['3_err_vol']}',  
				`4_channel` = '{$to_set['4_channel']}',  `4_inst_expend` = '{$to_set['4_inst_expend']}',  `4_expend` = '{$to_set['4_expend']}',  `4_vol` = '{$to_set['4_vol']}',  `4_err_vol` = '{$to_set['4_err_vol']}',  
				`5_channel` = '{$to_set['5_channel']}',  `5_inst_expend` = '{$to_set['5_inst_expend']}',  `5_expend` = '{$to_set['5_expend']}',  `5_vol` = '{$to_set['5_vol']}',  `5_err_vol` = '{$to_set['5_err_vol']}' 
				WHERE `id` = {$id} ;");
				if ($this->result)
					return true;
				else
					return false;
			}
		}

		public function setOpenerDefaltForm()
		{
			echo "<script>window.opener.document.getElementById('search_pu1b').placeholder = '';</script>";
	
			echo "<script>window.opener.document.getElementById('input-1-1_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-1-2_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('td-1-5_pu1b').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('input-2-1_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-2-2_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('td-2-5_pu1b').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('input-3-1_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-3-2_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('td-3-5_pu1b').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('input-4-1_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-4-2_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('td-4-5_pu1b').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('input-5-1_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-5-2_pu1b').value = '';</script>";
			echo "<script>window.opener.document.getElementById('td-5-5_pu1b').innerHTML = '#';</script>";
		}

		public function setDefaltForm()
		{
	
			echo "<script>document.getElementById('input-1-1_pu1b').value = '';</script>";
			echo "<script>document.getElementById('input-1-2_pu1b').value = '';</script>";
			echo "<script>document.getElementById('td-1-5_pu1b').innerHTML = '#';</script>";
			echo "<script>document.getElementById('input-2-1_pu1b').value = '';</script>";
			echo "<script>document.getElementById('input-2-2_pu1b').value = '';</script>";
			echo "<script>document.getElementById('td-2-5_pu1b').innerHTML = '#';</script>";
			echo "<script>document.getElementById('input-3-1_pu1b').value = '';</script>";
			echo "<script>document.getElementById('input-3-2_pu1b').value = '';</script>";
			echo "<script>document.getElementById('td-3-5_pu1b').innerHTML = '#';</script>";
			echo "<script>document.getElementById('input-4-1_pu1b').value = '';</script>";
			echo "<script>document.getElementById('input-4-2_pu1b').value = '';</script>";
			echo "<script>document.getElementById('td-4-5_pu1b').innerHTML = '#';</script>";
			echo "<script>document.getElementById('input-5-1_pu1b').value = '';</script>";
			echo "<script>document.getElementById('input-5-2_pu1b').value = '';</script>";
			echo "<script>document.getElementById('td-5-5_pu1b').innerHTML = '#';</script>";
		}

	}

	class ProtocolPu4e extends Protocol {

		public function getResultQueryDefaltArray()
		{
			$this->query = "SELECT * FROM `pu4e`";
			if ($this->getConnect())
			{
				$this->result = mysqli_query($this->conn, $this->query);
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

		public function setData($json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"INSERT INTO `pu4e` SET `nb_protocol` = '{$to_set['nb_protocol']}', `date` = '{$to_set['date']}', 
				`date_poverka` = ".($to_set['date_poverka']==NULL ? "NULL" : "'{$to_set['date_poverka']}").", `type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `id_poverka` = '{$to_set['id_poverka']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`ch1_1_scale_expend` = '{$to_set['ch1_1_scale_expend']}',  `ch1_1_expend` = '{$to_set['ch1_1_expend']}',  `ch1_1_err` = '{$to_set['ch1_1_err']}', 
				`ch1_2_scale_expend` = '{$to_set['ch1_2_scale_expend']}',  `ch1_2_expend` = '{$to_set['ch1_2_expend']}',  `ch1_2_err` = '{$to_set['ch1_2_err']}', 
				`ch1_3_scale_expend` = '{$to_set['ch1_3_scale_expend']}',  `ch1_3_expend` = '{$to_set['ch1_3_expend']}',  `ch1_3_err` = '{$to_set['ch1_3_err']}', 
				`ch1_4_scale_expend` = '{$to_set['ch1_4_scale_expend']}',  `ch1_4_expend` = '{$to_set['ch1_4_expend']}',  `ch1_4_err` = '{$to_set['ch1_4_err']}', 
				`ch1_5_scale_expend` = '{$to_set['ch1_5_scale_expend']}',  `ch1_5_expend` = '{$to_set['ch1_5_expend']}',  `ch1_5_err` = '{$to_set['ch1_5_err']}', 
				`ch2_1_scale_expend` = '{$to_set['ch2_1_scale_expend']}',  `ch2_1_expend` = '{$to_set['ch2_1_expend']}',  `ch2_1_err` = '{$to_set['ch2_1_err']}', 
				`ch2_2_scale_expend` = '{$to_set['ch2_2_scale_expend']}',  `ch2_2_expend` = '{$to_set['ch2_2_expend']}',  `ch2_2_err` = '{$to_set['ch2_2_err']}', 
				`ch2_3_scale_expend` = '{$to_set['ch2_3_scale_expend']}',  `ch2_3_expend` = '{$to_set['ch2_3_expend']}',  `ch2_3_err` = '{$to_set['ch2_3_err']}', 
				`ch2_4_scale_expend` = '{$to_set['ch2_4_scale_expend']}',  `ch2_4_expend` = '{$to_set['ch2_4_expend']}',  `ch2_4_err` = '{$to_set['ch2_4_err']}', 
				`ch2_5_scale_expend` = '{$to_set['ch2_5_scale_expend']}',  `ch2_5_expend` = '{$to_set['ch2_5_expend']}',  `ch2_5_err` = '{$to_set['ch2_5_err']}', 
				`ch3_1_scale_expend` = '{$to_set['ch3_1_scale_expend']}',  `ch3_1_expend` = '{$to_set['ch3_1_expend']}',  `ch3_1_err` = '{$to_set['ch3_1_err']}', 
				`ch3_2_scale_expend` = '{$to_set['ch3_2_scale_expend']}',  `ch3_2_expend` = '{$to_set['ch3_2_expend']}',  `ch3_2_err` = '{$to_set['ch3_2_err']}', 
				`ch3_3_scale_expend` = '{$to_set['ch3_3_scale_expend']}',  `ch3_3_expend` = '{$to_set['ch3_3_expend']}',  `ch3_3_err` = '{$to_set['ch3_3_err']}', 
				`ch3_4_scale_expend` = '{$to_set['ch3_4_scale_expend']}',  `ch3_4_expend` = '{$to_set['ch3_4_expend']}',  `ch3_4_err` = '{$to_set['ch3_4_err']}', 
				`ch3_5_scale_expend` = '{$to_set['ch3_5_scale_expend']}',  `ch3_5_expend` = '{$to_set['ch3_5_expend']}',  `ch3_5_err` = '{$to_set['ch3_5_err']}', 
				`ch4_1_scale_expend` = '{$to_set['ch4_1_scale_expend']}',  `ch4_1_expend` = '{$to_set['ch4_1_expend']}',  `ch4_1_err` = '{$to_set['ch4_1_err']}', 
				`ch4_2_scale_expend` = '{$to_set['ch4_2_scale_expend']}',  `ch4_2_expend` = '{$to_set['ch4_2_expend']}',  `ch4_2_err` = '{$to_set['ch4_2_err']}', 
				`ch4_3_scale_expend` = '{$to_set['ch4_3_scale_expend']}',  `ch4_3_expend` = '{$to_set['ch4_3_expend']}',  `ch4_3_err` = '{$to_set['ch4_3_err']}', 
				`ch4_4_scale_expend` = '{$to_set['ch4_4_scale_expend']}',  `ch4_4_expend` = '{$to_set['ch4_4_expend']}',  `ch4_4_err` = '{$to_set['ch4_4_err']}', 
				`ch4_5_scale_expend` = '{$to_set['ch4_5_scale_expend']}',  `ch4_5_expend` = '{$to_set['ch4_5_expend']}',  `ch4_5_err` = '{$to_set['ch4_5_err']}', 
				`1_t_inst` = '{$to_set['1_t_inst']}',  `1_t` = '{$to_set['1_t']}',  `1_err_t` = '{$to_set['1_err_t']}', 
				`2_t_inst` = '{$to_set['2_t_inst']}',  `2_t` = '{$to_set['2_t']}',  `2_err_t` = '{$to_set['2_err_t']}', 
				`3_t_inst` = '{$to_set['3_t_inst']}',  `3_t` = '{$to_set['3_t']}',  `3_err_t` = '{$to_set['3_err_t']}'
				;");
				if ($this->result)
				{
					$nb_protocol_hash = hash("crc32", (string)$this->conn->insert_id."pu4e", false);
					$this->result = mysqli_query($this->conn, "UPDATE `pu4e` SET `nb_protocol` = '$nb_protocol_hash' WHERE `id` = ".$this->conn->insert_id);
					if ($this->result)
						return true;
					else
						return false;
				}
				else
					return false;
			}
		}

		public function setUpdate($id, $json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);	
				$this->result = mysqli_query($this->conn,"UPDATE `pu4e` SET  `date` = '{$to_set['date']}', 
				`type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`ch1_1_scale_expend` = '{$to_set['ch1_1_scale_expend']}',  `ch1_1_expend` = '{$to_set['ch1_1_expend']}',  `ch1_1_err` = '{$to_set['ch1_1_err']}', 
				`ch1_2_scale_expend` = '{$to_set['ch1_2_scale_expend']}',  `ch1_2_expend` = '{$to_set['ch1_2_expend']}',  `ch1_2_err` = '{$to_set['ch1_2_err']}', 
				`ch1_3_scale_expend` = '{$to_set['ch1_3_scale_expend']}',  `ch1_3_expend` = '{$to_set['ch1_3_expend']}',  `ch1_3_err` = '{$to_set['ch1_3_err']}', 
				`ch1_4_scale_expend` = '{$to_set['ch1_4_scale_expend']}',  `ch1_4_expend` = '{$to_set['ch1_4_expend']}',  `ch1_4_err` = '{$to_set['ch1_4_err']}', 
				`ch1_5_scale_expend` = '{$to_set['ch1_5_scale_expend']}',  `ch1_5_expend` = '{$to_set['ch1_5_expend']}',  `ch1_5_err` = '{$to_set['ch1_5_err']}', 
				`ch2_1_scale_expend` = '{$to_set['ch2_1_scale_expend']}',  `ch2_1_expend` = '{$to_set['ch2_1_expend']}',  `ch2_1_err` = '{$to_set['ch2_1_err']}', 
				`ch2_2_scale_expend` = '{$to_set['ch2_2_scale_expend']}',  `ch2_2_expend` = '{$to_set['ch2_2_expend']}',  `ch2_2_err` = '{$to_set['ch2_2_err']}', 
				`ch2_3_scale_expend` = '{$to_set['ch2_3_scale_expend']}',  `ch2_3_expend` = '{$to_set['ch2_3_expend']}',  `ch2_3_err` = '{$to_set['ch2_3_err']}', 
				`ch2_4_scale_expend` = '{$to_set['ch2_4_scale_expend']}',  `ch2_4_expend` = '{$to_set['ch2_4_expend']}',  `ch2_4_err` = '{$to_set['ch2_4_err']}', 
				`ch2_5_scale_expend` = '{$to_set['ch2_5_scale_expend']}',  `ch2_5_expend` = '{$to_set['ch2_5_expend']}',  `ch2_5_err` = '{$to_set['ch2_5_err']}', 
				`ch3_1_scale_expend` = '{$to_set['ch3_1_scale_expend']}',  `ch3_1_expend` = '{$to_set['ch3_1_expend']}',  `ch3_1_err` = '{$to_set['ch3_1_err']}', 
				`ch3_2_scale_expend` = '{$to_set['ch3_2_scale_expend']}',  `ch3_2_expend` = '{$to_set['ch3_2_expend']}',  `ch3_2_err` = '{$to_set['ch3_2_err']}', 
				`ch3_3_scale_expend` = '{$to_set['ch3_3_scale_expend']}',  `ch3_3_expend` = '{$to_set['ch3_3_expend']}',  `ch3_3_err` = '{$to_set['ch3_3_err']}', 
				`ch3_4_scale_expend` = '{$to_set['ch3_4_scale_expend']}',  `ch3_4_expend` = '{$to_set['ch3_4_expend']}',  `ch3_4_err` = '{$to_set['ch3_4_err']}', 
				`ch3_5_scale_expend` = '{$to_set['ch3_5_scale_expend']}',  `ch3_5_expend` = '{$to_set['ch3_5_expend']}',  `ch3_5_err` = '{$to_set['ch3_5_err']}', 
				`ch4_1_scale_expend` = '{$to_set['ch4_1_scale_expend']}',  `ch4_1_expend` = '{$to_set['ch4_1_expend']}',  `ch4_1_err` = '{$to_set['ch4_1_err']}', 
				`ch4_2_scale_expend` = '{$to_set['ch4_2_scale_expend']}',  `ch4_2_expend` = '{$to_set['ch4_2_expend']}',  `ch4_2_err` = '{$to_set['ch4_2_err']}', 
				`ch4_3_scale_expend` = '{$to_set['ch4_3_scale_expend']}',  `ch4_3_expend` = '{$to_set['ch4_3_expend']}',  `ch4_3_err` = '{$to_set['ch4_3_err']}', 
				`ch4_4_scale_expend` = '{$to_set['ch4_4_scale_expend']}',  `ch4_4_expend` = '{$to_set['ch4_4_expend']}',  `ch4_4_err` = '{$to_set['ch4_4_err']}', 
				`ch4_5_scale_expend` = '{$to_set['ch4_5_scale_expend']}',  `ch4_5_expend` = '{$to_set['ch4_5_expend']}',  `ch4_5_err` = '{$to_set['ch4_5_err']}', 
				`1_t_inst` = '{$to_set['1_t_inst']}',  `1_t` = '{$to_set['1_t']}',  `1_err_t` = '{$to_set['1_err_t']}', 
				`2_t_inst` = '{$to_set['2_t_inst']}',  `2_t` = '{$to_set['2_t']}',  `2_err_t` = '{$to_set['2_err_t']}', 
				`3_t_inst` = '{$to_set['3_t_inst']}',  `3_t` = '{$to_set['3_t']}',  `3_err_t` = '{$to_set['3_err_t']}'
				WHERE `id` = {$id} ;");
				if ($this->result)
					return true;
				else
					return false;
			}
		}

		public function setOpenerDefaltForm()
		{
			echo "<script>window.opener.document.getElementById('search_pu4e').placeholder = '';</script>";
	
			echo "<script>window.opener.document.getElementById('ch1_1_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_1_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_1_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch3_1_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_1_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_1_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch4_1_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_1_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_1_err_pu4e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_2_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch3_2_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_2_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_2_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch4_2_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_2_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_2_err_pu4e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_3_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch3_3_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_3_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_3_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch4_3_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_3_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_3_err_pu4e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_4_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch3_4_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_4_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_4_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch4_4_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_4_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_4_err_pu4e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_5_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch3_5_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_5_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch3_5_err_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch4_5_scale_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_5_expend_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch4_5_err_pu4e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('1_t_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('1_err_t_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('2_t_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('2_err_t_pu4e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('3_t_pu4e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('3_err_t_pu4e').innerHTML = '#';</script>";

		}

		public function setDefaltForm()
		{
	
			echo "<script>document.getElementById('ch1_1_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_1_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_1_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_1_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_1_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_1_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch3_1_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_1_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_1_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch4_1_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_1_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_1_err_pu4e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_2_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_2_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_2_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_2_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_2_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_2_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch3_2_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_2_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_2_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch4_2_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_2_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_2_err_pu4e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_3_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_3_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_3_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_3_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_3_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_3_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch3_3_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_3_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_3_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch4_3_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_3_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_3_err_pu4e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_4_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_4_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_4_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_4_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_4_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_4_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch3_4_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_4_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_4_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch4_4_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_4_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_4_err_pu4e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_5_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_5_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch1_5_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_5_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_5_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch2_5_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch3_5_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_5_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch3_5_err_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch4_5_scale_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_5_expend_pu4e').value = '';</script>";
			echo "<script>document.getElementById('ch4_5_err_pu4e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('1_t_pu4e').value = '';</script>";
			echo "<script>document.getElementById('1_err_t_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('2_t_pu4e').value = '';</script>";
			echo "<script>document.getElementById('2_err_t_pu4e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('3_t_pu4e').value = '';</script>";
			echo "<script>document.getElementById('3_err_t_pu4e').innerHTML = '#';</script>";
		}

	}

	class ProtocolPu3_220 extends Protocol {

		public function getResultQueryDefaltArray()
		{
			$this->query = "SELECT * FROM `pu3_220`";
			if ($this->getConnect())
			{
				$this->result = mysqli_query($this->conn, $this->query);
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

		public function setData($json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"INSERT INTO `pu3_220` SET `nb_protocol` = '{$to_set['nb_protocol']}', `date`='{$to_set['date']}',
				`date_poverka` = ".($to_set['date_poverka']==NULL ? "NULL" : "'{$to_set['date_poverka']}").",`type_ci`='{$to_set['type_ci']}',`modif_ci`='{$to_set['modif_ci']}',
				`reg_nbr`='{$to_set['reg_nbr']}',`metrolog_charcter`='{$to_set['metrolog_charcter']}',`id_poverka`='{$to_set['id_poverka']}',`doc_pov`='{$to_set['doc_pov']}',
				`temp`='{$to_set['temp']}',`wet`='{$to_set['wet']}',`atmos_press`='{$to_set['atmos_press']}',`standards`='{$to_set['standards']}',
				`1_PZU_vol`='{$to_set['1_PZU_vol']}',`1_RGS_vol`='{$to_set['1_RGS_vol']}',
				`2_PZU_vol`='{$to_set['2_PZU_vol']}',`2_RGS_vol`='{$to_set['2_RGS_vol']}',
				`3_PZU_vol`='{$to_set['3_PZU_vol']}',`3_RGS_vol`='{$to_set['3_RGS_vol']}',
				`1_t`='{$to_set['1_t']}',`Q_max`='{$to_set['Q_max']}',
				`k1`='{$to_set['k1']}',`k2`='{$to_set['k2']}',
				`4_PZU_vol`='{$to_set['4_PZU_vol']}',`4_RGS_vol`='{$to_set['4_RGS_vol']}',
				`5_PZU_vol`='{$to_set['5_PZU_vol']}',`5_RGS_vol`='{$to_set['5_RGS_vol']}',
				`6_PZU_vol`='{$to_set['6_PZU_vol']}',`6_RGS_vol`='{$to_set['6_RGS_vol']}',
				`2_t`='{$to_set['2_t']}',`Q_min`='{$to_set['Q_min']}',
				`k3`='{$to_set['k3']}',`k4`='{$to_set['k4']}',
				`k_avareg`='{$to_set['k_avareg']}' 
				;");
				if ($this->result)
				{
					$nb_protocol_hash = hash("crc32", (string)$this->conn->insert_id."pu3_220", false);
					$this->result = mysqli_query($this->conn, "UPDATE `pu3_220` SET `nb_protocol` = '$nb_protocol_hash' WHERE `id` = ".$this->conn->insert_id);
					if ($this->result)
						return true;
					else
						return false;
				}
				else
					return false;
			}
		}

		public function setUpdate($id, $json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"UPDATE `pu3_220` SET `date`='{$to_set['date']}',
				`type_ci`='{$to_set['type_ci']}',`modif_ci`='{$to_set['modif_ci']}',`reg_nbr`='{$to_set['reg_nbr']}',
				`metrolog_charcter`='{$to_set['metrolog_charcter']}',`id_poverka`='{$to_set['id_poverka']}',`doc_pov`='{$to_set['doc_pov']}',
				`temp`='{$to_set['temp']}',`wet`='{$to_set['wet']}',`atmos_press`='{$to_set['atmos_press']}',`standards`='{$to_set['standards']}',
				`1_PZU_vol`='{$to_set['1_PZU_vol']}',`1_RGS_vol`='{$to_set['1_RGS_vol']}',
				`2_PZU_vol`='{$to_set['2_PZU_vol']}',`2_RGS_vol`='{$to_set['2_RGS_vol']}',
				`3_PZU_vol`='{$to_set['3_PZU_vol']}',`3_RGS_vol`='{$to_set['3_RGS_vol']}',
				`1_t`='{$to_set['1_t']}',`Q_max`='{$to_set['Q_max']}',
				`k1`='{$to_set['k1']}',`k2`='{$to_set['k2']}',
				`4_PZU_vol`='{$to_set['4_PZU_vol']}',`4_RGS_vol`='{$to_set['4_RGS_vol']}',
				`5_PZU_vol`='{$to_set['5_PZU_vol']}',`5_RGS_vol`='{$to_set['5_RGS_vol']}',
				`6_PZU_vol`='{$to_set['6_PZU_vol']}',`6_RGS_vol`='{$to_set['6_RGS_vol']}',
				`2_t`='{$to_set['2_t']}',`Q_min`='{$to_set['Q_min']}',
				`k3`='{$to_set['k3']}',`k4`='{$to_set['k4']}',
				`k_avareg`='{$to_set['k_avareg']}' 
				WHERE `id` = {$id} ;");
				if ($this->result)
					return true;
				else
					return false;
			}
		}

		public function setOpenerDefaltForm()
		{
			echo "<script>window.opener.document.getElementById('search_pu3_220').placeholder = '';</script>";
	
			echo "<script>window.opener.document.getElementById('input-1-1_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-1-2_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-2-1_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-2-2_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-3-1_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-3-2_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-4-1_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-8-1_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-8-2_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-9-1_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-9-2_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-10-1_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-10-2_pu3_220').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-11-1_pu3_220').value = '';</script>";
			
			echo "<script>window.opener.document.getElementById('th-5-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-6-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-7-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('th-12-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-13-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-14-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-15-1_pu3_220').innerHTML = '#';</script>";
		}

		public function setDefaltForm()
		{
	
			echo "<script>document.getElementById('input-1-1_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-1-2_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-2-1_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-2-2_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-3-1_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-3-2_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-4-1_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-8-1_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-8-2_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-9-1_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-9-2_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-10-1_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-10-2_pu3_220').value = '';</script>";
			echo "<script>document.getElementById('input-11-1_pu3_220').value = '';</script>";
			
			echo "<script>document.getElementById('th-5-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-6-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-7-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>document.getElementById('th-12-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-13-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-14-1_pu3_220').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-15-1_pu3_220').innerHTML = '#';</script>";
		}

	}

	class ProtocolPu3_12 extends Protocol {

		public function getResultQueryDefaltArray()
		{
			$this->query = "SELECT * FROM `pu3_12`";
			if ($this->getConnect())
			{
				$this->result = mysqli_query($this->conn, $this->query);
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

		public function setData($json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"INSERT INTO `pu3_12` SET `nb_protocol` = '{$to_set['nb_protocol']}', `date`='{$to_set['date']}',
				`date_poverka` = ".($to_set['date_poverka']==NULL ? "NULL" : "'{$to_set['date_poverka']}").",`type_ci`='{$to_set['type_ci']}',`modif_ci`='{$to_set['modif_ci']}',
				`reg_nbr`='{$to_set['reg_nbr']}',`metrolog_charcter`='{$to_set['metrolog_charcter']}',`id_poverka`='{$to_set['id_poverka']}',`doc_pov`='{$to_set['doc_pov']}',
				`temp`='{$to_set['temp']}',`wet`='{$to_set['wet']}',`atmos_press`='{$to_set['atmos_press']}',`standards`='{$to_set['standards']}',
				`1_PZU_vol`='{$to_set['1_PZU_vol']}',`1_RGS_vol`='{$to_set['1_RGS_vol']}',
				`2_PZU_vol`='{$to_set['2_PZU_vol']}',`2_RGS_vol`='{$to_set['2_RGS_vol']}',
				`3_PZU_vol`='{$to_set['3_PZU_vol']}',`3_RGS_vol`='{$to_set['3_RGS_vol']}',
				`1_t`='{$to_set['1_t']}',`Q_max`='{$to_set['Q_max']}',
				`k1`='{$to_set['k1']}',`k2`='{$to_set['k2']}',
				`4_PZU_vol`='{$to_set['4_PZU_vol']}',`4_RGS_vol`='{$to_set['4_RGS_vol']}',
				`5_PZU_vol`='{$to_set['5_PZU_vol']}',`5_RGS_vol`='{$to_set['5_RGS_vol']}',
				`6_PZU_vol`='{$to_set['6_PZU_vol']}',`6_RGS_vol`='{$to_set['6_RGS_vol']}',
				`2_t`='{$to_set['2_t']}',`Q_min`='{$to_set['Q_min']}',
				`k3`='{$to_set['k3']}',`k4`='{$to_set['k4']}',
				`k_avareg`='{$to_set['k_avareg']}' 
				;");
				if ($this->result)
				{
					// var_dump($this->conn->insert_id);
					$nb_protocol_hash = hash("crc32", (string)$this->conn->insert_id."pu3_12", false);
					$this->result = mysqli_query($this->conn, "UPDATE `pu3_12` SET `nb_protocol` = '$nb_protocol_hash' WHERE `id` = ".$this->conn->insert_id);
					if ($this->result)
						return true;
					else
						return false;
				}
				else
					return false;
			}
		}

		public function setUpdate($id, $json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"UPDATE `pu3_12` SET `date`='{$to_set['date']}',
				`type_ci`='{$to_set['type_ci']}',`modif_ci`='{$to_set['modif_ci']}',`reg_nbr`='{$to_set['reg_nbr']}',
				`metrolog_charcter`='{$to_set['metrolog_charcter']}',`id_poverka`='{$to_set['id_poverka']}',`doc_pov`='{$to_set['doc_pov']}',
				`temp`='{$to_set['temp']}',`wet`='{$to_set['wet']}',`atmos_press`='{$to_set['atmos_press']}',`standards`='{$to_set['standards']}',
				`1_PZU_vol`='{$to_set['1_PZU_vol']}',`1_RGS_vol`='{$to_set['1_RGS_vol']}',
				`2_PZU_vol`='{$to_set['2_PZU_vol']}',`2_RGS_vol`='{$to_set['2_RGS_vol']}',
				`3_PZU_vol`='{$to_set['3_PZU_vol']}',`3_RGS_vol`='{$to_set['3_RGS_vol']}',
				`1_t`='{$to_set['1_t']}',`Q_max`='{$to_set['Q_max']}',
				`k1`='{$to_set['k1']}',`k2`='{$to_set['k2']}',
				`4_PZU_vol`='{$to_set['4_PZU_vol']}',`4_RGS_vol`='{$to_set['4_RGS_vol']}',
				`5_PZU_vol`='{$to_set['5_PZU_vol']}',`5_RGS_vol`='{$to_set['5_RGS_vol']}',
				`6_PZU_vol`='{$to_set['6_PZU_vol']}',`6_RGS_vol`='{$to_set['6_RGS_vol']}',
				`2_t`='{$to_set['2_t']}',`Q_min`='{$to_set['Q_min']}',
				`k3`='{$to_set['k3']}',`k4`='{$to_set['k4']}',
				`k_avareg`='{$to_set['k_avareg']}' 
				WHERE `id` = {$id} ;");
				if ($this->result)
					return true;
				else
					return false;
			}
		}

		public function setOpenerDefaltForm()
		{
			echo "<script>window.opener.document.getElementById('search_pu3_12').placeholder = '';</script>";
	
			echo "<script>window.opener.document.getElementById('input-1-1_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-1-2_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-2-1_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-2-2_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-3-1_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-3-2_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-4-1_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-8-1_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-8-2_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-9-1_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-9-2_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-10-1_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-10-2_pu3_12').value = '';</script>";
			echo "<script>window.opener.document.getElementById('input-11-1_pu3_12').value = '';</script>";
			
			echo "<script>window.opener.document.getElementById('th-5-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-6-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-7-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('th-12-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-13-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-14-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('td-15-1_pu3_12').innerHTML = '#';</script>";
		}

		public function setDefaltForm()
		{
	
			echo "<script>document.getElementById('input-1-1_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-1-2_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-2-1_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-2-2_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-3-1_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-3-2_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-4-1_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-8-1_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-8-2_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-9-1_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-9-2_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-10-1_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-10-2_pu3_12').value = '';</script>";
			echo "<script>document.getElementById('input-11-1_pu3_12').value = '';</script>";
			
			echo "<script>document.getElementById('th-5-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-6-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-7-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>document.getElementById('th-12-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-13-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-14-1_pu3_12').innerHTML = '#';</script>";
			echo "<script>document.getElementById('td-15-1_pu3_12').innerHTML = '#';</script>";
		}

	}


	class ProtocolPu2e extends Protocol {

		public function getResultQueryDefaltArray()
		{
			$this->query = "SELECT * FROM `pu2e`";
			if ($this->getConnect())
			{
				$this->result = mysqli_query($this->conn, $this->query);
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

		public function setData($json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"INSERT INTO `pu2e` SET `nb_protocol` = '{$to_set['nb_protocol']}', `date` = '{$to_set['date']}', 
				`date_poverka` = ".($to_set['date_poverka']==NULL ? "NULL" : "'{$to_set['date_poverka']}").", `type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `id_poverka` = '{$to_set['id_poverka']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`ch1_1_scale_expend` = '{$to_set['ch1_1_scale_expend']}',  `ch1_1_expend` = '{$to_set['ch1_1_expend']}',  `ch1_1_err` = '{$to_set['ch1_1_err']}', 
				`ch1_2_scale_expend` = '{$to_set['ch1_2_scale_expend']}',  `ch1_2_expend` = '{$to_set['ch1_2_expend']}',  `ch1_2_err` = '{$to_set['ch1_2_err']}', 
				`ch1_3_scale_expend` = '{$to_set['ch1_3_scale_expend']}',  `ch1_3_expend` = '{$to_set['ch1_3_expend']}',  `ch1_3_err` = '{$to_set['ch1_3_err']}', 
				`ch1_4_scale_expend` = '{$to_set['ch1_4_scale_expend']}',  `ch1_4_expend` = '{$to_set['ch1_4_expend']}',  `ch1_4_err` = '{$to_set['ch1_4_err']}', 
				`ch1_5_scale_expend` = '{$to_set['ch1_5_scale_expend']}',  `ch1_5_expend` = '{$to_set['ch1_5_expend']}',  `ch1_5_err` = '{$to_set['ch1_5_err']}', 
				`ch2_1_scale_expend` = '{$to_set['ch2_1_scale_expend']}',  `ch2_1_expend` = '{$to_set['ch2_1_expend']}',  `ch2_1_err` = '{$to_set['ch2_1_err']}', 
				`ch2_2_scale_expend` = '{$to_set['ch2_2_scale_expend']}',  `ch2_2_expend` = '{$to_set['ch2_2_expend']}',  `ch2_2_err` = '{$to_set['ch2_2_err']}', 
				`ch2_3_scale_expend` = '{$to_set['ch2_3_scale_expend']}',  `ch2_3_expend` = '{$to_set['ch2_3_expend']}',  `ch2_3_err` = '{$to_set['ch2_3_err']}', 
				`ch2_4_scale_expend` = '{$to_set['ch2_4_scale_expend']}',  `ch2_4_expend` = '{$to_set['ch2_4_expend']}',  `ch2_4_err` = '{$to_set['ch2_4_err']}', 
				`ch2_5_scale_expend` = '{$to_set['ch2_5_scale_expend']}',  `ch2_5_expend` = '{$to_set['ch2_5_expend']}',  `ch2_5_err` = '{$to_set['ch2_5_err']}', 
				`1_t_inst` = '{$to_set['1_t_inst']}',  `1_t` = '{$to_set['1_t']}',  `1_err_t` = '{$to_set['1_err_t']}', 
				`2_t_inst` = '{$to_set['2_t_inst']}',  `2_t` = '{$to_set['2_t']}',  `2_err_t` = '{$to_set['2_err_t']}', 
				`3_t_inst` = '{$to_set['3_t_inst']}',  `3_t` = '{$to_set['3_t']}',  `3_err_t` = '{$to_set['3_err_t']}'
				;");
				if ($this->result)
				{
					// var_dump($this->conn->insert_id);
					$nb_protocol_hash = hash("crc32", (string)$this->conn->insert_id."pu2e", false);
					$this->result = mysqli_query($this->conn, "UPDATE `pu2e` SET `nb_protocol` = '$nb_protocol_hash' WHERE `id` = ".$this->conn->insert_id);
					if ($this->result)
						return true;
					else
						return false;
				}
				else
					return false;
			}
		}

		public function setUpdate($id, $json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"UPDATE `pu2e` SET  `date` = '{$to_set['date']}', 
				`type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`ch1_1_scale_expend` = '{$to_set['ch1_1_scale_expend']}',  `ch1_1_expend` = '{$to_set['ch1_1_expend']}',  `ch1_1_err` = '{$to_set['ch1_1_err']}', 
				`ch1_2_scale_expend` = '{$to_set['ch1_2_scale_expend']}',  `ch1_2_expend` = '{$to_set['ch1_2_expend']}',  `ch1_2_err` = '{$to_set['ch1_2_err']}', 
				`ch1_3_scale_expend` = '{$to_set['ch1_3_scale_expend']}',  `ch1_3_expend` = '{$to_set['ch1_3_expend']}',  `ch1_3_err` = '{$to_set['ch1_3_err']}', 
				`ch1_4_scale_expend` = '{$to_set['ch1_4_scale_expend']}',  `ch1_4_expend` = '{$to_set['ch1_4_expend']}',  `ch1_4_err` = '{$to_set['ch1_4_err']}', 
				`ch1_5_scale_expend` = '{$to_set['ch1_5_scale_expend']}',  `ch1_5_expend` = '{$to_set['ch1_5_expend']}',  `ch1_5_err` = '{$to_set['ch1_5_err']}', 
				`ch2_1_scale_expend` = '{$to_set['ch2_1_scale_expend']}',  `ch2_1_expend` = '{$to_set['ch2_1_expend']}',  `ch2_1_err` = '{$to_set['ch2_1_err']}', 
				`ch2_2_scale_expend` = '{$to_set['ch2_2_scale_expend']}',  `ch2_2_expend` = '{$to_set['ch2_2_expend']}',  `ch2_2_err` = '{$to_set['ch2_2_err']}', 
				`ch2_3_scale_expend` = '{$to_set['ch2_3_scale_expend']}',  `ch2_3_expend` = '{$to_set['ch2_3_expend']}',  `ch2_3_err` = '{$to_set['ch2_3_err']}', 
				`ch2_4_scale_expend` = '{$to_set['ch2_4_scale_expend']}',  `ch2_4_expend` = '{$to_set['ch2_4_expend']}',  `ch2_4_err` = '{$to_set['ch2_4_err']}', 
				`ch2_5_scale_expend` = '{$to_set['ch2_5_scale_expend']}',  `ch2_5_expend` = '{$to_set['ch2_5_expend']}',  `ch2_5_err` = '{$to_set['ch2_5_err']}', 
				`1_t_inst` = '{$to_set['1_t_inst']}',  `1_t` = '{$to_set['1_t']}',  `1_err_t` = '{$to_set['1_err_t']}', 
				`2_t_inst` = '{$to_set['2_t_inst']}',  `2_t` = '{$to_set['2_t']}',  `2_err_t` = '{$to_set['2_err_t']}', 
				`3_t_inst` = '{$to_set['3_t_inst']}',  `3_t` = '{$to_set['3_t']}',  `3_err_t` = '{$to_set['3_err_t']}'
				WHERE `id` = {$id} ;");
				if ($this->result)
					return true;
				else
					return false;
			}
		}

		public function setOpenerDefaltForm()
		{
			echo "<script>window.opener.document.getElementById('search_pu2e').placeholder = '';</script>";
	
			echo "<script>window.opener.document.getElementById('ch1_1_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_1_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_1_err_pu2e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_err_pu2e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_2_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_err_pu2e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_err_pu2e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_3_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_err_pu2e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_err_pu2e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_4_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_err_pu2e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_err_pu2e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_5_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_err_pu2e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_scale_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_expend_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_err_pu2e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('1_t_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('1_err_t_pu2e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('2_t_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('2_err_t_pu2e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('3_t_pu2e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('3_err_t_pu2e').innerHTML = '#';</script>";

		}

		public function setDefaltForm()
		{
	
			echo "<script>document.getElementById('ch1_1_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_1_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_1_err_pu2e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_1_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_1_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_1_err_pu2e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_2_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_2_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_2_err_pu2e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_2_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_2_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_2_err_pu2e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_3_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_3_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_3_err_pu2e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_3_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_3_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_3_err_pu2e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_4_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_4_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_4_err_pu2e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_4_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_4_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_4_err_pu2e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_5_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_5_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch1_5_err_pu2e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_5_scale_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_5_expend_pu2e').value = '';</script>";
			echo "<script>document.getElementById('ch2_5_err_pu2e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('1_t_pu2e').value = '';</script>";
			echo "<script>document.getElementById('1_err_t_pu2e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('2_t_pu2e').value = '';</script>";
			echo "<script>document.getElementById('2_err_t_pu2e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('3_t_pu2e').value = '';</script>";
			echo "<script>document.getElementById('3_err_t_pu2e').innerHTML = '#';</script>";
		}
		
	}

	class ProtocolPu1e extends Protocol {

		public function getResultQueryDefaltArray()
		{
			$this->query = "SELECT * FROM `pu1e`";
			if ($this->getConnect())
			{
				$this->result = mysqli_query($this->conn, $this->query);
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

		public function setData($json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"INSERT INTO `pu1e` SET `nb_protocol` = '{$to_set['nb_protocol']}', `date` = '{$to_set['date']}', 
				`date_poverka` = ".($to_set['date_poverka']==NULL ? "NULL" : "'{$to_set['date_poverka']}").", `type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `id_poverka` = '{$to_set['id_poverka']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`ch1_1_scale_expend` = '{$to_set['ch1_1_scale_expend']}',  `ch1_1_expend` = '{$to_set['ch1_1_expend']}',  `ch1_1_err` = '{$to_set['ch1_1_err']}', 
				`ch1_2_scale_expend` = '{$to_set['ch1_2_scale_expend']}',  `ch1_2_expend` = '{$to_set['ch1_2_expend']}',  `ch1_2_err` = '{$to_set['ch1_2_err']}', 
				`ch1_3_scale_expend` = '{$to_set['ch1_3_scale_expend']}',  `ch1_3_expend` = '{$to_set['ch1_3_expend']}',  `ch1_3_err` = '{$to_set['ch1_3_err']}', 
				`ch1_4_scale_expend` = '{$to_set['ch1_4_scale_expend']}',  `ch1_4_expend` = '{$to_set['ch1_4_expend']}',  `ch1_4_err` = '{$to_set['ch1_4_err']}', 
				`ch1_5_scale_expend` = '{$to_set['ch1_5_scale_expend']}',  `ch1_5_expend` = '{$to_set['ch1_5_expend']}',  `ch1_5_err` = '{$to_set['ch1_5_err']}', 
				`ch2_1_scale_expend` = '{$to_set['ch2_1_scale_expend']}',  `ch2_1_expend` = '{$to_set['ch2_1_expend']}',  `ch2_1_err` = '{$to_set['ch2_1_err']}', 
				`ch2_2_scale_expend` = '{$to_set['ch2_2_scale_expend']}',  `ch2_2_expend` = '{$to_set['ch2_2_expend']}',  `ch2_2_err` = '{$to_set['ch2_2_err']}', 
				`ch2_3_scale_expend` = '{$to_set['ch2_3_scale_expend']}',  `ch2_3_expend` = '{$to_set['ch2_3_expend']}',  `ch2_3_err` = '{$to_set['ch2_3_err']}', 
				`ch2_4_scale_expend` = '{$to_set['ch2_4_scale_expend']}',  `ch2_4_expend` = '{$to_set['ch2_4_expend']}',  `ch2_4_err` = '{$to_set['ch2_4_err']}', 
				`ch2_5_scale_expend` = '{$to_set['ch2_5_scale_expend']}',  `ch2_5_expend` = '{$to_set['ch2_5_expend']}',  `ch2_5_err` = '{$to_set['ch2_5_err']}', 
				`1_t_inst` = '{$to_set['1_t_inst']}',  `1_t` = '{$to_set['1_t']}',  `1_err_t` = '{$to_set['1_err_t']}', 
				`2_t_inst` = '{$to_set['2_t_inst']}',  `2_t` = '{$to_set['2_t']}',  `2_err_t` = '{$to_set['2_err_t']}', 
				`3_t_inst` = '{$to_set['3_t_inst']}',  `3_t` = '{$to_set['3_t']}',  `3_err_t` = '{$to_set['3_err_t']}'
				;");
				if ($this->result)
				{
					$nb_protocol_hash = hash("crc32", (string)$this->conn->insert_id."pu1e", false);
					$this->result = mysqli_query($this->conn, "UPDATE `pu1e` SET `nb_protocol` = '$nb_protocol_hash' WHERE `id` = ".$this->conn->insert_id);
					if ($this->result)
						return true;
					else
						return false;
				}
				else
					return false;
			}
		}

		public function setUpdate($id, $json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"UPDATE `pu1e` SET  `date` = '{$to_set['date']}', 
				`type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`ch1_1_scale_expend` = '{$to_set['ch1_1_scale_expend']}',  `ch1_1_expend` = '{$to_set['ch1_1_expend']}',  `ch1_1_err` = '{$to_set['ch1_1_err']}', 
				`ch1_2_scale_expend` = '{$to_set['ch1_2_scale_expend']}',  `ch1_2_expend` = '{$to_set['ch1_2_expend']}',  `ch1_2_err` = '{$to_set['ch1_2_err']}', 
				`ch1_3_scale_expend` = '{$to_set['ch1_3_scale_expend']}',  `ch1_3_expend` = '{$to_set['ch1_3_expend']}',  `ch1_3_err` = '{$to_set['ch1_3_err']}', 
				`ch1_4_scale_expend` = '{$to_set['ch1_4_scale_expend']}',  `ch1_4_expend` = '{$to_set['ch1_4_expend']}',  `ch1_4_err` = '{$to_set['ch1_4_err']}', 
				`ch1_5_scale_expend` = '{$to_set['ch1_5_scale_expend']}',  `ch1_5_expend` = '{$to_set['ch1_5_expend']}',  `ch1_5_err` = '{$to_set['ch1_5_err']}', 
				`ch2_1_scale_expend` = '{$to_set['ch2_1_scale_expend']}',  `ch2_1_expend` = '{$to_set['ch2_1_expend']}',  `ch2_1_err` = '{$to_set['ch2_1_err']}', 
				`ch2_2_scale_expend` = '{$to_set['ch2_2_scale_expend']}',  `ch2_2_expend` = '{$to_set['ch2_2_expend']}',  `ch2_2_err` = '{$to_set['ch2_2_err']}', 
				`ch2_3_scale_expend` = '{$to_set['ch2_3_scale_expend']}',  `ch2_3_expend` = '{$to_set['ch2_3_expend']}',  `ch2_3_err` = '{$to_set['ch2_3_err']}', 
				`ch2_4_scale_expend` = '{$to_set['ch2_4_scale_expend']}',  `ch2_4_expend` = '{$to_set['ch2_4_expend']}',  `ch2_4_err` = '{$to_set['ch2_4_err']}', 
				`ch2_5_scale_expend` = '{$to_set['ch2_5_scale_expend']}',  `ch2_5_expend` = '{$to_set['ch2_5_expend']}',  `ch2_5_err` = '{$to_set['ch2_5_err']}', 
				`1_t_inst` = '{$to_set['1_t_inst']}',  `1_t` = '{$to_set['1_t']}',  `1_err_t` = '{$to_set['1_err_t']}', 
				`2_t_inst` = '{$to_set['2_t_inst']}',  `2_t` = '{$to_set['2_t']}',  `2_err_t` = '{$to_set['2_err_t']}', 
				`3_t_inst` = '{$to_set['3_t_inst']}',  `3_t` = '{$to_set['3_t']}',  `3_err_t` = '{$to_set['3_err_t']}'
				WHERE `id` = {$id} ;");
				if ($this->result)
					return true;
				else
					return false;
			}
		}

		public function setOpenerDefaltForm()
		{
			echo "<script>window.opener.document.getElementById('search_pu1e').placeholder = '';</script>";
	
			echo "<script>window.opener.document.getElementById('ch1_1_scale_expend_pu1e').value = 1.5;</script>";
			echo "<script>window.opener.document.getElementById('ch1_1_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_1_err_pu1e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_scale_expend_pu1e').value = 1.5;</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_err_pu1e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_2_scale_expend_pu1e').value = 0.8;</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_err_pu1e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_scale_expend_pu1e').value = 0.8;</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_err_pu1e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_3_scale_expend_pu1e').value = 0.4;</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_err_pu1e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_scale_expend_pu1e').value = 0.4;</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_err_pu1e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_4_scale_expend_pu1e').value = 0.2;</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_err_pu1e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_scale_expend_pu1e').value = 0.2;</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_err_pu1e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_5_scale_expend_pu1e').value = 0.1;</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_err_pu1e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_scale_expend_pu1e').value = 0.1;</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_expend_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_err_pu1e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('1_t_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('1_err_t_pu1e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('2_t_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('2_err_t_pu1e').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('3_t_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('3_err_t_pu1e').innerHTML = '#';</script>";

			echo "<script>window.opener.document.getElementById('ch1_1_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_delt_pu1e').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_delt_pu1e').value = '';</script>";

		}

		public function setDefaltForm()
		{
	
			echo "<script>document.getElementById('ch1_1_scale_expend_pu1e').value = 1.5;</script>";
			echo "<script>document.getElementById('ch1_1_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_1_err_pu1e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_1_scale_expend_pu1e').value = 1.5;</script>";
			echo "<script>document.getElementById('ch2_1_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_1_err_pu1e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_2_scale_expend_pu1e').value = 0.8;</script>";
			echo "<script>document.getElementById('ch1_2_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_2_err_pu1e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_2_scale_expend_pu1e').value = 0.8;</script>";
			echo "<script>document.getElementById('ch2_2_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_2_err_pu1e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_3_scale_expend_pu1e').value = 0.4;</script>";
			echo "<script>document.getElementById('ch1_3_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_3_err_pu1e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_3_scale_expend_pu1e').value = 0.4;</script>";
			echo "<script>document.getElementById('ch2_3_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_3_err_pu1e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_4_scale_expend_pu1e').value = 0.2;</script>";
			echo "<script>document.getElementById('ch1_4_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_4_err_pu1e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_4_scale_expend_pu1e').value = 0.2;</script>";
			echo "<script>document.getElementById('ch2_4_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_4_err_pu1e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_5_scale_expend_pu1e').value = 0.1;</script>";
			echo "<script>document.getElementById('ch1_5_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_5_err_pu1e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_5_scale_expend_pu1e').value = 0.1;</script>";
			echo "<script>document.getElementById('ch2_5_expend_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_5_err_pu1e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('1_t_pu1e').value = '';</script>";
			echo "<script>document.getElementById('1_err_t_pu1e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('2_t_pu1e').value = '';</script>";
			echo "<script>document.getElementById('2_err_t_pu1e').innerHTML = '#';</script>";
			echo "<script>document.getElementById('3_t_pu1e').value = '';</script>";
			echo "<script>document.getElementById('3_err_t_pu1e').innerHTML = '#';</script>";

			echo "<script>document.getElementById('ch1_1_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_1_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_2_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_2_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_3_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_3_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_4_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_4_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch1_5_delt_pu1e').value = '';</script>";
			echo "<script>document.getElementById('ch2_5_delt_pu1e').value = '';</script>";
		}

	}

	class ProtocolPu2p extends Protocol {

		public function getResultQueryDefaltArray()
		{
			$this->query = "SELECT * FROM `pu2p`";
			if ($this->getConnect())
			{
				$this->result = mysqli_query($this->conn, $this->query);
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
		
		public function setData($json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"INSERT INTO `pu2p` SET `nb_protocol` = '{$to_set['nb_protocol']}', `date` = '{$to_set['date']}', 
				`date_poverka` = ".($to_set['date_poverka']==NULL ? "NULL" : "'{$to_set['date_poverka']}").", `type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `id_poverka` = '{$to_set['id_poverka']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`ch1_1_scale_expend` = '{$to_set['ch1_1_scale_expend']}',  `ch1_1_expend` = '{$to_set['ch1_1_expend']}',  `ch1_1_err` = '{$to_set['ch1_1_err']}', 
				`ch1_2_scale_expend` = '{$to_set['ch1_2_scale_expend']}',  `ch1_2_expend` = '{$to_set['ch1_2_expend']}',  `ch1_2_err` = '{$to_set['ch1_2_err']}', 
				`ch1_3_scale_expend` = '{$to_set['ch1_3_scale_expend']}',  `ch1_3_expend` = '{$to_set['ch1_3_expend']}',  `ch1_3_err` = '{$to_set['ch1_3_err']}', 
				`ch1_4_scale_expend` = '{$to_set['ch1_4_scale_expend']}',  `ch1_4_expend` = '{$to_set['ch1_4_expend']}',  `ch1_4_err` = '{$to_set['ch1_4_err']}', 
				`ch1_5_scale_expend` = '{$to_set['ch1_5_scale_expend']}',  `ch1_5_expend` = '{$to_set['ch1_5_expend']}',  `ch1_5_err` = '{$to_set['ch1_5_err']}', 
				`ch2_1_scale_expend` = '{$to_set['ch2_1_scale_expend']}',  `ch2_1_expend` = '{$to_set['ch2_1_expend']}',  `ch2_1_err` = '{$to_set['ch2_1_err']}', 
				`ch2_2_scale_expend` = '{$to_set['ch2_2_scale_expend']}',  `ch2_2_expend` = '{$to_set['ch2_2_expend']}',  `ch2_2_err` = '{$to_set['ch2_2_err']}', 
				`ch2_3_scale_expend` = '{$to_set['ch2_3_scale_expend']}',  `ch2_3_expend` = '{$to_set['ch2_3_expend']}',  `ch2_3_err` = '{$to_set['ch2_3_err']}', 
				`ch2_4_scale_expend` = '{$to_set['ch2_4_scale_expend']}',  `ch2_4_expend` = '{$to_set['ch2_4_expend']}',  `ch2_4_err` = '{$to_set['ch2_4_err']}', 
				`ch2_5_scale_expend` = '{$to_set['ch2_5_scale_expend']}',  `ch2_5_expend` = '{$to_set['ch2_5_expend']}',  `ch2_5_err` = '{$to_set['ch2_5_err']}', 
				`1_t_inst` = '{$to_set['1_t_inst']}',  `1_t` = '{$to_set['1_t']}',  `1_err_t` = '{$to_set['1_err_t']}', 
				`2_t_inst` = '{$to_set['2_t_inst']}',  `2_t` = '{$to_set['2_t']}',  `2_err_t` = '{$to_set['2_err_t']}', 
				`3_t_inst` = '{$to_set['3_t_inst']}',  `3_t` = '{$to_set['3_t']}',  `3_err_t` = '{$to_set['3_err_t']}'
				;");
				if ($this->result)
				{
					$nb_protocol_hash = hash("crc32", (string)$this->conn->insert_id."pu2p", false);
					$this->result = mysqli_query($this->conn, "UPDATE `pu2p` SET `nb_protocol` = '$nb_protocol_hash' WHERE `id` = ".$this->conn->insert_id);
					if ($this->result)
						return true;
					else
						return false;
				}
				else
					return false;
			}
		}
		
		public function setUpdate($id, $json)
		{
			if ($this->getConnect())
			{
				$to_set = json_decode($json, true);
				$this->result = mysqli_query($this->conn,"UPDATE `pu2p` SET  `date` = '{$to_set['date']}', 
				`type_ci` = '{$to_set['type_ci']}', `modif_ci` = '{$to_set['modif_ci']}', 
				`reg_nbr` = '{$to_set['reg_nbr']}', `metrolog_charcter` = '{$to_set['metrolog_charcter']}', `doc_pov` = '{$to_set['doc_pov']}', 
				`temp` = '{$to_set['temp']}', `wet` = '{$to_set['wet']}', `atmos_press` = '{$to_set['atmos_press']}', `standards` = '{$to_set['standards']}', 
				`ch1_1_scale_expend` = '{$to_set['ch1_1_scale_expend']}',  `ch1_1_expend` = '{$to_set['ch1_1_expend']}',  `ch1_1_err` = '{$to_set['ch1_1_err']}', 
				`ch1_2_scale_expend` = '{$to_set['ch1_2_scale_expend']}',  `ch1_2_expend` = '{$to_set['ch1_2_expend']}',  `ch1_2_err` = '{$to_set['ch1_2_err']}', 
				`ch1_3_scale_expend` = '{$to_set['ch1_3_scale_expend']}',  `ch1_3_expend` = '{$to_set['ch1_3_expend']}',  `ch1_3_err` = '{$to_set['ch1_3_err']}', 
				`ch1_4_scale_expend` = '{$to_set['ch1_4_scale_expend']}',  `ch1_4_expend` = '{$to_set['ch1_4_expend']}',  `ch1_4_err` = '{$to_set['ch1_4_err']}', 
				`ch1_5_scale_expend` = '{$to_set['ch1_5_scale_expend']}',  `ch1_5_expend` = '{$to_set['ch1_5_expend']}',  `ch1_5_err` = '{$to_set['ch1_5_err']}', 
				`ch2_1_scale_expend` = '{$to_set['ch2_1_scale_expend']}',  `ch2_1_expend` = '{$to_set['ch2_1_expend']}',  `ch2_1_err` = '{$to_set['ch2_1_err']}', 
				`ch2_2_scale_expend` = '{$to_set['ch2_2_scale_expend']}',  `ch2_2_expend` = '{$to_set['ch2_2_expend']}',  `ch2_2_err` = '{$to_set['ch2_2_err']}', 
				`ch2_3_scale_expend` = '{$to_set['ch2_3_scale_expend']}',  `ch2_3_expend` = '{$to_set['ch2_3_expend']}',  `ch2_3_err` = '{$to_set['ch2_3_err']}', 
				`ch2_4_scale_expend` = '{$to_set['ch2_4_scale_expend']}',  `ch2_4_expend` = '{$to_set['ch2_4_expend']}',  `ch2_4_err` = '{$to_set['ch2_4_err']}', 
				`ch2_5_scale_expend` = '{$to_set['ch2_5_scale_expend']}',  `ch2_5_expend` = '{$to_set['ch2_5_expend']}',  `ch2_5_err` = '{$to_set['ch2_5_err']}', 
				`1_t_inst` = '{$to_set['1_t_inst']}',  `1_t` = '{$to_set['1_t']}',  `1_err_t` = '{$to_set['1_err_t']}', 
				`2_t_inst` = '{$to_set['2_t_inst']}',  `2_t` = '{$to_set['2_t']}',  `2_err_t` = '{$to_set['2_err_t']}', 
				`3_t_inst` = '{$to_set['3_t_inst']}',  `3_t` = '{$to_set['3_t']}',  `3_err_t` = '{$to_set['3_err_t']}'
				WHERE `id` = {$id} ;");
				if ($this->result)
					return true;
				else
					return false;
			}
		}
		
		public function setOpenerDefaltForm()
		{
			echo "<script>window.opener.document.getElementById('search_pu2p').placeholder = '';</script>";
		
			echo "<script>window.opener.document.getElementById('ch1_1_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_1_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_1_err_pu2p').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_1_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>window.opener.document.getElementById('ch1_2_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_2_err_pu2p').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_2_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>window.opener.document.getElementById('ch1_3_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_3_err_pu2p').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_3_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>window.opener.document.getElementById('ch1_4_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_4_err_pu2p').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_4_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>window.opener.document.getElementById('ch1_5_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch1_5_err_pu2p').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_scale_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_expend_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('ch2_5_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>window.opener.document.getElementById('1_t_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('1_err_t_pu2p').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('2_t_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('2_err_t_pu2p').innerHTML = '#';</script>";
			echo "<script>window.opener.document.getElementById('3_t_pu2p').value = '';</script>";
			echo "<script>window.opener.document.getElementById('3_err_t_pu2p').innerHTML = '#';</script>";
		
		}
		
		public function setDefaltForm()
		{
		
			echo "<script>document.getElementById('ch1_1_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_1_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_1_err_pu2p').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_1_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_1_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_1_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>document.getElementById('ch1_2_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_2_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_2_err_pu2p').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_2_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_2_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_2_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>document.getElementById('ch1_3_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_3_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_3_err_pu2p').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_3_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_3_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_3_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>document.getElementById('ch1_4_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_4_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_4_err_pu2p').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_4_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_4_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_4_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>document.getElementById('ch1_5_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_5_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch1_5_err_pu2p').innerHTML = '#';</script>";
			echo "<script>document.getElementById('ch2_5_scale_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_5_expend_pu2p').value = '';</script>";
			echo "<script>document.getElementById('ch2_5_err_pu2p').innerHTML = '#';</script>";
		
			echo "<script>document.getElementById('1_t_pu2p').value = '';</script>";
			echo "<script>document.getElementById('1_err_t_pu2p').innerHTML = '#';</script>";
			echo "<script>document.getElementById('2_t_pu2p').value = '';</script>";
			echo "<script>document.getElementById('2_err_t_pu2p').innerHTML = '#';</script>";
			echo "<script>document.getElementById('3_t_pu2p').value = '';</script>";
			echo "<script>document.getElementById('3_err_t_pu2p').innerHTML = '#';</script>";
		}
		
		}


}
catch (Exception $e)
{
	echo $e->getMessage();
}

// $protcol_pu1b = new ProtocolPu1b;

// if (!$protcol_pu1b->getResultQueryDefaltArray())
// 	echo $protcol_pu1b->getConnError();
// var_dump($protcol_pu1b);

// $date_add_pu1b = array(
// 	'nb_protocol' =>		'1',
// 	'date' =>				'2023-02-01',
// 	'date_poverka' =>		'2023-02-08',
// 	'type_ci' =>			'1',
// 	'modif_ci' =>			'1',
// 	'reg_nbr' =>			'1',
// 	'metrolog_charcter' =>	'1',
// 	'id_poverka' =>			'666',
// 	'doc_pov' =>			'1',
// 	'temp' =>				'1',
// 	'wet' =>				'1',
// 	'atmos_press' =>		'1',
// 	'standards' =>			'1',
// 	'1_channel' =>			'4',
// 	'1_inst_expend' =>		'4',
// 	'1_expend' =>			'4',
// 	'1_vol' =>				'4',
// 	'1_err_vol' => 			'4',
// 	'2_channel' => 			'1',
// 	'2_inst_expend' => 		'1',
// 	'2_expend' => 			'1',
// 	'2_vol' =>				'1',
// 	'2_err_vol' =>			'1',
// 	'3_channel' =>			'1',
// 	'3_inst_expend' => 		'1',
// 	'3_expend' => 			'1',
// 	'3_vol' => 				'1',
// 	'3_err_vol' => 			'1',
// 	'4_channel' => 			'1',
// 	'4_inst_expend' => 		'1',
// 	'4_expend' => 			'1',
// 	'4_vol' => 				'1',
// 	'4_err_vol' =>			'1',
// 	'5_channel' => 			'1',
// 	'5_inst_expend' => 		'1',
// 	'5_expend' => 			'1',
// 	'5_vol' => 				'1',
// 	'5_err_vol' => 			'1'
// );
// var_dump($date_add_pu1b);
// $json = json_encode($date_add_pu1b, JSON_UNESCAPED_UNICODE);
// var_dump($json);

// var_dump($protcol_pu1b->setUpdate(2, $json));
// echo $protcol_pu1b->getConnError();

// var_dump($protcol_pu1b->setData($json));
// var_dump($protcol_pu1b->getConn());
// echo $protcol_pu1b->getConnError();

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