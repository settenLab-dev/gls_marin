        	<?php
	if ($memberRegist->getErrorCount() > 0) {
	?>
				<?php print create_error_caption($memberRegist->getError())?>
	<?php
	}
	?>

        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
                <table class="tblInput registmem" width="100%">
                    <tr>
                    	<th width="25%">氏名 <span class="colorRed">※</span></th>
                    	<td>
							姓<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME1"))?>
				                    	<?=$inputs->text("MEMBER_NAME1",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME1"),"imeActive")?><br/>
							名<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME2"))?>
				                    	<?=$inputs->text("MEMBER_NAME2",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME2"),"imeActive")?>
                    	</td>
                    </tr>
                    <tr>
                    	<th >氏名(カナ) <span class="colorRed">※</span></th>
                    	<td>
							姓<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME_KANA1"))?>
				                    	<?=$inputs->text("MEMBER_NAME_KANA1",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME_KANA1"),"imeActive")?><br/>
							名<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME_KANA2"))?>
				                    	<?=$inputs->text("MEMBER_NAME_KANA2",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME_KANA2"),"imeActive")?>
                    	</td>
                    </tr>
                    <tr>
						<th valign="top">
							<p>ニックネーム <span class="colorRed">※</span</p>
						</th>
						<td align="left">
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_HANDLENAME"))?>
							<?php print $inputs->text("MEMBER_HANDLENAME", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_HANDLENAME") ,"imeActive")?>
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>職業 </p>
						</th>
						<td align="left">
							<?php print create_error_msg($memberRegist->getErrorByKey("M_MEMBER_WORK_ID"))?>
							<?php $ar = cmWorkId();?>
							<?php if (count($ar) > 0) {?>
							<select name="M_MEMBER_WORK_ID" class="circle">
								<option value="">---</option>
								<?php
								foreach ($ar as $k=>$v) {
									$selected = '';
									if ($memberRegist->getByKey($memberRegist->getKeyValue(), "M_MEMBER_WORK_ID") == $k) {
										$selected = 'selected="selected"';
									}
								?>
								<option value="<?php print $k?>" <?php print $selected;?>><?php print $v;?></option>
								<?php
								}
								?>
							</select>
							<?php }?>
						</td>
					</tr>
                     <tr>
                    	<th>メールアドレス <span class="colorRed">※</span></th>
                    	<td>
                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_ID"))?>
                    		<p>
                    		<?php 
                    		if($fromBasic){
                    			print $inputs->text("MEMBER_LOGIN_ID", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_LOGIN_ID") ,"imeActive");
                    		}else{
								print $inputs->text("MEMBER_LOGIN_ID", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_LOGIN_ID") ,"imeActive",'',"disabled");
                    		}
                    		?></p>
                    		<p>※ログインIDとして使用します。</p>
                    	</td>
                    </tr>
                     <!--<tr>
                    	<th>パスワード <span class="colorRed">※</span></th>
                    	<td>
                    		<p>ご入力頂いたパスワード</p>
                    	</td>
                    </tr>-->
                    <tr>
                    	<th>パスワード <span class="colorRed">※</span></th>
                    	<td>
                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_PASSWORD"))?>
                    	<?=$inputs->password("MEMBER_LOGIN_PASSWORD",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_LOGIN_PASSWORD"),"imeDisabled")?>
                    	</td>
                    </tr>
                    <tr>
                    	<th>パスワード(確認) <span class="colorRed">※</span></th>
                    	<td>
                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))?>
                    	<?=$inputs->password("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM,$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM),"imeDisabled")?>
                    	<p>※確認の為、もう一度ご入力下さい。</p>
                    	</td>
                    </tr>
                    <tr>
                    	<th>性別 <span class="colorRed">※</span></th>
                    	<td>
                    		<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_SEX"))?>
                    		<?php print $inputs->radio("MEMBER_SEX1", "MEMBER_SEX", 1, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_SEX") ," 男")?>
							<?php print $inputs->radio("MEMBER_SEX2", "MEMBER_SEX", 2, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_SEX") ," 女")?>
                    	</td>
                    </tr>
                    <tr>
                    	<th>生年月日 <span class="colorRed">※</span></th>
                    	<td>
                    	<?php print create_error_msg($memberRegist->getErrorByKey("birthday"))?>
                    	<select name="MEMBER_BIRTH_YEAR">
                    		<option value="">---</option>
                    		<?php
                    		for ($i=date("Y")-80; $i<=date("Y")-15; $i++) {
								$selected = '';
								if ($memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_BIRTH_YEAR") == $i) {
									$selected = 'selected="selected"';
								}
							?>
                    		<option value="<?php print $i?>" <?php print $selected?>><?php print $i?></option>
                    		<?php }?>
                    	</select> 年
                    	<select name="MEMBER_BIRTH_MONTH">
                    		<option value="">---</option>
                    		<?php
                    		for ($i=1; $i<=12; $i++) {
								$selected = '';
								if ($memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_BIRTH_MONTH") == $i) {
									$selected = 'selected="selected"';
								}
							?>
                    		<option value="<?php print $i?>" <?php print $selected?>><?php print $i?></option>
                    		<?php }?>
                    	</select> 月
                    	<select name="MEMBER_BIRTH_DAY">
                    		<option value="">---</option>
                    		<?php
                    		for ($i=1; $i<=31; $i++) {
								$selected = '';
								if ($memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_BIRTH_DAY") == $i) {
									$selected = 'selected="selected"';
								}
							?>
                    		<option value="<?php print $i?>" <?php print $selected?>><?php print $i?></option>
                    		<?php }?>
                    	</select> 日

                    	</td>
                    </tr>
                    <tr>
						<th valign="top">
							<p>ご住所 <span class="colorRed">※</span></p>
						</th>
						<td align="left">
							<table class="inner" cellspacing="10">
								<tr>
									<td valign="top">郵便番号</td>
									<td>
										<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_ZIP"))?>
										<?php print $inputs->text("MEMBER_ZIP", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'MEMBER_PREF\',\'MEMBER_CITY\',\'MEMBER_ADDRESS\');"')?>
										<p>※(例)000-0000の様に、-(ハイフン)付きで入力して下さい。</p>
										<p>自動で住所が入力されます。</p>
									</td>
								</tr>
								<tr>
									<td>都道府県</td>
									<td>
										<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_PREF"))?>
										<?php
										$arPref = cmGetPrefName();
										?>
										<?php if (count($arPref) > 0) {?>
										<select name=MEMBER_PREF id="MEMBER_PREF" class="circle">
						                  <option value="">---</option>
											<?php foreach ($arPref as $k=>$v) {?>
						                  <option value="<?php print $k;?>" <?php print ($memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_PREF")==$k)?'selected="selected"':''?>><?php print $v;?></option>
											<?php }?>
										<?php }?>
						                </select>
									</td>
								</tr>
								<tr>
									<td>市区町村</td>
									<td>
										<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_CITY"))?>
										<?php print $inputs->text("MEMBER_CITY", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_CITY") ,"imeActive circle", "20")?>
									</td>
								</tr>
								<tr>
									<td>その他住所</td>
									<td>
										<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_ADDRESS"))?>
										<?php print $inputs->text("MEMBER_ADDRESS", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_ADDRESS") ,"imeActive circle", "20")?>
									</td>
								</tr>
								<tr>
									<td>建物名</td>
									<td>
										<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_BUILD"))?>
										<?php print $inputs->text("MEMBER_BUILD", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_BUILD") ,"imeActive circle", "20")?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>電話番号 <span class="colorRed">※</span></p>
						</th>
						<td align="left">
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_TEL1"))?>
							<?php print $inputs->text("MEMBER_TEL1", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_TEL1") ,"imeDisabled circle wNum",50)?>
							<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
							★携帯電話のみの方はこちらへご入力ください。</p>
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>携帯電話 </p>
						</th>
						<td align="left">
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_TEL2"))?>
							<?php print $inputs->text("MEMBER_TEL2", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_TEL2") ,"imeDisabled circle wNum",30)?>
							<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。</p>
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>携帯メールアドレス </p>
						</th>
						<td align="left">
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_MAILADDRESS_SUB"))?>
							<?php print $inputs->text("MEMBER_MAILADDRESS_SUB", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_MAILADDRESS_SUB") ,"imeDisabled circle",20)?>
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>メールマガジン <span class="colorRed">※</span></p>
						</th>
						<td align="left">
							<p>ココトモ！から旬な遊びの情報や、お得なメルマガ限定企画などをお届けします！ぜご購読ください。</p>
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_FLG_MAILMAGAZINE"))?>
							<?php print $inputs->radio("MEMBER_FLG_MAILMAGAZINE1", "MEMBER_FLG_MAILMAGAZINE", 1, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_FLG_MAILMAGAZINE") ," 受け取る")?>
							<?php print $inputs->radio("MEMBER_FLG_MAILMAGAZINE2", "MEMBER_FLG_MAILMAGAZINE", 2, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_FLG_MAILMAGAZINE") ," 受け取らない")?>
							<?php print $inputs->hidden("MEMBER_EVENT_FLG", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_EVENT_FLG"),"bijin")?>
						</td>
					</tr>
                    <tr>
                    	<td class="bt-td" align="center" colspan="2">
                    	<?=$inputs->submit("","regist","登録する", "circle")?>
                    	</td>
                    </tr>
                </table>
           	</form>