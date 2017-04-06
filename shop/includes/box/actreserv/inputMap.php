<?=create_error_caption($hotel->getError())?>
				<table border="0" cellpadding="0" cellspacing="5" class="" summary="管理者" width="100%">
					<?php
					if ($hotel->getErrorCount() <= 0) {
					?>
					<tr>
						<td colspan="2"><?php print create_error_caption($hotel->getError())?></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<th>住所</th>
						<td><?=$hotel_address?></td>
					</tr>
				</table>
				<form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" id="form1" name="form1">
					<?=$inputs->hidden("HOTEL_LON", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_LON"))?>
					<?=$inputs->hidden("HOTEL_LAT", $hotel->getByKey($hotel->getKeyValue(), "HOTEL_LAT"))?>

					<div id="map" style="width: 700px; height: 500px"></div>
					<br />

					<ul class="buttons">
						<li><input type="button" name="btn_save" id="btn_save" value="保存する" class="ss_sr circle" /></li>
					</ul>
					<?=$inputs->hidden(constant("hotel::keyName"),$hotel->getKeyValue())?>

				</form>