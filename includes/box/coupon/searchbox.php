<img src="images/common/title_search.png" width="190" height="35" alt="現在の検索条件">
<section class="searchbox_n form">
    <div id="searchafterList">
    	<ul>
    		<li>部屋数：<span id="txt_room"><?php print $collection->getByKey($collection->getKeyValue(), "room_number")?></span>室</li>
    		<li>大人：<span id="txt_adult"></span>人</li>
    		<li>小学生高学年：<span id="txt_child1">0</span>人</li>
    		<li>小学生高学年：<span id="txt_child2">2</span>人</li>
    		<li>幼児：<span id="txt_child3">0</span>人</li>
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
                    <td colspan="2">
                        <B>宿泊日</B>
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
                        日から
                        &nbsp;
                        <div class="selectbox">
                        	<div class="select-inner select2"><span></span></div>
                        	<select name="night_number" id="night_number">
                        		<?php
                        		for ($i=1; $i<=SITE_STAY_NUM; $i++) {
									$selected = '';
									if ($collection->getByKey($collection->getKeyValue(), "night_number") == $i) {
										$selected = 'selected="selected"';
									}
								?>
                                <option valu="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                        		<?php }?>
                            </select>
                        </div>
                        泊
                    </td>
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
                </tr>
                <tr>
                    <td colspan="3">
<!--
                        <div class="number"><B>部屋数</B>
                        <div class="selectbox">
                            <div class="select-inner select2"><span></span></div>
                            <select name="room_number" id="room_number" class="select2">
                        		<?php
                        		for ($i=1; $i<=SITE_ROOM_NUM; $i++) {
									$selected = '';
									if ($collection->getByKey($collection->getKeyValue(), "room_number") == $i) {
										$selected = 'selected="selected"';
									}
								?>
                                <option valu="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
                        		<?php }?>
                            </select>
                        </div>
                        室</div>
-->
                        <?php for ($roomNum=1; $roomNum<=SITE_ROOM_NUM; $roomNum++) { ?>
                        <table id="datainput<?php print $roomNum?>" class="inner datainputset dspNon" style="font-size: 11px;">
                        <tbody>
                            <tr class="first">
                                <th rowspan="3"><?php print $roomNum?>部屋目</th>
                                <td class="first">
                                大人
                                <div class="selectbox">
                                <?php $selected='';?>
                                	<div class="select-inner select2"><span></span></div>
	                                <select id="adult_number<?php print $roomNum?>" name="adult_number<?php print $roomNum?>" class="select2 adultset">
										<?php
										for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
											if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == $i) {
												$selected = 'selected="selected"';
											}
										}
										if ($selected == 'selected="selected"') {
											for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
												$selected = '';
												if ($collection->getByKey($collection->getKeyValue(), "adult_number".$roomNum) == $i) {
													$selected = 'selected="selected"';
												}
												?>
												<option value="<?php print $i?>" <?php print $selected?>><?php print $i?><?php print ($i==9)?'～':''?></option>
												<?php }
												}else{
										for ($i=1; $i<=SITE_ADULT_NUM; $i++) {
											$selected = '';
											if (2 == $i) {
												$selected = 'selected="selected"';
												}
											
										?>
										<option value="<?php print $i?>" <?php print $selected?>><?php print $i?><?php print ($i==9)?'～':''?></option>
										<?php }
										}
										?>
									</select>

								</div>
                                人
                                </td>
                                <td>
                                小学生低学年
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                 <select id="child_number<?php print $roomNum?>1>" name="child_number<?php print $roomNum?>1" class="select2 childset1">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
								</div>
                                <?php /*
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>1>" name="child_number<?php print $roomNum?>1" class="select2 childset1">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."1") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                */?>
                                人
                                </td>
                                <td>
                                小学生高学年
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>2>" name="child_number<?php print $roomNum?>2" class="select2 childset2">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."2") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td>
                           </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                幼児<span>（食事・布団あり)</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>3>" name="child_number<?php print $roomNum?>3" class="select2 childset3">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."3") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td>
                                <td>
                                幼児<span>（食事のみ）</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>4>" name="child_number<?php print $roomNum?>4" class="select2 childset3">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."4") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td>
                           </tr>
                            <tr class="last">
                                <td>
                                </td>
                                <td>
                                幼児<span>（布団のみ）</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>5>" name="child_number<?php print $roomNum?>5" class="select2 childset3">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."5") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td>
                                <td>
                                幼児<span>（食事・布団なし）</span>
                                <div class="selectbox">
                                    <div class="select-inner select2"><span></span></div>
                                    <select id="child_number<?php print $roomNum?>6>" name="child_number<?php print $roomNum?>6" class="select2 childset3">
										<option value="0">0</option>
										<?php
										for ($i=1; $i<=SITE_CHILD_NUM; $i++) {
											$selected = '';
											if ($collection->getByKey($collection->getKeyValue(), "child_number".$roomNum."6") == $i) {
												$selected = 'selected="selected"';
											}
										?>
										<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
										<?php }?>
									</select>
                                </div>
                                人
                                </td>
                           </tr>
                       </tbody>
                       </table>
                       <?php }?>

                      		 <script type="text/javascript">
	                            $(document).ready(function(){
	                            	$("#room_number").change(function () {
	                            		roomChange();
	                            	});
	                            	roomChange();


	                            	$(".adultset").change(function () {
	                            		setTextAdult();
								    });
									$(".childset1").change(function () {
										//alert(""+$(this).val());
										setTextChild1();
								    });
									$(".childset2").change(function () {
										setTextChild2();
								    });
									$(".childset3").change(function () {
										setTextChild3();
								    });
									setTextAdult();
									setTextChild1();
									setTextChild2();
									setTextChild3();
	                            });

	                            function roomChange() {
	                            	var i;
	                            	$('.datainputset').addClass('dspNon');
	                            	for (i = 1; i <= parseInt($('#room_number').val()); i = i +1){
	                            		$('#datainput'+i).removeClass('dspNon');
	                            	}
	                            	$("#txt_room").text($('#room_number').val());

	                            	var setAdult = 0;
	                            	var setChild = 0;
	                            }

	                            function setTextAdult() {
		                            var total = 0;
									for (i = 1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
	                            			if (parseInt($('select[name="adult_number'+i+'"]').val()) != '') {
	                            				total = total + parseInt($('select[name="adult_number'+i+'"]').val());
	                            			}
									}
									$("#txt_adult").text(total);
	                            }
	                            function setTextChild1() {
	                            	var total=0;

	                            	var i;
	                            	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
	                        			if ($('select[name="child_number'+i+'1"]').val() != '') {
	                        				total = total + parseInt($('select[name="child_number'+i+'1"]').val());
                        				}
	                            	}
									$("#txt_child1").text(total);
	                            }
	                            function setTextChild2() {
	                            	var total=0;

	                            	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
	                            		if ($('select[name="child_number'+i+'2"]').val() != '') {
	                        				total = total + parseInt($('select[name="child_number'+i+'2"]').val());
                        				}
	                            	}
									$("#txt_child2").text(total);
	                            }
	                            function setTextChild3() {
	                            	var total=0;
	                            	var child;

	                            	for (i =1; i <=parseInt($('select[name="room_number"]').val()); i = i +1){
										for (child = 3; child<=6; child=child +1){
		                            		if ($('select[name="child_number'+i+child+'"]').val() != '') {
		                        				total = total + parseInt($('select[name="child_number'+i+child+'"]').val());
	                        				}
		                            	}
	                            	}

									$("#txt_child3").text(total);
	                            }
	                            </script>

                    </td>
                </tr>
                <tr>
                    <td class="w265">
                        <B>施設のタイプ</B>
                        <div class="selectbox">
                            <div class="select-inner select3"><span></span></div>
                            	<?php $ar = cmHotelKind();?>
                            	<?php if (count($ar) > 0) {?>
                            	<select id="kind" name="kind" class="select3">
                            		<option value="">指定しない</option>
                            		<?php
                            		foreach ($ar as $k=>$v) {
										$selected = '';
										if ($collection->getByKey($collection->getKeyValue(), "kind") == $k) {
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
                        <B>部屋のタイプ</B>
                        <div class="selectbox">
                            <div class="select-inner select3"><span></span></div>
                            	<?php $ar = cmHotelRoomType();?>
                            	<?php if (count($ar) > 0) {?>
                            	<select id="room_type" name="room_type" class="select3">
                            		<option value="">指定しない</option>
                            		<?php
                            		foreach ($ar as $k=>$v) {
										$selected = '';
										if ($collection->getByKey($collection->getKeyValue(), "room_type") == $k) {
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
                        <B>お食事</B>
                        <?php
						$dataMeal = cmMeal();
						if (count($dataMeal) > 0) {
						?>
						<?php
							foreach ($dataMeal as $k=>$v) {
								if ($k == "") {
									continue;
								}
								$checked = '';
								if ($collection->getByKey($collection->getKeyValue(), "meal".$k) == $k) {
									$checked = 'checked="checked"';
								}
								?>
									<input type="checkbox" id="meal<?php print $k?>" name="meal<?php print $k?>" value="<?php print $k?>" <?php print $checked;?> <?php print $disabled;?> /><label for="meal<?php print $k?>"> <?php print $v?></label>
									<?php
							}
						?>
						<?php
						}
						?>
                        <?php /*
                        <div class="selectbox">
                            <div class="select-inner select3"><span></span></div>
                            <?php $ar = cmMeal();?>
                            	<?php if (count($ar) > 0) {?>
                            	<select id="meal" name="meal" class="select3">
                            		<option value="">指定しない</option>
                            		<?php
                            		foreach ($ar as $k=>$v) {
										$selected = '';
										if ($collection->getByKey($collection->getKeyValue(), "meal") == $k) {
											$selected = 'selected="selected"';
										}
                            		?>
									<option value="<?php print $k?>" <?php print $selected;?>><?php print $v?></option>
									<?php }?>
								</select>
								<?php }?>
                        </div>
                        */?>
                    </td>
                </tr>
                <tr>
                    <!--<td colspan="2">
                        予算
                        <div class="selectbox">
                            <div class="select-inner select4"><span></span></div>
                            <?php $ar = cmBudget(1);?>
                            <?php if (count($ar) > 0) {?>
                            <select id="budget_from" name="budget_from" class="select4">
                            	<?php
                            	foreach ($ar as $k=>$v) {
									$selected = '';
									if ($collection->getByKey($collection->getKeyValue(), "budget_from") == $k) {
										$selected = 'selected="selected"';
									}
                            	?>
							<option value="<?php print $k?>" <?php print $selected;?>><?php print $v?></option>
							<?php }?>
							</select>
							<?php }?>
                        </div>
                        ～
                        <div class="selectbox">
                            <div class="select-inner select4"><span></span></div>
                            <?php $ar = cmBudget(2);?>
                            <?php if (count($ar) > 0) {?>
                            <select id="budget_to" name="budget_to" class="select4">
                            	<?php
                            	foreach ($ar as $k=>$v) {
									$selected = '';
									if ($collection->getByKey($collection->getKeyValue(), "budget_to") == $k) {
										$selected = 'selected="selected"';
									}
                            	?>
							<option value="<?php print $k?>" <?php print $selected;?>><?php print $v?></option>
							<?php }?>
							</select>
							<?php }?>
                        </div>
                    </td>-->
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