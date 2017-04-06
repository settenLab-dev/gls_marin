<?php

	class dbMaster {
		private $con;

		private $iv;
		private $resource;

		public function dbMaster() {
			$this->con = mysql_connect( DB_SLAKER_HOST, DB_SLAKER_USERNAME, DB_SLAKER_PASSWORD);

			if ($this->con == false) {
				return false;
			}
			mb_language(DB_LANGUAGE);
			mb_internal_encoding(DB_ENCODING);
			mb_http_output(DB_OUTPUT);

			mysql_query(DB_SETNAMES,$this->con);
			mysql_select_db(DB_SLAKER_DATABASE);

			return true;
		}

		public function close(){
			mysql_close($this->con);
		}

		public function execute($sql) {
			$result = mysql_query($sql,$this->con);
			if (!$result) {
				cmLogOutput("ERROR","[sql]".$sql." [error]".mysql_error());
			}
			else {
				cmLogOutput("DEBUG","[sql]".$sql." [error]".mysql_error());
			}
			return $result;
		}

		public function getCon() {
			return $this->con;
		}

		public function begin() {
			return mysql_query("begin;");
		}

		public function rollback() {
			return mysql_query("rollback;");
		}

		public function commit() {
			return mysql_query("commit;");
		}

	}
?>
