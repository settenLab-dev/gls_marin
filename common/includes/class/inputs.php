<?php

	//	アップロードクラス
	require_once 'class.upload.php';

	class inputs {
		var $readonly;
		var $xss;

		private $id;
		private $subId;
		private $handle;

		public function inputs($readonly=false,$xss=true) {
			$this->readonly = $readonly;
			$this->xss = $xss;
		}

		//	text
		public function text($name,$value,$class="",$size="", $option="") {
			$defText = '<input type="text" id="%s" name="%s" value="%s" %s %s %s %s />';

			return sprintf($defText,$name,$name,$this->createValue($value),$this->createClass($class),$this->createSize($size),$this->createReadonly(), $option);
		}
		//	textArea
		public function textArea($name,$value,$class="",$col="",$row="") {
			$defText = '<textarea name="%s" %s %s %s %s >%s</textarea>';
			return sprintf($defText, $name, $this->createClass($class), $this->createCol($col), $this->createRow($row), $this->createReadonly(), $this->createValue($value));
		}
		//	password
		public function password($name,$value,$class="",$size="") {
			$defText = '<input type="password" name="%s" value="%s" %s %s %s />';

			return sprintf($defText,$name,$this->createValue($value),$this->createClass($class),$this->createSize($size),$this->createReadonly());
		}
		//	hidden
		public function hidden($name,$value) {
			$defText = '<input type="hidden" id="%s" name="%s" value="%s" />';

			return sprintf($defText,$name,$name,$this->createValue($value));
		}
		//	button
		public function button($id,$name,$value,$class="",$option="") {
			$defText = '<input type="button" id="%s" name="%s" value="%s" %s %s />';
			return sprintf($defText,$id,$name,$this->createValue($value), $this->createClass($class), $option);
		}
		//	checkbox
		public function checkbox($id,$name,$value,$selected,$label,$class="", $op="") {
			if ($this->readonly) {
				$defTextInput = '<input type="checkbox" id="%s" %s %s />';

				$dCheck = sprintf($defTextInput,$id,$this->createChecked($value,$selected),$this->createDisabled());
				$dHidden = $this->hidden($name,$this->createValue($selected));
				if ($value != $selected) {
					$class .= ' colorGrey';
				}
				$dLabel = $this->label($name,$class,$label);

				$ret = $dCheck.$dHidden.$dLabel;
			}
			else {
				$defTextInput = '<input type="checkbox" id="%s" name="%s" value="%s" %s %s />';
				$dCheck = sprintf($defTextInput,$id,$name,$value,$this->createChecked($value,$selected), $op);
				$dLabel = $this->label($id,$class,$label);
				$ret = $dCheck.$dLabel;
			}
			return $ret;
		}
		//	selectbox
		public function selectbox($name, $optionList, $selected, $class="", $option="", $non=false, $link="") {
			if ($this->readonly) {
				$dHidden = $this->hidden($name,$this->createValue($selected));

				foreach ($optionList as $op) {
					if ($op->value == $selected) {
						$dLabel = $this->label($name,$class,$op->name);
						break;
					}
				}
				return $dHidden.$dLabel;
			}
			else {
				$defOption = '<option value="%s" %s %s>%s</option>';
				$options = "";
				if ($non) {
					$options .= '<option value="" class="none">---</option>';
				}
				if (count($optionList) > 0 and $optionList != "") {
					foreach ($optionList as $op) {
						//	status
						if ($op->status != 1) {
							continue;
						}
						if ($link == "") {
							$options .= sprintf($defOption,$this->createValue($op->value), $this->createSelected($op->value,$selected), "", $op->name);
						}
						elseif ($link == 1) {
							$options .= sprintf($defOption,$this->createValue($op->value), $this->createSelected($op->value,$selected), 'title="'.$op->value.'"', $op->name);
						}
						else {
							$options .= sprintf($defOption,$this->createValue($op->value), $this->createSelected($op->value,$selected), 'class="'.$op->$link.'"', $op->name);
						}
					}
				}
				$defSelect = '<select id="%s" name="%s" %s %s>'.$options.'</select>';
				$ret = sprintf($defSelect, $name, $name, $this->createClass($class), $option);
			}
			return $ret;
		}
		//	radio
		public function radio($id,$name,$value,$selected,$label,$class="") {
			if ($this->readonly) {
				if ($value ==$selected){
					$dHidden = $this->hidden($name,$this->createValue($selected));
					$dLabel = $this->label($name,$class,$label);
					$ret = $dHidden.$dLabel;
				}
				else {
					$ret = "";
				}
			}
			else {
				$defTextInput = '<input type="radio" id="%s" name="%s" value="%s" %s />';
				$dRadio = sprintf($defTextInput,$id,$name,$this->createValue($value),$this->createChecked($value,$selected));
				$dLabel = $this->label($id,$class,$label);
				$ret = $dRadio.$dLabel;
			}
			return $ret;
		}
		//	image
		public function image($name,$value,$width="",$height="",$size="",$class="", $smoll="") {
			if ($this->readonly) {
				if ($width != "" and $height != "") {
					$defImage  = '<img src="%s" width="%s" height="%s" border="0" %s />';

					if (cmCheckPtn($smoll, CHK_PTN_NUM)  and $smoll != 1 and $smoll != "") {
						$image = sprintf($defImage, $this->createImageSrc($value, $smoll, $name), $width/$smoll, $height/$smoll, $this->createClass($class));
					}
					else {
						$image = sprintf($defImage, $this->createImageSrc($value, $smoll, $name), $width, $height, $this->createClass($class));
					}
				}
				else {
					$defImage  = '<img src="%s" border="0" %s />';
					$image = sprintf($defImage, $this->createImageSrc($value, $smoll, $name), $this->createClass($class));
				}
//				$defImage  = '<img src="%s" width="%s" height="%s" border="0" %s />';
//				$image = sprintf($defImage, $this->createImageSrc($value), $width, $height, $this->createClass($class));
				$dHidden = $this->hidden($name,$value);
				$ret  = $image;
				$ret .= $dHidden;
			}
			else {
				if ($width != "" and $height != "") {
					$defImage  = '<img src="%s" width="%s" height="%s" border="0" %s />';

					if (cmCheckPtn($smoll, CHK_PTN_NUM) and $smoll != 1 and $smoll != "") {
						$image = sprintf($defImage, $this->createImageSrc($value, $smoll, $name), $width/$smoll, $height/$smoll, $this->createClass($class));
					}
					else {
						$image = sprintf($defImage, $this->createImageSrc($value, $smoll, $name), $width, $height, $this->createClass($class));
					}

				}
				else {
					$defImage  = '<img src="%s" border="0" %s />';
					$image = sprintf($defImage, $this->createImageSrc($value, $smoll, $name), $this->createClass($class));
				}
				$defFile = '<input type="file" name="%s" />';
				$file = sprintf($defFile, $name."_input");
				$dHidden = $this->hidden($name,$value);
				$msg1 = $this->description("●登録可能ファイル<br />&nbsp;&nbsp;".SLAKER_UPLOAD_IMAGES."");
				$sizeMessage = "";
				if ($width != "") {
					$sizeMessage .= "横幅:".$width."px ";
				}
				if ($height != "") {
					$sizeMessage .= "縦幅:".$height."px ";
				}
				if ($sizeMessage != "") {
					$msg2 = $this->description("●推奨サイズ<br />".$sizeMessage);
				}
				if (cmCheckPtn($smoll, CHK_PTN_NUM) and $smoll != 1 and $smoll != "") {
					$msg2 .= $this->description("(約1/".$smoll."に縮小表示中)");
				}
				if ($size != "") {
				$msg3 = $this->description("●ファイル容量<br />&nbsp;&nbsp;".$this->createByte(SLAKER_UPLOAD_IMAGE_SIZE*$size)."MB");
				}

				$ret .= '<table cellpadding="0" cellspacing="5" border="0" summary="画像アップロード">';
				$ret .= '<tr><td valign="top">';
				$ret .= $image;
				$ret .= '</td>';
				$ret .= '<td valign="top" align="left">';
				$ret .= $msg1.$msg2.$msg3;
				$ret .= $file.$dHidden;
				$ret .= '</td></tr>';
				$ret .= '</table>';
			}
			return $ret;
		}

		//	file
		public function file($name, $value, $size, $class="") {
			if ($this->readonly) {
				$dHidden = $this->hidden($name,$value);
				$ret .= $dHidden;
			}
			else {
				$defFile = '<input type="file" name="%s" />';
				$file = sprintf($defFile, $name."_input");
				$dHidden = $this->hidden($name,$value);
//				$msg1 = $this->description("【登録可能ファイル】<br />&nbsp;&nbsp;MPEG-1、MPEG-2、QuickTime Movie, FLV");
				switch ($name) {
					case "QUESTION_EXPLAN_PICTURE":
						$msg2 = $this->description("【推奨サイズ】<br /> 縦幅:".IMAGE_DESCRIPTION_HEIGHT."px、横幅:".IMAGE_DESCRIPTION_WIDTH."px");
						break;
				}
				$msg3 = $this->description("【ファイル容量】<br />&nbsp;&nbsp;".$this->createByte(SLAKER_UPLOAD_IMAGE_SIZE*$size)."MB");

				$ret .= '<table cellpadding="3" cellspaceing="0" border="0" summary="ファイルアップロード">';
				$ret .= '<tr>';
				$ret .= '<td valign="top">';
				$ret .= $msg1.$msg2.$msg3;
				$ret .= $file.$dHidden;
				$ret .= '</td></tr>';
				$ret .= '</table>';
			}
			return $ret;
		}

		//	label
		public function label($name,$class="",$label) {
			$defText = '<label for="%s" %s>%s</label>';

			return sprintf($defText,$name,$this->createClass($class),$label);
		}
		//	submit
		public function submit($id,$name,$value,$class="") {
			$defText = '<input type="submit" %s name="%s" value="%s" %s />';
			return sprintf($defText,$this->createId($id),$name,$value, $this->createClass($class));
		}
		//	itemName
		public function itemName($value,$required) {
				$defText = '<p>%s %s</p>';
			return sprintf($defText,$value,$this->createRequired($required));
		}
		//	description
		public function description($value) {
			$defText = '<p>%s</p>';
			return sprintf($defText,redirectForReturn($value));
		}


		private function createValue($target) {
			if ($this->xss) {
				return stripslashes(redirectForXss($target));
//				return stripslashes($target);
//				return ($target);
			}
			return $target;
		}
		private function createImageSrc($target, $smoll="", $name) {
			$time = session_id();
			$time = sha1($time);

			if ($target == "") {
				if ($smoll == "") {
					$pic = "";
					switch ($name) {
						case "MEMBER_PIC":
							$pic = URL_SLAKER_COMMON."assets/memberNoImage.jpg".'?'.time();
							break;
						default:
							$pic = URL_SLAKER_COMMON."assets/noImage.jpg".'?'.time();
							break;
					}
					return $pic;
				}
				else {
					$pic = "";
					switch ($name) {
						case "MEMBER_PIC":
							$pic = URL_SLAKER_COMMON."assets/memberNoImage.jpg".'?'.time();
							break;
						default:
							$pic = URL_SLAKER_COMMON."assets/noImage_s.jpg".'?'.time();
							break;
					}
					return $pic;
				}
			}
			return URL_SLAKER_COMMON."images/".$target.'?'.time();
		}
		private function createClass($target) {
			if ($target != "") {
				return 'class="'.$target.'"';
			}
			return "";
		}
		private function createSize($target) {
			if ($target != "") {
				return 'size="'.$target.'"';
			}
			return "";
		}
		private function createRow($target) {
			if ($target != "") {
				return 'rows="'.$target.'"';
			}
			return "";
		}
		private function createCol($target) {
			if ($target != "") {
				return 'cols="'.$target.'"';
			}
			return "";
		}
		private function createReadonly() {
			if ($this->readonly) {
//				return 'readonly="readonly" style="background-color:#dcdcdc; "';
				return 'readonly="readonly" style="background-color:#f5f5f5; border:1px solid #838383;"';
			}
			return "";
		}
		private function createDisabled() {
			if ($this->readonly) {
				return 'disabled="true"';
			}
			return "";
		}
		private function createChecked($val,$select) {
			if ($val == $select) {
				return 'checked="checked"';
			}
			return "";
		}
		private function createSelected($val,$select) {
			if ($val == $select) {
				return 'selected="selected"';
			}
			return "";
		}
		private function createId($target) {
			if ($target != "") {
				return 'id="'.$target.'"';
			}
			return "";
		}
		private function createRequired($target) {
			if ($target == 2 and !$this->readonly) {
				return '<span class="colorRed">※</span>';
			}
		}
		//	バイト表記をMB表記へ
		private function createByte($byte) {
			return $byte/SLAKER_UPLOAD_IMAGE_SIZE/1000;
		}

		//	画像のアップロード
		public function upload($targetName, $targetSize="", $w="", $h="", $resize=1) {
			$tmpfile = $_FILES[$targetName."_input"];
			if ($tmpfile["size"] <= 0) {

				if ($_POST[$targetName] != "") {
					$this->setHandle(true);
					return $_POST[$targetName];
				}

				$this->setHandle(false);
				return "non";
			}
			if (!is_uploaded_file($tmpfile["name"])) {
				//	ファイルサイズ
				if ($targetSize != "") {
					if ($tmpfile["size"] >= SLAKER_UPLOAD_IMAGE_SIZE * $targetSize) {
						$this->setHandle(false);
						return "アップロード画像のサイズが大きすぎます";
					}
				}
				//	ファイルタイプ
				if ($tmpfile["size"] > 0 and !cmCheckPtn($tmpfile["type"], '/^image\/.*$/')) {
					$this->setHandle(false);
					return "画像ファイルをアップロードして下さい";
				}
			}

			$extension = substr($tmpfile["name"], strrpos($tmpfile["name"], '.') + 1);

			$handle = new Upload($_FILES[$targetName."_input"]);
			if ($handle->uploaded) {
				$time = date('Ymd').sha1(microtime());
				$name = $targetName."_".$time;

				//	画像のみを許可
				$handle->allowed = array('image/*');
				//	JPGに変換
				//$handle->image_convert = 'jpg';
				//	上書き許可
				$handle->file_overwrite = false;
				//	ファイル名
				$handle->file_src_name_body = $name;

				//	動作設定
				switch ($resize) {
					case 1:
						//	リサイズ許可
						$handle->image_resize = true;
						//	縦横比維持
						$handle->image_ratio = false;
						//	横最大値
						$handle->image_x = $w;
						//	縦最大値
						$handle->image_y = $h;
						break;
					case 2:
						//	リサイズしない
						$handle->image_resize = false;
						//	縦横比維持
						$handle->image_ratio = true;
						break;
					default:
						break;
				}

				if ($this->getId() != "") {
					$handle->Process(PATH_SLAKER_COMMON."images/".$this->getId()."/");
				}
				else {
					$handle->Process(PATH_SLAKER_COMMON."images/");
				}

				if (!$handle->processed) {
					$this->setHandle(false);
					return "ファイルアップロード失敗:".$handle->error;
				}
				else {
					$this->setHandle(true);
					return $this->getId()."/".$name.".".$extension;
				}
			}
			else {
				$this->setHandle(false);
				return "アップロード出来ないファイルです:".$handle->error;
			}

		}

		public function uploadMovie($targetName, $targetSize="") {
			$tmpfile = $_FILES[$targetName."_input"];
			if ($tmpfile["size"] <= 0) {
				$this->setHandle(false);
				return "non";
			}
			if (!is_uploaded_file($tmpfile["name"])) {
// 				//	ファイルサイズ
// 				if ($tmpfile["size"] >= SLAKER_UPLOAD_IMAGE_SIZE * $targetSize) {
// 					$this->setHandle(false);
// 					return "アップロードのサイズが大きすぎます";
// 				}
			}

			$time = date('Ymd').sha1(microtime());
			$extension = substr($tmpfile["name"], strrpos($tmpfile["name"], '.') + 1);
			$name = $targetName."_".$time.".".$extension;
			$file_path = PATH_SLAKER_COMMON."images/".$this->getId()."/".$name;


			if(move_uploaded_file($_FILES[$targetName."_input"]["tmp_name"], $file_path)) {
				if ($extension != "flv") {
					$a = exec("ffmpeg -y -i ".$file_path." -ar 44100 ".PATH_SLAKER_COMMON."images/".$this->getId()."/".$targetName."_".$time.".flv 2>&1",$arr,$ret);
				}
				 foreach ($arr as $dddd) {
				cmLogOutput("DEBUG","[動画変換]".$dddd);
				}
				/*
				*/
				if ($ret > 0) {
					unlink($file_path);
					$this->setHandle(false);
					return "動画の変換に失敗しました。アップロード出来ない場合は、「FLV形式」に変換後お試しください。";
				}
				else {
					$this->setHandle(true);
					if ($extension != "flv") {
						unlink($file_path);
					}
					return $this->getId()."/".$targetName."_".$time.".flv";
				}

			}
			else {
				$this->setHandle(false);
				return "ファイルのアップロードに失敗しました。";
			}
		}


		public function setId($id) {
			$this->id = $id;
		}
		public function getId() {
			return $this->id;
		}

		public function setSubId($id) {
			$this->subId = $id;
		}
		public function getSubId() {
			return $this->subId;
		}

		public function setHandle($id) {
			$this->handle = $id;
		}
		public function getHandle() {
			return $this->handle;
		}

		function ch_image_type($file){
		  $id=getimagesize($file);
		  switch( $id[2] ){
		    case 1:
		      return '.gif';
		      break;
		    case 2:
		      return '.jpg';
		      break;
		    case 3:
		      return '.png';
		      break;
		    case 4:
		      return '.swf';
		      break;
		    case 5:
		      return '.psd';
		      break;
		    case 6:
		      return '.bmp';
		      break;
		    case 7:
		      return '.tiff';
		      break;
		    case 8:
		      return '.tiff';
		      break;
		    case 9:
		      return '.jpc';
		      break;
		    case 10:
		      return '.jp2';
		      break;
		    case 11:
		      return '.jpx';
		      break;
		    case 12:
		      return '.jb2';
		      break;
		    case 13:
		      return '.swc';
		      break;
		    case 14:
		      return '.iff';
		      break;
		    case 15:
		      return '.wbmp';
		      break;
		    case 16:
		      return '.xbm';
		      break;
		    default:
		      return '';
		      break;
		  }
		  return false;
		}

	}
?>
