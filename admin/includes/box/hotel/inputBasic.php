<?php if ($shop->getErrorCount() > 0) {?>
<?php print create_error_caption($shop->getError())?>
<?php }?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>施設概要</h3>
		</th>
	</tr>
	<tr>
		<th width="160" valign="top">
			<p>ショップ名 </p>
		</th>
		<td align="left" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_NAME"))?>
			<p><?=$inputs->text("SHOP_NAME", $shop->getByKey($shop->getKeyValue(), "SHOP_NAME"), "imeActive circle",100)?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ショップ名(カナ) </p>
		</th>
		<td align="left" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_NAME_KANA"))?>
			<p><?=$inputs->text("SHOP_NAME_KANA", $shop->getByKey($shop->getKeyValue(), "SHOP_NAME_KANA"), "imeActive circle",100)?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>電話番号</p>
		</th>
		<td align="left" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_TEL"))?>
			<p><?=$inputs->text("SHOP_TEL", $shop->getByKey($shop->getKeyValue(), "SHOP_TEL"), "imeActive circle",100)?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ショップ住所 </p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_ADDRESS"))?>
			<p><?=$inputs->textarea("SHOP_ADDRESS", $shop->getByKey($shop->getKeyValue(), "SHOP_ADDRESS"), "imeActive circle",30,4)?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>営業時間</p>
		</th>
		<td align="left" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_OPENTIME"))?>
			<p><?=$inputs->text("SHOP_OPENTIME", $shop->getByKey($shop->getKeyValue(), "SHOP_OPENTIME"), "imeActive circle",100)?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>定休日</p>
		</th>
		<td align="left" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_CLOSEDAY"))?>
			<p><?=$inputs->text("SHOP_CLOSEDAY", $shop->getByKey($shop->getKeyValue(), "SHOP_CLOSEDAY"), "imeActive circle",100)?></p>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>ショップ説明文</p>
		</th>
		<td align="left" style="border-bottom: 1px solid #f0f0f0;">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_TEXT"))?>
			<p><?=$inputs->textarea("SHOP_TEXT", $shop->getByKey($shop->getKeyValue(), "SHOP_TEXT"), "imeActive circle",30,4)?></p>
		</td>
	</tr>
	</table>
	<br />

<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>駐車場の概要</h3>
		</th>
	</tr>
	<tr>
		<th valign="top">
			<p>駐車場の有無 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_PARKINGFLG"))?>
			<?php print $inputs->radio("SHOP_PARKINGFLG1", "SHOP_PARKINGFLG", 1, $shop->getByKey($shop->getKeyValue(), "SHOP_PARKINGFLG") ," あり")?>
			<?php print $inputs->radio("SHOP_PARKINGFLG2", "SHOP_PARKINGFLG", 2, $shop->getByKey($shop->getKeyValue(), "SHOP_PARKINGFLG") ," なし")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>駐車場料金 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_PARKINGMONEYFLG"))?>
			<?php print $inputs->radio("SHOP_PARKINGMONEYFLG1", "SHOP_PARKINGMONEYFLG", 1, $shop->getByKey($shop->getKeyValue(), "SHOP_PARKINGMONEYFLG") ," 無料")?>
			<?php print $inputs->radio("SHOP_PARKINGMONEYFLG2", "SHOP_PARKINGMONEYFLG", 2, $shop->getByKey($shop->getKeyValue(), "SHOP_PARKINGMONEYFLG") ," 有料")?><br /><br />
			※有料の場合のみ料金を入力<br />
			<?=$inputs->textarea("SHOP_PARKINGMONEY", $shop->getByKey($shop->getKeyValue(), "SHOP_PARKINGMONEY"), "imeActive circle",30,4)?>

		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>駐車場の<br />事前予約 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_PARKINGBOOKFLG"))?>
			<?php print $inputs->radio("SHOP_PARKINGBOOKFLG1", "SHOP_PARKINGBOOKFLG", 1, $shop->getByKey($shop->getKeyValue(), "SHOP_PARKINGBOOKFLG") ," 不要")?>
			<?php print $inputs->radio("SHOP_PARKINGBOOKFLG2", "SHOP_PARKINGBOOKFLG", 2, $shop->getByKey($shop->getKeyValue(), "SHOP_PARKINGBOOKFLG") ," 必要")?>
		</td>

	</tr>
	<tr>
		<th valign="top">
			<p>駐車台数 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<table class="inner" cellspacing="5">
				<tr>
					<td align="left">
						<?php print create_error_msg($shop->getErrorByKey("SHOP_PARKINGCAP"))?>
						<?=$inputs->text("SHOP_PARKINGCAP", $shop->getByKey($shop->getKeyValue(), "SHOP_PARKINGCAP"), "imeActive circle",50)?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>施設設備に関する情報</h3>
		</th>
	</tr>

	<?php for ($i=1; $i<=12; $i++) {?>
	<tr>
		<th valign="top" width="160">
			<?php
			$targetName = "";
			switch ($i) {
				case 1:
					$targetName = "ロッカー・荷物置き場";
					break;
				case 2:
					$targetName = "ドライヤー";
					break;
				case 3:
					$targetName = "シャワー";
					break;
				case 4:
					$targetName = "着替える場所";
					break;
				case 5:
					$targetName = "トイレ";
					break;
				case 6:
					$targetName = "タオルの貸出";
					break;
				case 7:
					$targetName = "水中カメラ貸出";
					break;
				case 8:
					$targetName = "撮影サービス";
					break;
				case 9:
					$targetName = "ウェットスーツ貸出";
					break;
				case 10:
					$targetName = "周辺5km以内のコンビニ";
					break;
				case 11:
					$targetName = "近隣の入浴施設";
					break;
				case 12:
					$targetName = "パウダースペース(化粧室)";
					break;
			}
			?>
			<p><?php print $targetName?></p>
		</th>
		<td align="left">
			<div class="checkboxarea">
				<?php print create_error_msg($shop->getErrorByKey("SHOP_FACILITY".$i))?>
			  	<?php if ($i == 10){$arData = cmShopFacilitySelect_normal();}
				      else{$arData = cmShopFacilitySelect();};?>
				<?php if (count($arData) > 0) {?>
				<select name="SHOP_FACILITY<?php print $i;?>" class="circle">
					<?php foreach ($arData as $k=>$v) {?>
					<option value="<?php print $k;?>" <?php print ($shop->getByKey($shop->getKeyValue(), "SHOP_FACILITY".$i)==$k)?'selected="selected"':''?>><?php print $v;?></option>
					<?php }?>
				</select>
					<?php if($i != 10){?>
						　　　　料金<?=$inputs->text("SHOP_FACILITY_CHARGE".$i, $shop->getByKey($shop->getKeyValue(), "SHOP_FACILITY_CHARGE".$i), "imeActive circle wNum",80)?> ※有料の場合
					<?php }?>
				<?php }?>
			</div>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th valign="top">
			<p>その他・備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_FACILITY13", $shop->getByKey($shop->getKeyValue(), "SHOP_FACILITY13"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />

<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>お子様関連施設の情報</h3>
		</th>
	</tr>
	<?php for ($i=1; $i<=6; $i++) {?>
	<tr>
		<th valign="top" width="160">
			<?php
			$targetName = "";
			switch ($i) {
				case 1:
					$targetName = "授乳室";
					break;
				case 2:
					$targetName = "ミルク用給湯室";
					break;
				case 3:
					$targetName = "おむつ交換台";
					break;
				case 4:
					$targetName = "お子様用トイレ";
					break;
				case 5:
					$targetName = "親子で遊べるプレイルーム";
					break;
				case 6:
					$targetName = "託児スペース";
					break;
			}
			?>
			<p><?php print $targetName?></p>
		</th>
		<td align="left">
			<div class="checkboxarea">
				<?php print create_error_msg($shop->getErrorByKey("SHOP_CHILD".$i))?>
			  	<?php if ($i < 5){$arData = cmShopFacilitySelect_normal();}
				      else{$arData = cmShopFacilitySelect();};?>
				<?php if (count($arData) > 0) {?>
				<select name="SHOP_CHILD<?php print $i;?>" class="circle">
					<?php foreach ($arData as $k=>$v) {?>
					<option value="<?php print $k;?>" <?php print ($shop->getByKey($shop->getKeyValue(), "SHOP_CHILD".$i)==$k)?'selected="selected"':''?>><?php print $v;?></option>
					<?php }?>
				</select>
				<?php }?>
			</div>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th valign="top">
			<p>その他・備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_CHILD7", $shop->getByKey($shop->getKeyValue(), "SHOP_CHILD7"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />

<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="2">
			<h3>外国人の受け入れに関する情報</h3>
		</th>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>外国人観光客の受け入れについて</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_LANG_FLG"))?>
			<?php print $inputs->radio("SHOP_LANG_FLG1", "SHOP_LANG_FLG", 1, $shop->getByKey($shop->getKeyValue(), "SHOP_LANG_FLG") ," 受入可能")?>
			<?php print $inputs->radio("SHOP_LANG_FLG2", "SHOP_LANG_FLG", 2, $shop->getByKey($shop->getKeyValue(), "SHOP_LANG_FLG") ," 受入不可")?>
		</td>
	</tr>
	<tr>
		<th colspan="2" class="admin_title">
			<h3>各言語の対応可能レベル</h3>
		</th>
	</tr>
	<?php for ($i=1; $i<=4; $i++) {?>
	<tr>
		<th valign="top" width="160">
			<?php
			$targetName = "";
			switch ($i) {
				case 1:
					$targetName = "英語";
					break;
				case 2:
					$targetName = "韓国語";
					break;
				case 3:
					$targetName = "北京語(普通語)";
					break;
				case 4:
					$targetName = "広東語";
					break;
			}
			?>
			<p><?php print $targetName?></p>
		</th>
		<td align="left">
			<div class="checkboxarea">
				<?php print create_error_msg($shop->getErrorByKey("SHOP_LANG_TYPE".$i))?>
			  	<?php $arData = cmShopLangLevelSelect();?>
				<?php if (count($arData) > 0) {?>
				<select name="SHOP_LANG_TYPE<?php print $i;?>" class="circle">
					<?php foreach ($arData as $k=>$v) {?>
					<option value="<?php print $k;?>" <?php print ($shop->getByKey($shop->getKeyValue(), "SHOP_LANG_TYPE".$i)==$k)?'selected="selected"':''?>><?php print $v;?></option>
					<?php }?>
				</select>
				<?php }?>
			</div>
		</td>
	</tr>
	<?php }?>
	<tr>
		<th valign="top">
			<p>その他の言語への対応・備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_LANG_TYPE5", $shop->getByKey($shop->getKeyValue(), "SHOP_LANG_TYPE5"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>お支払に関する情報</h3>
		</th>
	</tr>
	<tr>
		<th width="160">
			<p>当日現金払い</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_CHARGE_FLG1"))?>
			<?php print $inputs->radio("SHOP_CHARGE_FLG11", "SHOP_CHARGE_FLG1", 1, $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG1") ," 利用可")?>
			<?php print $inputs->radio("SHOP_CHARGE_FLG12", "SHOP_CHARGE_FLG1", 2, $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG1") ," 利用不可")?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>当日カード払い</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_CHARGE_FLG2"))?>
			<?php print $inputs->radio("SHOP_CHARGE_FLG21", "SHOP_CHARGE_FLG2", 1, $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG2") ," 利用可")?>
			<?php print $inputs->radio("SHOP_CHARGE_FLG22", "SHOP_CHARGE_FLG2", 2, $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG2") ," 利用不可")?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>事前現金払い</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_CHARGE_FLG3"))?>
			<?php print $inputs->radio("SHOP_CHARGE_FLG31", "SHOP_CHARGE_FLG3", 1, $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG3") ," 利用可")?>
			<?php print $inputs->radio("SHOP_CHARGE_FLG32", "SHOP_CHARGE_FLG3", 2, $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG3") ," 利用不可")?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>事前カード払い</p>
		</th>
		<td align="left">
			<?php print create_error_msg($shop->getErrorByKey("SHOP_CHARGE_FLG4"))?>
			<?php print $inputs->radio("SHOP_CHARGE_FLG41", "SHOP_CHARGE_FLG4", 1, $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG4") ," 利用可")?>
			<?php print $inputs->radio("SHOP_CHARGE_FLG42", "SHOP_CHARGE_FLG4", 2, $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG4") ," 利用不可")?>
		</td>
	</tr>
	<tr id="card_select">
		<th width="160">
			<p>利用可能カード</p>
		</th>
		<td align="left">
			<?php
			$arCard = array();
			$arTemp = explode(":", $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_CARD"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arCard[$data] = $data;
					}
				}
			}
			?>
			<div class="checkboxarea">
			<?php
			$dataCard = cmShopCard();
			if (count($dataCard) > 0) {
				foreach ($dataCard as $k=>$v) {
					$checked = '';
					if ($arCard[$k] != "") {
						$checked = 'checked="checked"';
					}
					?>
						<input type="checkbox" id="card<?php print $k?>" name="card[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="card<?php print $k?>"> <?php print $v?></label>
						<?php
				}
			}
			?>
			</div>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_CHARGE_FLG5", $shop->getByKey($shop->getKeyValue(), "SHOP_CHARGE_FLG5"), "imeActive circle",30,4)?>
		</td>
	</tr>
</table>
<br />


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>安全に関する取組について</h3>
		</th>
	</tr>
	<tr>
		<th width="160">
			<p>体験を始めた時期</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_SEASON", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_SEASON"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>加盟団体名</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_ASSOCIATION", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_ASSOCIATION"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>保有資格</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_PASS", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_PASS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th colspan="3">
			<h3>保険加入・施設賠償保険</h3>
		</th>
	</tr>
	<tr>
		<th width="160">
			<p>施設賠償保険加入有無</p>
		</th>
		<td align="left">
			<div class="checkboxarea">
				<?php print create_error_msg($shop->getErrorByKey("SHOP_SAFETY_FACFLG"))?>
			  	<?php $arData = cmShopJoin();?>
				<?php if (count($arData) > 0) {?>
				<select name="SHOP_SAFETY_FACFLG" class="circle">
					<?php foreach ($arData as $k=>$v) {?>
					<option value="<?php print $k;?>" <?php print ($shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_FACFLG")==$k)?'selected="selected"':''?>><?php print $v;?></option>
					<?php }?>
				</select>
				<?php }?>
			</div>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>施設賠償保険会社</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_FACCOMPANY", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_FACCOMPANY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>施設賠償保険名</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_FACNAME", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_FACNAME"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>施設賠償保険補償金額</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_FACMONEY", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_FACMONEY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>施設賠償保険備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_FACETC", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_FACETC"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th colspan="3">
			<h3>保険加入・傷害保険</h3>
		</th>
	</tr>
	<tr>
		<th width="160">
			<p>傷害保険加入有無</p>
		</th>
		<td align="left">
			<div class="checkboxarea">
				<?php print create_error_msg($shop->getErrorByKey("SHOP_SAFETY_INJFLG"))?>
			  	<?php $arData = cmShopMust();?>
				<?php if (count($arData) > 0) {?>
				<select name="SHOP_SAFETY_INJFLG" class="circle">
					<?php foreach ($arData as $k=>$v) {?>
					<option value="<?php print $k;?>" <?php print ($shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_INJFLG")==$k)?'selected="selected"':''?>><?php print $v;?></option>
					<?php }?>
				</select>
				<?php }?>
			</div>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>傷害保険会社</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_INJCOMPANY", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_INJCOMPANY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>傷害保険名</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_INJNAME", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_INJNAME"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>傷害保険保証金額：死亡</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_INJMONEY1", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_INJMONEY1"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>傷害保険保証金額：入院(日額)</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_INJMONEY2", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_INJMONEY2"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>傷害保険保険料</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_INJFEE", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_INJFEE"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th width="160">
			<p>傷害保険備考</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_INJETC", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_INJETC"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th colspan="3">
			<h3>近隣の病院</h3>
		</th>
	</tr>
	<tr>
		<th width="160">
			<p>最寄り病院名</p>
		</th>
		<td align="left">
			<?=$inputs->textarea("SHOP_SAFETY_HOSPITAL", $shop->getByKey($shop->getKeyValue(), "SHOP_SAFETY_HOSPITAL"), "imeActive circle",30,4)?>
		</td>
	</tr>


</table>
<br />
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th colspan="3">
			<h3>ショップイメージ画像</h3>
		</th>
	</tr>
	<tr>
		<td align="left">
			<table class="inner" cellspacing="10">
				<?php for ($i=1; $i<=6; $i++) {?>
				<tr>
					<th width="160" valign="top">
						<p>画像 <?php print $i;?></p>
					</th>
					<td align="left">
						<?=$inputs->image("SHOP_PIC".$i, $shop->getByKey($shop->getKeyValue(), "SHOP_PIC".$i), IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?>

							<?php if ($hotelPic->getCount() > 0) {?>
							<a href="shopGalleryEdit.html?id=SHOP_PIC<?php print $i?>" class="popup" rel="windowCallUnload"></a>
							<?php print $inputsOnly->text("SHOP_PIC".$i."_setup", $shop->getByKey($shop->getKeyValue(), "SHOP_PIC".$i."_setup") ,"imeDisabled circle wNum",50)?>
							<a href="shopGalleryEdit.html?id=SHOP_PIC<?php print $i?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","設定済写真から選択","circle")?></a>
							<?php }?>

						<br/><br/>
						<p>画像説明文　<?=$inputs->text("SHOP_PIC_TEXT".$i, $shop->getByKey($shop->getKeyValue(), "SHOP_PIC_TEXT".$i), "imeActive circle",100)?></p>

					</td>
				</tr>
				<?php }?>
			</table>
		</td>
	</tr>
	</table>
	<br />


<ul class="buttons">
	<li><?=$inputs->submit("","regist","ショップ基本情報を保存する", "circle")?></li>
</ul>
