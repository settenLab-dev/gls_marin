<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/company.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/tlPlan.php');

$dbMaster = new dbMaster();

$sess = new sessionCompany($dbMaster);
$sess->start();

require("includes/box/login/loginAction.php");
if (!$sess->sessionCheck()) {
	require_once('includes/box/login/loginBox.php');
	exit;
}

$company = new company($dbMaster);
$company->select($sess->getSessionByKey($sess->getSessionLogninKey(), "COMPANY_ID"));

$collectionLink = new collection($db);
$collectionLink->setByKey($collectionLink->getKeyValue(), "TL_HOTEL_ID", $_GET["id"]);
$collectionLink->setByKey($collectionLink->getKeyValue(), "TL_ROOM_TYPECODE", $_GET["rid"]);
$collectionLink->setByKey($collectionLink->getKeyValue(), "TL_PLAN_CODE", $_GET["pid"]);

$hotelPlanLink = new tlPlan($dbMaster);
$hotelPlanLink->selectList($collectionLink);


?>
<?php require("includes/box/common/doctype.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<?php require("includes/box/common/meta.php"); ?>
	<title>プラン｜<?=SITE_SLAKER_NAME?></title>
	<meta name="description" content="" />
	<script type="text/javascript">
	var profiles =
	{
		windowCallUnload:
		{
			height:600,
			width:550,
			scrollbars:1,
			center:1,
			createnew:1,
			onUnload:unloadcallback
		},
	};

	LoadingMsg('<?php print URL_SLAKER_COMMON?>assets/loader.gif');
	</script>
</head>
<body id="">
	<div id="containerPop">
		<h2>リンカーンプラン 詳細</h2>
		<div id="contentsPop" class="circle">
		<table border="0" cellpadding="0" cellspacing="15" class="" summary="マスタデータ" width="100%">
		<?php
		if ($hotelPlanLink->getCount() > 0) {
			foreach ($hotelPlanLink->getCollection() as $ad){
		?>
		<tr>
			<td width="150px" valign="top">
				<p>施設ID</p>
			</td>
			<td align="left">
				<?php if ($hotelPlanLink->getKeyValue() > 0) {?>
				<p><?php print $company->getByKey($company->getKeyValue(), "COMPANY_LINK")?></p>
				<?php }else{?>
				<p>登録すると表示されます</p>
				<?php }?>
			</td>
		</tr>
		<tr>
			<td width="40%" valign="top">
				<p>プランコード</p>
			</td>
			<td align="left">
				<?=$ad["TL_PLAN_CODE"]?>
			</td>
		</tr>
		<tr>
			<td width="40%" valign="top">
				<p>販売ステータス</p>
			</td>
			<td align="left">
				<?php if($ad["TL_PLAN_STATUS"]=="0") print "販売停止中";
					  if($ad["TL_PLAN_STATUS"]=="1") print "販売中";?>
			</td>
		</tr>
		<tr>
			<td width="40%" valign="top">
				<p>利用区分</p>
			</td>
			<td align="left">
				<?php
				if($ad["TL_PLAN_FLG_USE"] == "1") print "通常プラン";
				if($ad["TL_ROOM_TYPE"] == "2") print "日帰り";
				?>
			</td>
		</tr>
		<tr>
			<td widtd="40%" valign="top">
				<p>リンカーン室タイプコード</p>
			</td>
			<td align="left">
				<?=$ad["TL_ROOM_TYPECODE"]?>
			</td>
		</tr>
		<tr>
			<td widtd="40%" valign="top">
				<p>販売期間 </p>
			</td>
			<td align="left">
				<?=$ad["TL_PLAN_DATE_SALES_FROM"]?>～<?=$ad["TL_PLAN_DATE_SALES_TO"]?>
			</td>
		</tr>
		<tr>
			<td widtd="40%" valign="top">
				<p>掲載期間 </p>
			</td>
			<td align="left">
				<?=$ad["TL_PLAN_DATE_SHOW_FROM"]?>～<?=$ad["TL_PLAN_DATE_SHOW_TO"]?>
			</td>
		</tr>
		<tr>
			<td widtd="40%" valign="top">
				<p>プラン名 </p>
			</td>
			<td align="left">
				<?=$ad["TL_PLAN_NAME"]?>
			</td>
		</tr>
		<tr>
			<td widtd="40%" valign="top">
				<p>プラン詳細 </p>
			</td>
			<td align="left">
				<p style="word-break:break-all; width: 550px;"><?=redirectForReturn($ad["TL_PLAN_CONTENTS"])?></p>
			</td>
		</tr>
		<tr>
			<td widtd="40%" valign="top">
				<p>プラン画像</p>
			</td>
			<td align="left">
				<!--<img src="<?=URL_PUBLIC_LINK.$ad["TL_PLAN_PIC1"]?>" width="299" height="223" alt="<?=URL_PUBLIC_LINK.$ad["TL_PLAN_PIC_CAP1"]?>"><br/>
				<img src="<?=URL_PUBLIC_LINK.$ad["TL_PLAN_PIC2"]?>" width="299" height="223" alt="<?=URL_PUBLIC_LINK.$ad["TL_PLAN_PIC_CAP2"]?>"><br/>
				<img src="<?=URL_PUBLIC_LINK.$ad["TL_PLAN_PIC3"]?>" width="299" height="223" alt="<?=URL_PUBLIC_LINK.$ad["TL_PLAN_PIC_CAP3"]?>">-->
			</td>
		</tr>

		<tr>
			<td widtd="40%" valign="top">
				<p>一日の部屋数制限 </p>
			</td>
			<td align="left">
				<?=$ad["TL_PLAN_NUM_FROM"]?>～<?=$ad["TL_PLAN_NUM_TO"]?>
			</td>
		</tr>
		
		<tr>
			<td width="40%" valign="top">
				<p>料金区分 </p>
			</td>
			<td align="left">
				<?php
				if($ad["TL_PLAN_FLG_TAX"] == "0") print "人員単価";
				if($ad["TL_PLAN_FLG_TAX"] == "1") print "室料単価";
				?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<p>予約受け付け・<br />予約変更締切</p>
			</td>
			<td align="left">
				<?php
				if($ad["TL_PLAN_DAY_ACCEPT_FROM"] == "0"){ print "当日 ";}
				else{ print $ad["TL_PLAN_DAY_ACCEPT_FROM"]."日前 ";}
				print substr($ad["TL_PLAN_TIME_ACCEPT_TO"],0,2).":".substr($ad["TL_PLAN_TIME_ACCEPT_TO"],2,2)
				?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<p>チェックイン時間 </p>
			</td>
			<td align="left">
				<?=$ad["TL_PLAN_DATE_CHECKIN_FROM"]!="0"?str_insert($ad["TL_PLAN_DATE_CHECKIN_FROM"], 2, ":"):"00:00"?>～<?=$ad["TL_PLAN_DATE_CHECKIN_TO"]!="0"?str_insert($ad["TL_PLAN_DATE_CHECKIN_TO"],2,":"):"00:00"?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<p>チェックアウト時間 </p>
			</td>
			<td align="left">
				<?php 
				if(strlen($ad["TL_PLAN_TIME_CHECKOUT"]) == 3){
					print substr($ad["TL_PLAN_TIME_CHECKOUT"],0,1).":".substr($ad["TL_PLAN_TIME_CHECKOUT"],1,2);
				}
				else {
					print substr($ad["TL_PLAN_TIME_CHECKOUT"],0,2).":".substr($ad["TL_PLAN_TIME_CHECKOUT"],2,2);
				}
				?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<p>最短連泊数 </p>
			</td>
			<td align="left">
				<?=$ad["TL_PLAN_NIGHT_FROM"]?$ad["TL_PLAN_NIGHT_FROM"]:"設定無し"?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<p>最長連泊数 </p>
			</td>
			<td align="left">
				<?=$ad["TL_PLAN_NIGHT_TO"]?$ad["TL_PLAN_NIGHT_TO"]:"設定無し"?>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<p>食事設定 </p>
			</td>
			<td align="left">
				<?php
				if($ad["TL_PLAN_FLG_BF"]=="1") print "朝食有り";
				if($ad["TL_PLAN_FLG_DN"]=="1") print "夕食有り";
				if($ad["TL_PLAN_FLG_LN"]=="1") print "昼食有り";
				?>
			</td>
		</tr>
		
		<tr>
			<td width="40%" valign="top">
				<p>キャンセルポリシー設定 </p>
			</td>
			<td align="left">
				<p style="word-break:break-all; width: 550px;"><?=$ad["TL_PLAN_CANCELDATA"]?></p>
			</td>
		</tr>
	<?php }
	}?>
	</table>
	</div>
</div>
</body>
</html>