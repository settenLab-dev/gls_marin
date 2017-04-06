<?=create_error_caption($activity->getError())?>
				<table border="0" cellpadding="0" cellspacing="5" class="" summary="管理者" width="100%">
					<?php
					if ($activity->getErrorCount() <= 0) {
					?>
					<tr>
						<td colspan="2"><?php print create_error_caption($activity->getError())?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<th>住所</th>
						<td><?=$activity_address?></td>
					</tr>
				</table>
				<form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" id="form1" name="form1">
					<?=$inputs->hidden("ACTIVITY_BASIC_LNG", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_LNG"))?>
					<?=$inputs->hidden("ACTIVITY_BASIC_LAT", $activity->getByKey($activity->getKeyValue(), "ACTIVITY_BASIC_LAT"))?>

					<div id="map" style="width: 700px; height: 500px"></div>
					<br />

					<ul class="buttons">
						<li><input type="button" name="btn_save" id="btn_save" value="保存する" class="ss_sr circle" /></li>
					</ul>
					<?=$inputs->hidden(constant("activity::keyName"),$activity->getKeyValue())?>

				</form>