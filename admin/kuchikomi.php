<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/kuchikomi.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/shop.php');

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

$admin = new admin($dbMaster);
$admin->select($sess->getSessionByKey($sess->getSessionLogninKey(), "ADMIN_ID"));

$kuchikomi = new kuchikomi($dbMaster);
$kuchikomi->selectListAdmin($collection);

$shop = new shop($dbMaster);
$shop->selectList($collection);




$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>レポート一覧｜<?=SITE_SLAKER_NAME?></title>
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
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="レポート一覧" title="ホテル情報一覧" width="40" height="40"  /></td>
							<td valign="middle"><h2>レポート一覧</h2></td>
						</tr>
					</table>
				</div>

				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="30"><p>ID</p></th>
							<th><p>施設名</p></th>
							<th><p>利用日</p></th>
							<th><p>投稿者</p></th>
							<th><p>承認</p></th>
							<th><p>公開状況</p></th>
							<th width="50"><p>編集</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($kuchikomi->getCount() > 0) {?>
							<?php foreach ($kuchikomi->getCollection() as $ad) {?>
							<?php //print_r($ad);
							$rclass = '';
							if ($ad["KUCHIKOMI_STATUS"] == 3) {
								$rclass = 'class="bgLightGrey"';
							}
							?>
						<tr>
							<td <?=$rclass?>><?=$ad["KUCHIKOMI_ID"]?></td>
							<td <?=$rclass?>><?=$ad["SHOP_NAME"]?></td>
							<td <?=$rclass?>><?=$ad["KUCHIKOMI_USE_DATE"]?></td>
							<td <?=$rclass?>><?=$ad["KUCHIKOMI_NAME"]?></td>
							<td <?=$rclass?>>

								店舗：
								<?php if ($ad["KUCHIKOMI_APPROV_SHOP"] == 1) {?>
									<font color="#ff0000">未承認</font>
								<?php }elseif ($ad["KUCHIKOMI_APPROV_SHOP"] == 2) {?>
									承認済
								<?php }?>
								<br/>
								管理：
								<?php if ($ad["KUCHIKOMI_APPROV_ADMIN"] == 1) {?>
									<font color="#ff0000">未承認</font>
								<?php }elseif ($ad["KUCHIKOMI_APPROV_ADMIN"] == 2) {?>
									承認済
								<?php }?>
							</td>
							<td <?=$rclass?> align="center">
							<?php if ($kuchikomi->getByKey($kuchikomi->getKeyValue(), "KUCHIKOMI_STATUS") != 3) {?>
								<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
									<?php if ($ad["KUCHIKOMI_STATUS"] == 2) {?>公開中
										<!--<?=$inputs->submit("","disabled","公開中", "circle")?>-->
									<?php }else {?>非公開
										<!--<?=$inputs->submit("","regist","非公開", "circle")?>-->
									<?php }?>
									<?php print $inputs->hidden("KUCHIKOMI_ID", $ad["KUCHIKOMI_ID"])?>
								</form>
							<?php }?>
							</td>
							<td <?=$rclass?> align="center"><a href="kuchikomiEdit.html?id=<?=$ad["KUCHIKOMI_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
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

				<a href="kuchikomiEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しいクチコミを登録","circle longButton")?></a>

				<div class="actions circle">
					<h2>クチコミ検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="70">ID</td>
								<td>
									<?=$inputs->text("KUCHIKOMI_ID",$collection->getByKey($collection->getKeyValue(),"KUCHIKOMI_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>タイトルキーワード</td>
								<td>
									<?=$inputs->text("KUCHIKOMI_TITLE",$collection->getByKey($collection->getKeyValue(),"KUCHIKOMI_TITLE"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>施設名</td>
								<td>
									<?=$inputs->text("KUCHIKOMI_FACILITY_NAME",$collection->getByKey($collection->getKeyValue(),"EVENT_AREA"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>利用日</td>
								<td>
					                        <?php print $inputs->text("KUCHIKOMI_USE_DATE", $collection->getByKey($collection->getKeyValue(), "KUCHIKOMI_USE_DATE") ,"imeDisabled wDateJp")?>
					                        <script type="text/javascript">
					                        	$.datepicker.setDefaults($.extend($.datepicker.regional['ja']));
					                        	$("#KUCHIKOMI_USE_DATE").datepicker(
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