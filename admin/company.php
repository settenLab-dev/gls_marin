<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/admin.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/mContract.php');

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


$collection2 = new collection($dbMaster);
$mContract = new mContract($dbMaster);
$mContract->selectList($collection2);

$company = new company($dbMaster);
$company->selectList($collection);

$inputs = new inputs();


if ($collection->getByKey($collection->getKeyValue(), "search")) {
}
else {
	$collection->setByKey($collection->getKeyValue(), "COMPANY_STATUS1", 1);
	$collection->setByKey($collection->getKeyValue(), "COMPANY_STATUS2", 2);
}

?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>契約アカウント一覧｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">

	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:850,
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
							<td width="50" valign="middle"><img src="<?=URL_SLAKER_COMMON?>assets/top/system.png" alt="契約アカウント一覧" title="契約アカウント一覧" width="40" height="40"  /></td>
							<td valign="middle"><h2>契約アカウント一覧</h2></td>
						</tr>
					</table>
				</div>

				<table cellspacing="0" cellpadding="5" class="tablesorter" id="sortList" width="740">
					<thead>
						<tr>
							<th width="30"><p>ID</p></th>
							<th><p>ｱｶｳﾝﾄ名</p></th>
							<th><p>ﾒｰﾙｱﾄﾞﾚｽ</p></th>
							<th width="60"><p>tel</p></th>
							<th><p>契約ﾌﾟﾗﾝ</p></th>
							<th width="70"><p>契約満了日</p></th>
							<th width="50"><p>編集</p></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($company->getCount() > 0) {?>
							<?php foreach ($company->getCollection() as $ad) {?>
							<?php
							$rclass = '';
							if ($ad["COMPANY_STATUS"] == 4) {
								$rclass = 'class="bgLightGrey"';
							}
							?>
						<tr>
							<td <?=$rclass?>><?=$ad["COMPANY_ID"]?></td>
							<td <?=$rclass?>><?=$ad["COMPANY_NAME"]." ".$ad["COMPANY_SHOP_NAME"]?></td>
							<td <?=$rclass?>><?=$ad["COMPANY_MAIL"]?></td>
							<td <?=$rclass?>><?=$ad["COMPANY_TEL1"]?></td>
							<td <?=$rclass?>><?=$ad["COMPANY_CONTRACT_NAME"]?></td>
							<td <?=$rclass?>><?=$ad["COMPANY_CONTRACT_DATE_END"]?></td>
							<td <?=$rclass?> align="center"><a href="companyEdit.html?id=<?=$ad["COMPANY_ID"]?>" class="popup" rel="windowCallUnload"><?=$inputs->button("","","編集","circle")?></a></td>
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
					<a href="companyEdit.html" class="popup" rel="windowCallUnload"><?=$inputs->button("","","新しい契約アカウント","circle longButton")?></a>

				<div class="actions circle">
					<h2>検索</h2>
					<form id="frmSearch" name="frmSearch" action="<?=$_SERVER['REQUEST_URI']?>" method="post">
						<table cellspacing="10">
							<tr>
								<td width="70">ID</td>
								<td>
									<?=$inputs->text("COMPANY_ID",$collection->getByKey($collection->getKeyValue(),"COMPANY_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>企業名</td>
								<td>
									<?=$inputs->text("COMPANY_NAME",$collection->getByKey($collection->getKeyValue(),"COMPANY_NAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>企業名(ｶﾅ)</td>
								<td>
									<?=$inputs->text("COMPANY_NAME_KANA",$collection->getByKey($collection->getKeyValue(),"COMPANY_NAME_KANA"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>店舗名</td>
								<td>
									<?=$inputs->text("COMPANY_SHOP_NAME",$collection->getByKey($collection->getKeyValue(),"COMPANY_SHOP_NAME"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>店舗名(ｶﾅ)</td>
								<td>
									<?=$inputs->text("COMPANY_SHOP_NAME_KANA",$collection->getByKey($collection->getKeyValue(),"COMPANY_SHOP_NAME_KANA"),"imeActive circle",30)?>
								</td>
							</tr>
							<tr>
								<td>mail</td>
								<td>
									<?=$inputs->text("COMPANY_LOGIN_ID",$collection->getByKey($collection->getKeyValue(),"COMPANY_LOGIN_ID"),"imeDisabled circle",30)?>
								</td>
							</tr>
							<tr>
								<td>契約プラン</td>
								<td>
									<?php if ($mContract->getCollection() > 0) {?>
									<p><select name="M_CONTRACT_ID" id="M_CONTRACT_ID" class="circle">
										<option value="">---</option>
										<?php foreach ($mContract->getCollection() as $v) {?>
										<option value="<?php print $v["M_CONTRACT_ID"]?>" <?php print ($collection->getByKey($collection->getKeyValue(), "M_CONTRACT_ID")==$v["M_CONTRACT_ID"])?'selected="selected"':''?>><?php print $v["M_CONTRACT_NAME"]?></option>
										<?php }?>
									</select></p>
									<?php }?>
								</td>
							</tr>
							<tr>
								<td valign="top">契約満了日</td>
								<td>
									<p><?php print $inputs->text("COMPANY_CONTRACT_DATE_END_from", $collection->getByKey($collection->getKeyValue(), "COMPANY_CONTRACT_DATE_END_from") ,"imeDisabled circle wZip",50)?>
									<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#COMPANY_CONTRACT_DATE_END_from\').val(\'\');"')?></p>
									&nbsp;～&nbsp;<br />
									<?php print $inputs->text("COMPANY_CONTRACT_DATE_END_to", $collection->getByKey($collection->getKeyValue(), "COMPANY_CONTRACT_DATE_END_to") ,"imeDisabled circle wZip",50)?>
									<?=$inputs->button("","","クリア","circle", 'onclick="$(\'#COMPANY_CONTRACT_DATE_END_to\').val(\'\');"')?></p>

									<script type="text/javascript">
										$(function() {
											$("#COMPANY_CONTRACT_DATE_END_from").datepicker({
												dateFormat: 'yy-mm-dd',
												changeMonth: true,
								                changeYear: true,
								                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
								                dayNamesMin: ['日','月','火','水','木','金','土'],
											});
											$("#COMPANY_CONTRACT_DATE_END_to").datepicker({
												dateFormat: 'yy-mm-dd',
												changeMonth: true,
								                changeYear: true,
								                monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
								                dayNamesMin: ['日','月','火','水','木','金','土'],
											});
										});
									</script>
								</td>
							</tr>
							<tr>
								<td colspan="2">
								<?php //$op = 'onchange="document.frmSearch.submit();"';?>
								<?=$inputs->checkbox("COMPANY_STATUS1","COMPANY_STATUS1",1,$collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS1")," 未契約", "", $op)?>&nbsp;
								<?=$inputs->checkbox("COMPANY_STATUS2","COMPANY_STATUS2",2,$collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS2")," 契約中", "", $op)?>&nbsp;<br />
								<?=$inputs->checkbox("COMPANY_STATUS3","COMPANY_STATUS3",3,$collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS3")," 契約満了", "", $op)?>&nbsp;
								<?=$inputs->checkbox("COMPANY_STATUS4","COMPANY_STATUS4",4,$collection->getByKey($collection->getKeyValue(), "COMPANY_STATUS4")," 削除済", "", $op)?>&nbsp;
								</td>
							</tr>
						</table>
						<ul class="buttons">
							<li><?=$inputs->submit("","search","検索", "circle")?></li>
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