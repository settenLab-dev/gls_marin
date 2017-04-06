<?php
$collection->setByKey($collection->getKeyValue(), "limitptn", "side");

$kuchikomi = new kuchikomi($dbMaster);
$kuchikomi->selectSide($collection);
$dspKArray = array();
if ($kuchikomi->getCount() > 0) {
	foreach ($kuchikomi->getCollection() as $kuchidata) {
	//	print_r($kuchidata);
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_ID"] = $kuchidata["KUCHIKOMI_ID"];
	//	$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_POST_FROM"] = $kuchidata["KUCHIKOMI_POST_FROM"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_FACILITY_NAME"] = $kuchidata["KUCHIKOMI_FACILITY_NAME"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_TITLE"] = $kuchidata["KUCHIKOMI_TITLE"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_DETAIL"] = $kuchidata["KUCHIKOMI_DETAIL"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_PIC1"] = $kuchidata["KUCHIKOMI_PIC1"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_AREA"] = $kuchidata["KUCHIKOMI_AREA"];
		$dspKArray[$kuchidata["KUCHIKOMI_ID"]]["KUCHIKOMI_CATEGORY"] = $kuchidata["KUCHIKOMI_CATEGORY"];
	}
}

?>
	<aside id="side_n">
				<div id="title"><img src="./images/front/title2.png" width="220" height="43" alt="クチコミ" /><img src="./images/front/title2-1.png" width="220" height="119" alt="クチコミ" /></div>
					<ul class="side">
					        <?php
					        if (count($dspKArray) > 0) {
								foreach ($dspKArray as $kk) {
								//print_r($kk);
						?>
							<li>
							<a href="/kuchikomi-detail.html?k_id=<?php print $kk["KUCHIKOMI_ID"]?>" target="blank" class="more">
							<?php if ($kk["KUCHIKOMI_PIC1"] != "") {?>
								<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kk["KUCHIKOMI_PIC1"]?>" width="56" height="56" class="l-pic"  alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
							<?php }else{?>
								<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="56" height="56" class="l-pic" alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
							<?php }?>
									<h2><B><?php print cmStrimWidth($kk["KUCHIKOMI_FACILITY_NAME"], 0, 24, '…')?></B></h2>
									<h2><?php print cmStrimWidth($kk["KUCHIKOMI_TITLE"], 0, 66, '…')?>
							</a>
							<a href="/kuchikomi-detail.html?k_id=<?php print $kk["KUCHIKOMI_ID"]?>" target="blank">≫続きを読む</a></h2>
							</li>
					        <?php
								}
						}
						?>
					</ul>
						<div class="more_btn">
						<a href="/kuchikomi-search.html" target="blank"><img src="images/front/kuchikomi_more.png" width="201" height="33"></a>
						</div>
	</aside>
