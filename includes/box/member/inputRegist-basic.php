        	<?php
	if ($memberRegist->getErrorCount() > 0) {
	?>
				<?php print create_error_caption($memberRegist->getError())?>
	<?php
	}
	?>

        	<form action="<?php print $_SERVER['REQUEST_URI']?>" method="post">
                <table class="tblInput" width="100%">
                    <tr>
                    	<th width="140">氏名 <span class="colorRed">※</span></th>
                    	<td>
                    		<table class="inner">
                    			<tr>
                    				<td>姓</td>
                    				<td>
				                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME1"))?>
				                    	<?=$inputs->text("MEMBER_NAME1",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME1"),"imeActive")?>
                    				</td>
                    				<td>名</td>
                    				<td>
				                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME2"))?>
				                    	<?=$inputs->text("MEMBER_NAME2",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME2"),"imeActive")?>
                    				</td>
                    			</tr>
                    		</table>
                    	</td>
                    </tr>
                    <tr>
                    	<th >氏名(カナ) <span class="colorRed">※</span></th>
                    	<td>
                    		<table class="inner">
                    			<tr>
                    				<td>姓</td>
                    				<td>
				                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME_KANA1"))?>
				                    	<?=$inputs->text("MEMBER_NAME_KANA1",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME_KANA1"),"imeActive")?>
                    				</td>
                    				<td>名</td>
                    				<td>
				                    	<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_NAME_KANA2"))?>
				                    	<?=$inputs->text("MEMBER_NAME_KANA2",$memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_NAME_KANA2"),"imeActive")?>
                    				</td>
                    			</tr>
                    		</table>
                    	</td>
                    </tr>
                    <tr>
						<th valign="top">
							<p>ニックネーム <span class="colorRed">※</span</p>
						</th>
						<td align="left">
						<p>ニックネームは、ご利用のサービスによっては他の方へ公開されます。個人情報は登録しないでください。</p>
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
									if ($memberRegist->getByKey($memberRegist->getKeyValue(), "M_MEMBER_WORK_ID") == $ar) {
										$selected = 'selected="selected"';
									}
								?>
								<option value="<?php print $ar?>" <?php print $selected;?>><?php print $v;?></option>
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
                    		<p><?php print $memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_LOGIN_ID");?></p>
                    		<p>※ログインIDとして使用します。</p>
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
                    	    <p><?php print $memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_BIRTH_YEAR");?>年
                    	    <?php print $memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_BIRTH_MONTH");?>月
                    	    <?php print $memberRegist->getByKey($memberRegist->getKeyValue(),"MEMBER_BIRTH_DAY");?>日</p>　※一度登録した内容は変更できません。
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
									<td>その他住所</td>
									<td>
										<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_ADDRESS"))?>
										<?php print $inputs->text("MEMBER_ADDRESS", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_ADDRESS") ,"imeActive circle", "50")?>
									</td>
								</tr>
								<tr>
									<td>建物名</td>
									<td>
										<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_BUILD"))?>
										<?php print $inputs->text("MEMBER_BUILD", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_BUILD") ,"imeActive circle", "50")?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>電話番号1 <span class="colorRed">※</span></p>
						</th>
						<td align="left">
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_TEL1"))?>
							<?php print $inputs->text("MEMBER_TEL1", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_TEL1") ,"imeDisabled circle wNum",50)?>
							<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。<br></p>
							<span class="colorRed">★携帯電話のみの方はこちらへ番号を入力してください。</span>
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>電話番号2 </p>
						</th>
						<td align="left">
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_TEL2"))?>
							<?php print $inputs->text("MEMBER_TEL2", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_TEL2") ,"imeDisabled circle wNum",50)?>
							<p>※(例)00-0000-0000のように、-(ハイフン)付きで入力して下さい。
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>サブメールアドレス</p>
						</th>
						<td align="left">
						<p>ログインIDとは別のメールアドレスを入力してください。（任意）<br>
						ログインIDのアドレスにご連絡がつかない場合や、予約情報の転送(※実装予定)の際に利用します。</p>
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_MAILADDRESS_SUB"))?>
							<?php print $inputs->text("MEMBER_MAILADDRESS_SUB", $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_MAILADDRESS_SUB") ,"imeDisabled circle",50)?>
						</td>
					</tr>
					<tr>
						<th valign="top">
							<p>メールマガジン <span class="colorRed">※</span></p>
						</th>
						<td align="left">
						<p>ココモ。より、旬のお楽しみ情報や、お得なメールマガジン限定企画をお届けします！ぜひご購読ください。</p>
							<?php print create_error_msg($memberRegist->getErrorByKey("MEMBER_FLG_MAILMAGAZINE"))?>
							<?php print $inputs->radio("MEMBER_FLG_MAILMAGAZINE1", "MEMBER_FLG_MAILMAGAZINE", 1, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_FLG_MAILMAGAZINE") ," 受け取る")?>
							<?php print $inputs->radio("MEMBER_FLG_MAILMAGAZINE2", "MEMBER_FLG_MAILMAGAZINE", 2, $memberRegist->getByKey($memberRegist->getKeyValue(), "MEMBER_FLG_MAILMAGAZINE") ," 受け取らない")?>
						</td>
					</tr>
                    <tr>
                    	<td align="center" colspan="2">
                    	<?=$inputs->submit("","regist","登録する", "circle")?>
                    	</td>
                    </tr>
                </table>
           	</form>