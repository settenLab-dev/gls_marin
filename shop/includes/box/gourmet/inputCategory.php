<?php if ($groumet->getErrorCount() > 0) {?>
<?php print create_error_caption($groumet->getError())?>
<?php }?>


<table border="0" cellpadding="0" cellspacing="0" class="tblInput" summary="マスタデータ" width="100%">
	<tr>
		<th valign="top" width="160">
			<p>カテゴリ</p>
		</th>
		<td align="left">
			<?php
			$arCategory = array();
			$arTemp = explode(":", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_LIST_CATEGORY"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arCategory[$data] = $data;
					}
				}
			}

			if ($xmlCategory->getXml()) {
				foreach ($xmlCategory->getXml() as $d) {
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
			$arCategoryDetail = array();
			$arTemp = explode(":", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_LIST_CATEGORY_DETAIL"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arCategoryDetail[$data] = $data;
					}
				}
			}

			if ($xmlCategory->getXml()) {
				foreach ($xmlCategory->getXml() as $d) {
					if ("".$d->status != 1) {
						continue;
					}
			?>
			<div id="cBox<?php print "".$d->value?>" class="categorybox dspNon">
				<p><?php print "".$d->name;?></p>
				<?php
				if ($xmlCategoryDetail->getXml()) {
					foreach ($xmlCategoryDetail->getXml() as $dd) {
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
		<th valign="top" width="160">
			<p>特徴</p>
		</th>
		<td align="left">
			<?php
			$arFeature = array();
			$arTemp = explode(":", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_LIST_FEATURE"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arFeature[$data] = $data;
					}
				}
			}

			if ($xmlFeature->getXml()) {
				foreach ($xmlFeature->getXml() as $d) {
					$checked = '';
					if ("".$d->status != 1) {
						continue;
					}
					if ($arFeature["".$d->value] != "") {
						$checked = 'checked="checked"';
					}
			?>
			<input type="checkbox" id="feature<?php print "".$d->value?>" name="feature[<?php print "".$d->value?>]" value="<?php print "".$d->value?>" <?php print $checked;?> <?php print $disabled;?> /><label for="feature<?php print "".$d->value?>"> <?php print "".$d->name?></label>
			<?php
				}
			}
			?>
		</td>
	</tr>
	<tr>
		<th valign="top" width="160">
			<p>エリア</p>
		</th>
		<td align="left">
			<?php
			$arArea = array();
			$arTemp = explode(":", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_LIST_AREA"));
			if (count($arTemp) > 0) {
				foreach ($arTemp as $data) {
					if ($data != "") {
						$arArea[$data] = $data;
					}
				}
			}

			if ($xmlArea->getXml()) {
				foreach ($xmlArea->getXml() as $d) {
					$checked = '';
					if ("".$d->status != 1) {
						continue;
					}
					if ($arArea["".$d->value] != "") {
						$checked = 'checked="checked"';
					}
			?>
			<input type="checkbox" id="area<?php print "".$d->value?>" name="area[<?php print "".$d->value?>]" value="<?php print "".$d->value?>" <?php print $checked;?> <?php print $disabled;?> /><label for="area<?php print "".$d->value?>"> <?php print "".$d->name?></label>
			<?php
				}
			}
			?>
		</td>
	</tr>
</table>
<br />
<?php if ($groumet->getByKey($groumet->getKeyValue(), "GOURMET_STATUS") != 3 and $sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_STATUS") != 3) {?>
<ul class="buttons">
	<li><?=$inputs->submit("","regist","カテゴリ・エリア情報を保存する", "circle")?></li>
</ul>
<?php } else {?>
<p class="colorRed">※現在、編集不可の状態となっています。</p>
<?php }?>