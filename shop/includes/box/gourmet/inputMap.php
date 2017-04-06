<?=create_error_caption($groumet->getError())?>
				<table border="0" cellpadding="0" cellspacing="5" class="" summary="管理者" width="100%">
					<?php
					if ($groumet->getErrorCount() <= 0) {
					?>
					<tr>
						<td colspan="2"><?php print create_error_caption($groumet->getError())?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<th>住所</th>
						<td><?=$groumet_address?></td>
					</tr>
				</table>
				<form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" id="form1" name="form1">
					<?=$inputs->hidden("GOURMET_BASIC_LNG", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_LNG"))?>
					<?=$inputs->hidden("GOURMET_BASIC_LAT", $groumet->getByKey($groumet->getKeyValue(), "GOURMET_BASIC_LAT"))?>

					<div id="map" style="width: 700px; height: 500px"></div>
					<br />

					<ul class="buttons">
						<li><input type="button" name="btn_save" id="btn_save" value="保存する" class="ss_sr circle" /></li>
					</ul>
					<?=$inputs->hidden(constant("groumet::keyName"),$groumet->getKeyValue())?>

				</form>