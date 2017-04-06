<?php

	class db {
		private $con;

		private $iv;
		private $resource;

		public function db($sess="") {
			if ($sess->getSessionByKey($sess->getSessionLogninKey(), "ACCOUNT_DB_USER") == "") {
				return false;
			}
			if ($sess->getSessionByKey($sess->getSessionLogninKey(), "ACCOUNT_DB_PASSWORD") == "") {
				return false;
			}
			if ($sess->getSessionByKey($sess->getSessionLogninKey(), "ACCOUNT_DB_SERVER") == "") {
				return false;
			}
			if ($sess->getSessionByKey($sess->getSessionLogninKey(), "ACCOUNT_DB_NAME") == "") {
				return false;
			}

			$user = $sess->getSessionByKey($sess->getSessionLogninKey(), "ACCOUNT_DB_USER");
			$pass = $sess->getSessionByKey($sess->getSessionLogninKey(), "ACCOUNT_DB_PASSWORD");
			$server = $sess->getSessionByKey($sess->getSessionLogninKey(), "ACCOUNT_DB_SERVER");
			$dbname = $sess->getSessionByKey($sess->getSessionLogninKey(), "ACCOUNT_DB_NAME");
			$this->con = mysql_connect( $server, $user, $pass, true);

			//$this->mcryptOpen();

			if ($this->con == false) {
				//$this->mcryptClose();
				return false;
			}
			mb_language(DB_LANGUAGE);
			mb_internal_encoding(DB_ENCODING);
			mb_http_output(DB_OUTPUT);

			mysql_query(DB_SETNAMES,$this->con);
			mysql_select_db($dbname);

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

		/**
		private function mcryptOpen() {
			$this->iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC), SITE_ENCRYPTION_VECTOR);
			$this->resource = mcrypt_module_open(MCRYPT_BLOWFISH, '',  MCRYPT_MODE_CBC, '');;
		}
		private function mcryptClose() {
			mcrypt_module_close($this->resource);
		}
		public function encryption($target) {
			$base64_data = base64_encode($target);

			mcrypt_generic_init($this->resource, SITE_ENCRYPTION_KEY, $this->iv);
			$encrypted_data = mcrypt_generic($this->resource, $base64_data);

			mcrypt_generic_deinit($this->resource);

			return $encrypted_data;
		}
		public function decrypt($target) {
			mcrypt_generic_init($this->resource, SITE_ENCRYPTION_KEY, $this->iv);

			$base64_decrypted_data = mdecrypt_generic($this->resource, $target);

			mcrypt_generic_deinit($this->resource);

			$decrypted_data = base64_decode($base64_decrypted_data);

			print $decrypted_data;
		}
		**/

	}
?>
