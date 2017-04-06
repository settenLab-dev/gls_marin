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
	<aside id="side_l">
		        <!--口コミ-->
	        	<section class="kuchikomi">	        		
		        	<h2>おすすめクチコミ</h2>
        <?php if (count($dspKArray) > 0) {
			foreach ($dspKArray as $kk) {
			//print_r($kk);
	?>
			        	<a href="/kuchikomi-detail.html?k_id=<?php print $kk["KUCHIKOMI_ID"]?>">
			        		<ul>
			        			<li>
			        				<p>
									<?php if ($kk["KUCHIKOMI_PIC1"] != "") {?>
										<img src="<?php print URL_SLAKER_COMMON?>images/<?php print $kk["KUCHIKOMI_PIC1"]?>" width="80" height="70" class="fl-l"  alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
									<?php }else{?>
										<img src="<?php print URL_SLAKER_COMMON?>assets/noImage.jpg" width="80" height="70" class="fl-l" alt="<?php print $kk["KUCHIKOMI_TITLE"]?>">
									<?php }?>
								</p>
			        				<dl>
			        					<dt><?php print cmStrimWidth($kk["KUCHIKOMI_FACILITY_NAME"], 0, 20, '…')?></dt>
			        					<dd><?php print cmStrimWidth($kk["KUCHIKOMI_TITLE"], 0, 100, '…')?></dd>
			        					<dd class="link"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> 続きを読む</dd>
			        				</dl>
			        			</li>
			        		</ul>
			        	</a>
        <?php
			}
	}
	?>


		        		<p class="btn"><a href="http://cocotomo.net/kuchikomi-search.html"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> クチコミをもっと見る</a></p>
		        </section>
		        <!--/口コミ-->
	</aside>
