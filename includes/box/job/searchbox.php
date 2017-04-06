<img src="images/common/title_search.png" width="190" height="35" alt="現在の検索条件">
<section class="searchbox_n form">
    <div id="searchafterList">
    	<ul>
    		<li>部屋数：<span id="txt_room"><?php print $collection->getByKey($collection->getKeyValue(), "room_number")?></span>室</li>
    		<li>大人：<span id="txt_adult"></span>人</li>
    		<li>小学生高学年：<span id="txt_child1"></span>人</li>
    		<li>小学生高学年：<span id="txt_child2"></span>人</li>
    		<li>幼児：<span id="txt_child3"></span>人</li>
    	</ul>
    	<!--<div  class="close_bt">
    		<a>検索条件を変更する</a>
    	</div>-->
    </div>

    	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="frmResearch" name="frmResearch">
		<div id="searchtable">
	    	<!--<div class="close_bt">
    			<a>Close</a>
    		</div>-->

            <table>
            <tbody>
                <tr>
                    <td><B><img src="./images/job/jobsearch_01.png"></B>選択中のエリア⇒</br>
                        <!--<B>那覇・南部エリア</B></br>-->
				<?php
				$arArea = array();
				$arTemp = $collection->getByKey($collection->getKeyValue(), "area");
				if (count($arTemp) > 0) {
					foreach ($arTemp as $key => $value) {
						if ($key != "") {
							$arArea[$key] = $key;
						}
					}
				}
				?>
				<?php
				$dataArea = cmJobArea();
				$cnt = 0;
				if (count($dataArea) > 0) {
					foreach ($dataArea as $k=>$v) {
						$cnt++;
						if ($cnt > 27) {
							break;
						}
						$checked = '';
						if ($arArea[$k] != "") {
							$checked = 'checked="checked"';
						}
						if ($k>=1 && $k<=1){
						?>
							<input type="checkbox" id="area<?php print $k?>" name="area[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="area<?php print $k?>"> <?php print $v?></label>
							<?php
						}
					}
				}
				?> 
                        <!--</br><B>中部エリア</B></br>-->
				<?php
				$dataArea = cmJobArea();
				$cnt = 0;
				if (count($dataArea) > 0) {
					foreach ($dataArea as $k=>$v) {
						$cnt++;
						if ($cnt > 27) {
							break;
						}
						$checked = '';
						if ($arArea[$k] != "") {
							$checked = 'checked="checked"';
						}
						if ($k>=2 && $k<=2){
						?>
							<input type="checkbox" id="area<?php print $k?>" name="area[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="area<?php print $k?>"> <?php print $v?></label>
							<?php
						}
					}
				}
				?> 
                        <!--</br><B>北部エリア</B></br>-->
				<?php
				$dataArea = cmJobArea();
				$cnt = 0;
				if (count($dataArea) > 0) {
					foreach ($dataArea as $k=>$v) {
						$cnt++;
						if ($cnt > 27) {
							break;
						}
						$checked = '';
						if ($arArea[$k] != "") {
							$checked = 'checked="checked"';
						}
						if ($k>=3 && $k<=3){
						?>
							<input type="checkbox" id="area<?php print $k?>" name="area[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="area<?php print $k?>"> <?php print $v?></label>
							<?php
						}
					}
				}
				?>  
                        <!--</br><B>離島エリア</B></br>-->
				<?php
				$dataArea = cmJobArea();
				$cnt = 0;
				if (count($dataArea) > 0) {
					foreach ($dataArea as $k=>$v) {
						$cnt++;
						if ($cnt > 27) {
							break;
						}
						$checked = '';
						if ($arArea[$k] != "") {
							$checked = 'checked="checked"';
						}
						if ($k>=4 && $k<=4){
						?>
							<input type="checkbox" id="area<?php print $k?>" name="area[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="area<?php print $k?>"> <?php print $v?></label>
							<?php
						}
					}
				}
				?>  

                    </td>
		</tr>
		<tr>
                    <!--<td class="w230">-->
			<td>
                        <B><img src="./images/job/jobsearch_02.png"></B><br/>
                        <div class="selectbox">
				<?php
				$arSeason = array();
				$arTemp = $collection->getByKey($collection->getKeyValue(), "season");
				if (count($arTemp) > 0) {
					foreach ($arTemp as $key => $value) {
						if ($key != "") {
							$arSeason[$key] = $key;
						}
					}
				}
				?>
				<?php
				$dataSeason = cmJobSeason();
				$cnt = 0;
				if (count($dataSeason) > 0) {
					foreach ($dataSeason as $k=>$v) {
						$cnt++;
						if ($cnt > 4) {
							break;
						}
						$checked = '';
						if ($arSeason[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="season<?php print $k?>" name="season[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="season<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?>
                        </div>
                    </td>
		</tr>
		<tr>
                    <td>
                        <B><img src="./images/job/jobsearch_03.png"></B><br/>
				<?php
				$arEmploy = array();
				$arTemp = $collection->getByKey($collection->getKeyValue(), "employ");
				if (count($arTemp) > 0) {
					foreach ($arTemp as $key => $value) {
						if ($key != "") {
							$arEmploy[$key] = $key;
						}
					}
				}
				?>
				<?php
				$dataEmploy = cmJobEmploy();
				$cnt = 0;
				if (count($dataEmploy) > 0) {
					foreach ($dataEmploy as $k=>$v) {
						$cnt++;
						if ($cnt > 4) {
							break;
						}
						$checked = '';
						if ($arEmploy[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="employ<?php print $k?>" name="employ[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="employ<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <B><img src="./images/job/jobsearch_04.png"></B><br/>
                        <div class="selectbox">
				<?php
				$arKind = array();
				$arTemp = $collection->getByKey($collection->getKeyValue(), "kind");
				if (count($arTemp) > 0) {
					foreach ($arTemp as $key => $value) {
						if ($key != "") {
							$arKind[$key] = $key;
						}
					}
				}
				?>
				<?php
				$dataKind = cmJobKind();
				$cnt = 0;
				if (count($dataKind) > 0) {
					foreach ($dataKind as $k=>$v) {
						$cnt++;
						if ($cnt > 12) {
							break;
						}
						$checked = '';
						if ($arKind[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="kind<?php print $k?>" name="kind[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="kind<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?>                        </div>
                    </td>
		</tr>
		<tr>
                    <!--<td class="w265">-->
			<td>
                        <B><img src="./images/job/jobsearch_05.png"></B><br/>
                        <div class="selectbox">
				<?php
				$arCompany = array();
				$arTemp = $collection->getByKey($collection->getKeyValue(), "company");
				if (count($arTemp) > 0) {
					foreach ($arTemp as $key => $value) {
						if ($key != "") {
							$arCompany[$key] = $key;
						}
					}
				}
				?>
				<?php
				$dataCompany = cmJobCompany();
				$cnt = 0;
				if (count($dataCompany) > 0) {
					foreach ($dataCompany as $k=>$v) {
						$cnt++;
						if ($cnt > 11) {
							break;
						}
						$checked = '';
						if ($arCompany[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="company<?php print $k?>" name="company[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="company<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?>
                        </div>
                    </td>
		</tr>
		<tr>
                    <td>
                        <B><img src="./images/job/jobsearch_06.png"></B><br/>
				<?php
				$arIcon = array();
				$arTemp = $collection->getByKey($collection->getKeyValue(), "icon");
				if (count($arTemp) > 0) {
					foreach ($arTemp as $key => $value) {
						if ($key != "") {
							$arIcon[$key] = $key;
						}
					}
				}
				?>
				<?php
				$dataIcon = cmJobIcon();
				$cnt = 0;
				if (count($dataIcon) > 0) {
					foreach ($dataIcon as $k=>$v) {
						$cnt++;
						if ($cnt > 19) {
							break;
						}
						$checked = '';
						if ($arIcon[$k] != "") {
							$checked = 'checked="checked"';
						}
						?>
							<input type="checkbox" id="icon<?php print $k?>" name="icon[<?php print $k?>]" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="icon<?php print $k?>"> <?php print $v?></label>
							<?php
					}
				}
				?>
                    </td>
                </tr>
            </tbody>
            </table>
            <div class="bottom">
                <div class="btn"><button name="research" value=" ">再検索</button></div>
                <?php print $inputs->hidden("orderdata", $collection->getByKey($collection->getKeyValue(), "orderdata"))?>
            </div>

            </div>
        </form>
    </section>