<!--<img src="images/common/title_search.png" width="190" height="35" alt="現在の検索条件">-->
<section class="searchbox_n form">
    	<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" id="frmResearch" name="frmResearch">
		<div id="searchtable">
            <table>
            <tbody>
                <tr>
                    <td class="w265">
                        <B>カテゴリで探す</B>
                        <div class="selectbox">
                            <div class="select-inner select3"><span></span></div>
                            	<?php $ar = cmKuchikomiCategory();?>
                            	<?php if (count($ar) > 0) {?>
                            	<select id="category" name="category" class="select3">
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
                    <td class="w265">
                        <B>エリアで探す</B>
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
                    <td class="w265">
			<B>キーワードで探す</B>
			<div class="selectbox">
				<?php print $inputs->text("free", $collection->getByKey($collection->getKeyValue(), "free") ,"imeActive");?>
			</div>
			</form>

                        </div>
                    </td>
                </tr>

            </tbody>
            </table>
            <div class="bottom">
                <div class="btn"><button name="research" value=" ">検索</button></div>
                <?php print $inputs->hidden("orderdata", $collection->getByKey($collection->getKeyValue(), "orderdata"))?>
            </div>

            </div>
        </form>
    </section>