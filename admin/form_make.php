<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/form_make.php');

$dbMaster = new dbMaster();

$collection = new collection($db);
$collection->setPost();

$sess = new session($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$xmlArea = new xml(XML_AREA);
$xmlArea->load();
if (!$xmlArea->getXml()) {
	$hotel->setErrorFirst("エリアデータの読み込みに失敗しました");
}

$event = new event($dbMaster);
$event->selectListAdmin($collection);

$eventTarget = new event($dbMaster);

if ($collection->getByKey($collection->getKeyValue(), "regist")) {

	if ($event->getCount() > 0) {
		if (!$eventTarget->statusPublic()) {
			$eventTarget->setErrorFirst("イベントの公開に失敗しました。");
			$eventTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
	else {
	}

}
elseif ($collection->getByKey($collection->getKeyValue(), "disabled")) {

	if ($event->getCount() > 0) {
		if (!$eventTarget->statusDisabled()) {
			$eventTarget->setErrorFirst("イベントの非公開に失敗しました。");
			$eventTarget->setErrorFirst("大変お手数ですが、時間を置いて再度ご登録頂くか、管理者へお問い合わせ下さい。");
		}
	}
	else {
	}
}

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>イベント情報一覧｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">

	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:950,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		},
	};

	function unloadcallback() {
		document.frmSearch.submit();
	};

   	$(function() {
   		$(".popup").popupwindow(profiles);
   	});


	$(document).ready(function(){
		$("#sortList")
		.tablesorter({widthFixed: true, widgets: ['zebra']})
		.tablesorterPager({container: $("#pager")});
	});

   	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body>
	<div id="container">
		<?php require("includes/box/common/header.php");?>
		<div id="contents">
			<div id="contentsData" class="circle">
				<?php require("includes/box/common/mainMenu.php");?>

			<div id="colLeft">

				<div class="datalistHeader circle">
					<table cellspacing="0" border="0" width="100%">
						<tr>
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="ホテル情報一覧" title="ホテル情報一覧" width="40" height="40"  /></td>
							<td valign="middle"><h2>イベント情報一覧</h2></td>
						</tr>
					</table>
				</div>

				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="30"><p>ID</p></th>
							<th><p>イベント名</p></th>
							<th><p>エリア</p></th>
							<th><p>公開期間</p></th>
							<th><p>開催期間</p></th>
							<th><p>公開状況</p></th>
							<th width="50"><p>編集</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($event->getCount() > 0) {?>
							<?php foreach ($event->getCollection() as $ad) {?>
							<?php
							$rclass = '';
							if ($ad["EVENT_STATUS"] == 3) {
								$rclass = 'class="bgLightGrey"';
							}
							?>
						<tr>
							<td <?=$rclass?>><?=$ad["EVENT_ID"]?></td>
							<td <?=$rclass?>><?=$ad["EVENT_NAME"]?></td>
							<td <?=$rclass?>>
							<?php
							$arArea = array();
							$arTemp = explode(":", $ad["EVENT_AREA"]);
							if (count($arTemp) > 0) {
								foreach ($arTemp as $data) {
									if ($data != "") {
										$arArea[$data] = $data;
									}
								}
							}

							if (count($arArea) > 0) {
								foreach ($arArea as $d) {
							?>
							<p><?php print $xmlArea->getNameByValue($d)?></p>
							<?php
								}
							}
							?>
							<td <?=$rclass?>><?=$ad["EVENT_SHOW_FROM"]?>～<?=$ad["EVENT_SHOW_TO"]?></td>
							<td <?=$rclass?>><?=$ad["EVENT_POST_FROM"]?>～<?=$ad["EVENT_POST_TO"]?></td>
							<td <?=$rclass?> align="center">
							<?php if ($event->getByKey($event->getKeyValue(), "EVENT_STATUS") != 3) {?>
								<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
									<?php if ($ad["EVENT_STATUS"] == 2) {?>公開中
										<!--<?=$inputs->submit("","disabled","公開中", "circle")?>-->
									<?php }else {?>非公開
										<!--<?=$inputs->submit("","regist","非公開", "circle")?>-->
									<?php }?>
									<?php print $inputs->hidden("EVENT_ID", $ad["EVENT_ID"])?>
								</form>
							<?php }?>
							</td>
							<td <?=$rclass?> align="center"><a href="eventEdit.html?id=<?=$ad["EVENT_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
						</tr>
							<?php }?>
						<?php }else {?>
						<?php }?>
					</tbody>
				</table>
				<div id="pager" class="pager">
					<form>
						<div class="paging">
							<img src="<?=URL_SLAKER_COMMON?>js/addons/pager/icon/first.png" class="first"/>
							<img src="<?=URL_SLAKER_COMMON?>js/addons/pager/icon/prev.png" class="prev"/>
							<input type="text" class="pagedisplay bgLightGrey circle" readonly="readonly" />
							<img src="<?=URL_SLAKER_COMMON?>js/addons/pager/icon/next.png" class="next"/>
							<img src="<?=URL_SLAKER_COMMON?>js/addons/pager/icon/last.png" class="last"/>
						</div>
						<select class="pagesize circle">
							<option selected="selected"  value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option  value="40">40</option>
						</select>
					</form>
				</div>

			</div>

			<div id="colRight">

				<a href="eventEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しいイベントを登録","circle longButton")?></a>

				<div class="actions circle">
					<h2>イベント検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="70">ID</td>
								<td>
									<?=$inputs->text("EVENT_ID",$collection->getByKey($collection->getKeyValue(),"EVENT_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>イベント名キーワード</td>
								<td>
									<?=$inputs->text("EVENT_TITLE",$collection->getByKey($collection->getKeyValue(),"EVENT_TITLE"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>開催エリア</td>
								<td>
				                                <?php if ($xmlArea->getXml()) {?>
						                        	<select class="select3" id="EVENT_AREA" name="EVENT_AREA">
						                        		<option value="">選択して下さい</option>
						                        	<?php
						                        	foreach ($xmlArea->getXml() as $area) {
														$selected = '';
														if ($collection->getByKey($collection->getKeyValue(), "EVENT_AREA") == "".$area->value) {
															$selected = 'selected="selected"';
														}
													?>
						                        		<option value="<?php print "".$area->value?>" <?php print $selected?>><?php print "".$area->name?></option>
							                        <?php }?>
						                        	</select>
						                <?php }?>
								</td>
							</tr>
							<tr>
								<td>開催日(含む日程がHIT）</td>
								<td>
					                        <?php print $inputs->text("EVENT_POST_FROM", $collection->getByKey($collection->getKeyValue(), "EVENT_POST_FROM") ,"imeDisabled wDateJp")?>
					                        <script type="text/javascript">
					                        	$.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
					                        	$("#EVENT_POST_FROM").datepicker(
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
								</td>
							</tr>

						</table>
						<ul class="buttons">
							<li><?=$inputs->submit("","login","検索", "circle")?></li>
						</ul>
					</form>
				</div>

			</div>
			<br class="clearfix" />

			</div>

		</div>
		<?php
			require("includes/box/common/footer.php");
		?>
	</div>
</body>
</html>