<?php if ($affiliate->getErrorCount() > 0) {?>
<?php print create_error_caption($affiliate->getError())?>
<?php }
?>
<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th width="160" valign="top">
			<p>サービス名 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_NAME"))?>
			<?php print $inputs->text("AFFILIATE_NAME", $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_NAME") ,"imeActive circle",50)?>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>カテゴリ</p>
		</th>
		<td align="left">
			<?php
			$arCategory = array();
			$arTemp = explode(":", $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_LIST_CATEGORY"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arCategory[$data] = $data;
					}
				}
			}

			if ($xmlAffiliate->getXml()) {
				foreach ($xmlAffiliate->getXml() as $d) {
					$checked = '';
					if ("".$d->status != 1) {
						continue;
					}
					if ($arCategory["".$d->value] != "") {
						$checked = 'checked="checked"';
					}
			?>
			<input type="checkbox" id="category<?php print "".$d->value?>" name="category[<?php print "".$d->value?>]" value="<?php print "".$d->value?>" <?php print $checked;?> <?php print $disabled;?> /><label for="category<?php print "".$d->value?>"> <?php print "".$d->name?></label>
			<script type="text/javascript">
			$(function(){
			    $('#category<?php print "".$d->value?>').click(function(){
				    if(this.checked){
				    $('#cBox<?php print "".$d->value?>').removeClass('dspNon');
				    }else{
				    $('#cBox<?php print "".$d->value?>').addClass('dspNon');
				    }
			  	});
				<?php if ($checked != "") {?>
				$('#cBox<?php print "".$d->value?>').removeClass('dspNon');
				<?php }?>
			});
			</script>
			<?php
				}
			}
			?>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>詳細カテゴリ</p>
		</th>
		<td align="left">
			<?php
// 			print $affiliate->getByKey($affiliate->getKeyValue(), "ACTIVITY_LIST_CATEGORY_DETAIL");
			$arCategoryDetail = array();
			$arTemp = explode(":", $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_LIST_CATEGORY_DETAIL"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arCategoryDetail[$data] = $data;
					}
				}
			}

			if ($xmlAffiliate->getXml()) {
				foreach ($xmlAffiliate->getXml() as $d) {
					if ("".$d->status != 1) {
						continue;
					}
			?>
			<div id="cBox<?php print "".$d->value?>" class="categorybox dspNon">
				<p><?php print "".$d->name;?></p>
				<?php
				if ($xmlAffiliateDetail->getXml()) {
					foreach ($xmlAffiliateDetail->getXml() as $dd) {
						if ("".$d->value != "".$dd->category) {
							continue;
						}
						if ("".$d->status != 1) {
							continue;
						}
						$checked = '';
						if ($arCategoryDetail["".$dd->value] != "") {
							$checked = 'checked="checked"';
						}
				?>
				<input type="checkbox" id="categoryDetail<?php print "".$dd->value?>" name="categoryDetail[<?php print "".$dd->value?>]" value="<?php print "".$dd->value?>" <?php print $checked;?> <?php print $disabled;?> /><label for="categoryDetail<?php print "".$dd->value?>"> <?php print "".$dd->name?></label>
				<?php
					}
				}
				?>
			</div>
			<?php
				}
			}
			?>
		</td>
	</tr>
	<tr>
	<tr>
		<th valign="top">
			<p>キャッチコピー</p>
		</th>
		<td align="left">
			<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_CATCHCOPY"))?>
			<?=$inputs->textarea("AFFILIATE_CATCHCOPY", $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_CATCHCOPY"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>サービス紹介</p>
		</th>
		<td align="left">
			<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_CONTENTS"))?>
			<?=$inputs->textarea("AFFILIATE_CONTENTS", $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_CONTENTS"), "imeActive circle",30,4)?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>リンク先URL</p>
		</th>
		<td align="left">
			<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_URL"))?>
			<?php print $inputs->text("AFFILIATE_URL", $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_URL") ,"imeDisabled circle ",50)?>
		</td>
	</tr>
	<?php for ($i=1; $i<=1; $i++) {?>
	<tr>
		<th width="160" valign="top">
			<p>一覧画像</p>
		</th>
		<td align="left">
			<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_PIC".$i))?>
			<?=$inputs->image("AFFILIATE_PIC".$i, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_PIC".$i), IMG_AFFILIATE_WIDTH, IMG_AFFILIATE_HEIGHT, IMG_AFFILIATE_SIZE, "", 3)?>
		</td>
	</tr>
	<?php }?>
	<?php for ($i=2; $i<=2; $i++) {?>
	<tr>
		<th width="160" valign="top">
			<p>一覧画像<br />マウスオーバー用</p>
		</th>
		<td align="left">
			<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_PIC".$i))?>
			<?=$inputs->image("AFFILIATE_PIC".$i, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_PIC".$i), IMG_AFFILIATE_WIDTH, IMG_AFFILIATE_HEIGHT, IMG_AFFILIATE_SIZE, "", 3)?>
		</td>
	</tr>
	<?php }?>
	<?php /*
	<tr>
		<th valign="top">
			<p>アフィリエイト金額フラグ</p>
		</th>
		<td align="left">
			<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_FLG"))?>
			<?php print $inputs->radio("AFFILIATE_FLG1", "AFFILIATE_FLG", 1, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_FLG") ," 固定金額")?>
			<?php print $inputs->radio("AFFILIATE_FLG2", "AFFILIATE_FLG", 2, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_FLG") ," サービス金額の％")?>
		</td>
	</tr>
	<tr>
		<th valign="top">
			<p>アフィリエイト金額率 <span class="colorRed">※</span></p>
		</th>
		<td align="left">
			<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_BACK"))?>
			<?php print $inputs->text("AFFILIATE_BACK", $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_BACK") ,"imeDisabled circle wNum",50)?>
		</td>
	</tr>
	*/?>
	<?php for ($i=1; $i<=3; $i++) {?>
	<tr>
		<th width="160" valign="top">
			<p>ポイント付与設定<?php print $i?></p>
			<?php if ($i == 1) {?>
			<span class="colorRed">※</span>
			<?php }?>
		</th>
		<td align="left">
			<table class="inner">
				<tr>
					<th>ポイント付与条件</th>
					<td>
					<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_POINT_TERMS".$i))?>
					<?=$inputs->textarea("AFFILIATE_POINT_TERMS".$i, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_POINT_TERMS".$i), "imeActive circle",30,4)?>
					</td>
				</tr>
				<tr>
					<th>ポイントフラグ</th>
					<td>
					<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_POINT_FLG".$i))?>
					<?php print $inputs->radio("AFFILIATE_POINT_FLG1".$i, "AFFILIATE_POINT_FLG".$i, 1, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_POINT_FLG".$i) ," 固定金額")?>
					<?php print $inputs->radio("AFFILIATE_POINT_FLG2".$i, "AFFILIATE_POINT_FLG".$i, 2, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_POINT_FLG".$i) ," サービス金額の％")?>
					</td>
				</tr>
				<tr>
					<th>ポイント還元率</th>
					<td>
					<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_POINT_BACK".$i))?>
					<?php print $inputs->text("AFFILIATE_POINT_BACK".$i, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_POINT_BACK".$i) ,"imeDisabled circle wNum",50)?>
					</td>
				</tr>
				<tr>
					<th>ポイント付与時期</th>
					<td>
					<?php print create_error_msg($affiliate->getErrorByKey("AFFILIATE_POINT_TIME".$i))?>
					<?php print $inputs->text("AFFILIATE_POINT_TIME".$i, $affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_POINT_TIME".$i) ,"imeDisabled circle wNum",50)?> ヶ月後
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }?>
</table>
<br />

<?php if ($affiliate->getByKey($affiliate->getKeyValue(), "AFFILIATE_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","アフィリエイト情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>

<?php print $inputs->hidden(constant("affiliate::keyName"), $affiliate->getKeyValue())?>
