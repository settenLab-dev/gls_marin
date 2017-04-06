<?php
	require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');
	require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
	require_once(PATH_SLAKER_COMMON.'includes/class/extends/member.php');

    class session {
    	private $db;

		public function session($db) {
			$this->db = $db;
		}

		public function start() {
			session_start();
			session_regenerate_id();
		}

		public function destroy() {
//			@session_destroy();
			$_SESSION = array();
		}

		public function getCookieIdKey() {
			return SITE_COOKIE_ADMIN_ID;
		}
		public function getCookiePasswordKey() {
			return SITE_COOKIE_ADMIN_PASS;
		}

		public function getDbId() {
			return "ADMIN_LOGIN_ID";
		}
		public function getDbPass() {
			return "ADMIN_LOGIN_PASSWORD";
		}

		public function getSessionLogninKey() {
			return "adminLoginInfo";
		}

		public function getSessionByKey($key,$key2="") {
			if ($key2 == "") {
				return $_SESSION[$key];
			}
			return $_SESSION[$key][$key2];
		}
		public function setSessionByKey($key, $val, $key2="") {
			if ($key2 == "") {
				return $_SESSION[$key] = $val;
			}
			return $_SESSION[$key][$key2] = $val;
		}

		public function setSessionList($key,$valList) {
			foreach ($valList as $k => $v) {
				$_SESSION[$key][$k] = $v;
			}
		}

		public function setSession($key,$val) {
			$_SESSION[$key] = $val;
		}

		public function sessionCheck() {
			if ($_POST["logout"]) {
				// セッション変数を解除

				$_SESSION = array();

				// クッキー削除
				if (isset($_COOKIE[session_name()])) {
				    setcookie(session_name(), '', time()-1800);
				}

				// セッション破壊
				session_destroy();


				return false;
			}
			if ($_SESSION[$this->getSessionLogninKey()][$this->getDbId()] != "" and $_SESSION[$this->getSessionLogninKey()][$this->getDbPass()] != "") {
				$collection = new collection($this->db);
				$collection->setByKey($collection->getKeyValue(), $this->getDbId(), $_SESSION[$this->getSessionLogninKey()][$this->getDbId()]);
				$collection->setByKey($collection->getKeyValue(), $this->getDbPass(), $_SESSION[$this->getSessionLogninKey()][$this->getDbPass()]);
				$adminCheck = new admin($this->db);
				$adminCheck->selectLogin($collection);
				if ($adminCheck->getCount() == 1) {
					$this->setSessionList($this->getSessionLogninKey(), $adminCheck->getCollectionByKey($adminCheck->getKeyValue()));
					return true;
				}
				return false;
			}
			else {
				if ($this->cookieCheck()) {
					return true;
				}
			}
			return false;
		}

		public function cookieCheck() {
			if ($_COOKIE[$this->getCookieIdKey()] != "" and $_COOKIE[$this->getCookiePasswordKey()] != "") {
				$admin = new admin($this->db);
				$admin->selectLoginCookie();
				if ($admin->getCount() > 0) {
					$this->setSessionList($this->getSessionLogninKey(), $admin->getCollectionByKey($admin->getKeyValue()));
					return true;
				}
			}
			return false;
		}

		public function setCookieData($id,$pass, $time="") {
			setcookie($this->getCookieIdKey(), $id, time()+$time);
			setcookie($this->getCookiePasswordKey(), $pass, time()+$time);
		}
    }


    class sessionCompany extends session {
    	public function sessionCompany($db) {
			parent::session($db);
			$this->db = $db;
		}
		public function getDbId() {
			return "COMPANY_LOGIN_ID";
		}
		public function getDbPass() {
			return "COMPANY_LOGIN_PASSWORD";
		}

		public function getCookieIdKey() {
			return SITE_COOKIE_SHOP_ID;
		}
		public function getCookiePasswordKey() {
			return SITE_COOKIE_SHOP_PASS;
		}

		public function getSessionLogninKey() {
			return "companyLoginInfo";
		}

		public function sessionCheck() {
			if ($_POST["logout"]) {
				// セッション変数を解除

				$_SESSION = array();

				// クッキー削除
				if (isset($_COOKIE[session_name()])) {
				    setcookie(session_name(), '', time()-1800);
				}

				// セッション破壊
				session_destroy();

				return false;
			}
			if ($_SESSION[$this->getSessionLogninKey()][$this->getDbId()] != "" and $_SESSION[$this->getSessionLogninKey()][$this->getDbPass()] != "") {
				$collection = new collection($this->db);
				$collection->setByKey($collection->getKeyValue(), $this->getDbId(), $_SESSION[$this->getSessionLogninKey()][$this->getDbId()]);
				$collection->setByKey($collection->getKeyValue(), $this->getDbPass(), $_SESSION[$this->getSessionLogninKey()][$this->getDbPass()]);
				$adminCheck = new company($this->db);
				$adminCheck->selectLogin($collection);
				if ($adminCheck->getCount() == 1) {
					$this->setSessionList($this->getSessionLogninKey(), $adminCheck->getCollectionByKey($adminCheck->getKeyValue()));
					return true;
				}
				return false;
			}
			else {
				if ($this->cookieCheck()) {
					return true;
				}
			}
			return false;
		}

		public function cookieCheck() {
			if ($_COOKIE[$this->getCookieIdKey()] != "" and $_COOKIE[$this->getCookiePasswordKey()] != "") {
				$admin = new company($this->db);
				$admin->selectLoginCookie();
				if ($admin->getCount() > 0) {
					$this->setSessionList($this->getSessionLogninKey(), $admin->getCollectionByKey($admin->getKeyValue()));
					return true;
				}
			}
			return false;
		}

    }

    class sessionMember extends session {
    	public function sessionMember($db) {
    		parent::session($db);
    		$this->db = $db;
    	}
    	public function getDbId() {
    		return "MEMBER_LOGIN_ID";
    	}
    	public function getDbPass() {
    		return "MEMBER_LOGIN_PASSWORD";
    	}

    	public function getCookieIdKey() {
    		return SITE_COOKIE_PUBLIC_ID;
    	}
    	public function getCookiePasswordKey() {
    		return SITE_COOKIE_PUBLIC_PASS;
    	}

    	public function getSessionLogninKey() {
    		return "memberLoginInfo";
    	}

    	public function sessionCheck() {
    		if ($_POST["logout"]) {
				// セッション変数を解除

				$_SESSION = array();

				// クッキー削除
				if (isset($_COOKIE[session_name()])) {
				    setcookie(session_name(), '', time()-1800);
				}

				// セッション破壊
				session_destroy();

    			return false;
    		}
    		if ($_SESSION[$this->getSessionLogninKey()][$this->getDbId()] != "" and $_SESSION[$this->getSessionLogninKey()][$this->getDbPass()] != "") {
    			$collection = new collection($this->db);
    			$collection->setByKey($collection->getKeyValue(), $this->getDbId(), $_SESSION[$this->getSessionLogninKey()][$this->getDbId()]);
    			$collection->setByKey($collection->getKeyValue(), $this->getDbPass(), $_SESSION[$this->getSessionLogninKey()][$this->getDbPass()]);
    			$adminCheck = new member($this->db);
    			$adminCheck->selectLogin($collection);
    			if ($adminCheck->getCount() == 1) {
    				$this->setSessionList($this->getSessionLogninKey(), $adminCheck->getCollectionByKey($adminCheck->getKeyValue()));
    				return true;
    			}
    			return false;
    		}
    		else {
    			if ($this->cookieCheck()) {
    				return true;
    			}
    		}
    		return false;
    	}

    	public function cookieCheck() {
    		if ($_COOKIE[$this->getCookieIdKey()] != "" and $_COOKIE[$this->getCookiePasswordKey()] != "") {
    			$admin = new member($this->db);
    			$admin->selectLoginCookie();
    			if ($admin->getCount() > 0) {
    				$this->setSessionList($this->getSessionLogninKey(), $admin->getCollectionByKey($admin->getKeyValue()));
    				return true;
    			}
    		}
    		return false;
    	}

    }

?>
