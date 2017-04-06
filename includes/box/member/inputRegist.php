        	<?php
	if ($memberRegist->getErrorCount() > 0) {
	?>
				<?php print create_error_caption($memberRegist->getError())?>
	<?php
	}
	?>

        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
                <h2 class="title_def">登録情報の入力</h2>
                <ul class="regist_tbl">
                    <li>
                    	<ul class="inner">
							<li class="title"><p>氏名 <span class="colorRed">※</span></p></li>
							<li>
								姓<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME1"))?>
											<?=$inputs->text("MEMBER_NAME1",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME1"),"imeActive")?>
							</li>
							<li>	
								名<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME2"))?>
											<?=$inputs->text("MEMBER_NAME2",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME2"),"imeActive")?>
							</li>
                    	</ul>
                    </li>
                    <li>
                    	<ul class="inner">
							<li class="title"><p>フリガナ <span class="colorRed">※</span></p></li>
							<li>
								セイ<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME_KANA1"))?>
											<?=$inputs->text("MEMBER_NAME_KANA1",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME_KANA1"),"imeActive")?>
							</li>
							<li>
								メイ<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME_KANA2"))?>
											<?=$inputs->text("MEMBER_NAME_KANA2",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME_KANA2"),"imeActive")?>
							</li>
						</ul>
                    </li>
                    <li>
                    	<ul class="inner">
							<li class="title"><p>ニックネーム</p></li>
							<li>
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_HANDLENAME"))?>
							<?php print $inputs->text("MEMBER_HANDLENAME", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_HANDLENAME") ,"imeActive")?>
							</li>
						</ul>
					</li>
					<li>
                    	<ul class="inner">
							<li class="title"><p>ご職業 </p></li>
							<li>
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
							</li>
						</ul>
					</li>
                    <li>
                    	<ul class="inner">
                    	<li class="title"><p>性別 <span class="colorRed">※</span></p></li>
                    	<li>
                    		<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_SEX"))?>
                    		<?php print $inputs->radio("MEMBER_SEX1", "MEMBER_SEX", 1, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_SEX") ," 男")?>
							<?php print $inputs->radio("MEMBER_SEX2", "MEMBER_SEX", 2, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_SEX") ," 女")?>
                    	</li>
                    	</ul>
                    </li>
                    <li>
                    	<ul class="inner">
                    	<li class="title"><p>生年月日 <span class="colorRed">※</span></p></li>
                    	<li>
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

                    	</li>
                		</ul>
                    </li>
                    <li>
						<ul class="inner">
						<li class="title"><p>ご住所 <span class="colorRed">※</span></p></li>
						<li>
								<ul class="address">
									<li class="sub">郵便番号</li>
										<li>
											<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_ZIP"))?>
											<?php print $inputs->text("MEMBER_ZIP", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_ZIP") ,"imeDisabled circle wZip", "", 'onKeyUp="AjaxZip3.zip2addr(this,\'\',\'MEMBER_PREF\',\'MEMBER_CITY\',\'MEMBER_ADDRESS\');"')?>
											<p>※(例)000-0000の様に、-(ハイフン)付きで入力して下さい。</p>
										</li>
									<li class="sub">都道府県</li>
										<li>
											<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_PREF"))?>
											<?php
											$arPref = cmGetAllPrefName();
											?>
											<?php if (count($arPref) > 0) {?>
											<select name=MEMBER_PREF id="MEMBER_PREF" class="circle">
											  <option value="">---</option>
												<?php foreach ($arPref as $k=>$v) {?>
											  <option value="<?php print $k;?>" <?php print ($memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_PREF")==$k)?'selected="selected"':''?>><?php print $v;?></option>
												<?php }?>
											<?php }?>
											</select>
										</li>
									<li class="sub">市区町村</li>
										<li>
											<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_CITY"))?>
											<?php print $inputs->text("MEMBER_CITY", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_CITY") ,"imeActive circle", "40")?>
										</li>
									<li class="sub">その他住所</li>
										<li>
											<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_ADDRESS"))?>
											<?php print $inputs->text("MEMBER_ADDRESS", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_ADDRESS") ,"imeActive circle", "40")?>
										</li>
									<li class="sub">建物名</li>
										<li>
											<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_BUILD"))?>
											<?php print $inputs->text("MEMBER_BUILD", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_BUILD") ,"imeActive circle", "40")?>
										</li>
								</ul>
						</li>
						</ul>
					</li>
					<li>
						<ul class="inner">
							<li class="title"><p>電話番号 <span class="colorRed">※</span></p></li>
							<li>
								<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_TEL1"))?>
								<?php print $inputs->text("MEMBER_TEL1", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_TEL1") ,"imeDisabled circle",40)?>
								<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。</p>
							</li>
						</ul>
					</li>
					<li>
						<ul class="inner">
						<li class="title"><p>メール配信 <span class="colorRed">※</span></p></li>
						<li>
							<p>PlayBookingからのお知らせやお得情報をお送りいたします。</p>
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_FLG_MAILMAGAZINE"))?>
							<?php print $inputs->radio("MEMBER_FLG_MAILMAGAZINE1", "MEMBER_FLG_MAILMAGAZINE", 1, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_FLG_MAILMAGAZINE") ," 受け取る")?>
							<?php print $inputs->radio("MEMBER_FLG_MAILMAGAZINE2", "MEMBER_FLG_MAILMAGAZINE", 2, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_FLG_MAILMAGAZINE") ," 受け取らない")?>
						</li>
						</ul>
					</li>
                </ul>    

                <h2 class="title_def">メールアドレス(ログインID)・パスワードの設定</h2>                    
                <ul class="regist_tbl">
                     <li>
						<ul class="inner">
							<li class="title">メールアドレス <span class="colorRed">※</span></li>
							<li>
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_ID"))?>
								<p>
								<?php 
								if($fromBasic){
									print $inputs->text("MEMBER_LOGIN_ID", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_LOGIN_ID") ,"imeActive");
								}else{
									print $inputs->text("MEMBER_LOGIN_ID", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_LOGIN_ID") ,"imeActive",'40',"disabled");
								}
								?></p>
								<p>※ログインIDとして使用します。</p>
							</li>
	                   </ul>
                    </li>
                    <li>
						<ul class="inner">
                    	<li class="title">パスワード <span class="colorRed">※</span></li>
                    	<li>
                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_PASSWORD"))?>
                    	<?=$inputs->password("MEMBER_LOGIN_PASSWORD",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_LOGIN_PASSWORD"),"imeDisabled",40)?>
                    	</li>
                    	</ul>
                    	<ul class="inner">
                    	<li class="title">パスワード(確認) <span class="colorRed">※</span></li>
                    	<li>
                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM))?>
                    	<?=$inputs->password("MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM,$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_LOGIN_PASSWORD".WORDS_CONFIRM),"imeDisabled",40)?>
                    	<p>※確認の為、もう一度ご入力下さい。</p>
                    	</li>
						</ul>
                    </li>
                </ul>
						   <div class="btn_regist">
							<?=$inputs->submit("","regist","登録する", "circle")?>
						   </div>

           	</form>