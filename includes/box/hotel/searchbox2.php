<img src="images/common/title_search.png" width="190" height="35" alt="現在の検索条件">
<section class="searchbox_n form">
    <div id="searchafterList">
    	<ul>
    		<li>日付：<span id="txt_room"><?php print $collection->getByKey($collection->getKeyValue(), "search_date")?></span></li>
    		<li>人数：<span id="txt_adult"><?php print $collection->getByKey($collection->getKeyValue(), "priceper_num")?></span>人</li>
	</ul>
    	<div  class="close_bt">
    		<a>検索条件を変更する</a>
    	</div>
    </div>

    	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="frmResearch" name="frmResearch">
		<div id="searchtable">

            <table>
            <tbody>
                <tr>	
                    <td colspan="2">
                        <B>利用日</B>
                        <?php print $inputs->text("search_date", $collection->getByKey($collection->getKeyValue(), "search_date") ,"imeDisabled wDateJp")?>
                        <script type="text/javascript">
                        	$.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
                        	$("#search_date").datepicker(
                        			{
                        				showOn: 'button',
                        				buttonImage: 'images/index/index-search-icon.png',
                        				buttonImageOnly: true,
                        				dateFormat: 'yy年mm月dd日',
                        				changeMonth: true,
                        				changeYear: true,
                        				yearRange: '<?php print date("Y")?>:<?php print date("Y",strtotime("+1 year"))?>',
                        				showMonthAfterYear: true,
                        				monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
                    	                dayNamesMin: ['日','月','火','水','木','金','土']
                    				});
                        </script>
                       <!-- (<?=$inputs->checkbox("undecide_sch","undecide_sch",1,$collection->getByKey($collection->getKeyValue(), "undecide_sch"),"日程未定", "")?>)-->

                        <B>人数</B>
                        <div class="selectbox">
                        	<div class="select-inner select2"><span></span></div>
                        	<select name="priceper_num" id="priceper_num">
                        		<?php
                        		for ($i=1; $i<=99; $i++) {
									$selected = '';
									if ($collection->getByKey($collection->getKeyValue(), "priceper_num") == $i) {
										$selected = 'selected="selected"';
									}
								?>
                                <option valu="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                        		<?php }?>
                            </select>
                        </div>
                        名
                    </td>
<?php /*
                    <td class="w230">
                        <B>エリア</B>
                        <div class="selectbox">
                            <div class="select-inner select3"><span></span></div>
                                <?php if ($xmlArea->getXml()) {?>
		                        	<select class="select3" id="area" name="area">
		                        		<option value="">選択して下さい</option>
		                        	<?php
		                        	foreach ($xmlArea->getXml() as $area) {
										$selected = '';
										if ($collection->getByKey($collection->getKeyValue(), "area") == "".$area->value) {
											$selected = 'selected="selected"';
										}
									?>
		                        		<option value="<?php print "".$area->value?>" <?php print $selected?>><?php print "".$area->name?></option>
			                        <?php }?>
		                        	</select>
		                        <?php }?>
                        </div>
                    </td>

                    <td class="w230">
                        <B>カテゴリ</B>
                        <div class="selectbox">
                            <div class="select-inner select3"><span></span></div>
                                <?php if ($xmlActivityCategory->getXml()) {?>
		                        	<select class="select3" id="area" name="area">
		                        		<option value="">選択して下さい</option>
		                        	<?php
		                        	foreach ($xmlActivityCategory->getXml() as $cate) {
										$selected = '';
										if ($collection->getByKey($collection->getKeyValue(), "category") == "".$cate->value) {
											$selected = 'selected="selected"';
										}
									?>
		                        		<option value="<?php print "".$cate->value?>" <?php print $selected?>><?php print "".$cate->name?></option>
			                        <?php }?>
		                        	</select>
		                        <?php }?>
                        </div>
                    </td>
*/?>
                </tr>
            </tbody>
            </table>
            <div class="bottom">
                <!--<a href="#">⇒こだわり条件を設定する</a>-->
                <div class="btn"><button name="research" value=" ">再検索</button></div>
                <?php print $inputs->hidden("orderdata", $collection->getByKey($collection->getKeyValue(), "orderdata"))?>
            </div>

            </div>
        </form>
    </section>