<img src="images/common/title_search.png" width="190" height="35" alt="現在の検索条件">
<section class="searchbox_n form">
    	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="frmResearch" name="frmResearch">
		<div id="searchtable">
            <table>
            <tbody>
                <tr>	
                    <td colspan="3">
                        <B>開催日から探す</B><br/>
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
                        </script><br/>
                        (<?=$inputs->checkbox("undecide_sch","undecide_sch",1,$collection->getByKey($collection->getKeyValue(), "undecide_sch"),"日程未定", "")?>)
                    </td>
                    <td>
                        <B>エリアから探す</B>
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
                    <td>
                        <B>カテゴリで探す</B>
                        <div class="selectbox">
                            <div class="select-inner select3"><span></span></div>
                            	<?php $ar = cmEventCategory();?>
                            	<?php if (count($ar) > 0) {?>
                            	<select id="kind" name="category" class="select3">
                            		<option value="">指定しない</option>
                            		<?php
                            		foreach ($ar as $k=>$v) {
										$selected = '';
										if ($collection->getByKey($collection->getKeyValue(), "category") == $k) {
											$selected = 'selected="selected"';
										}
                            		?>
									<option value="<?php print $k?>" <?php print $selected;?>><?php print $v?></option>
									<?php }?>
								</select>
								<?php }?>
                        </div>
                    </td>
                    <td>
			<B>キーワードで探す</B>
			<div>
				<?php print $inputs->text("free", $collection->getByKey($collection->getKeyValue(), "free") ,"imeActive");?>
			</div>
			</form>

                        </div>
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