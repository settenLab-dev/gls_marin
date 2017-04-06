<?php
require_once('includes/applicationInc.php');
require_once(PATH_SLAKER_COMMON.'includes/class/extends/affiliate.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");

$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html><!-- InstanceBegin template="/Templates/temp.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<?php require("includes/box/common/meta201505.php"); ?>
<title>企業概要 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
</head>

<body id="top">

<!--header-->
<?php require("includes/box/common/header_common.php");?>
<!--/header-->

<!-- InstanceBeginEditable name="indextop" --><!-- InstanceEndEditable -->

<!--content-->
<div id="content_short" class="clearfix">

	<!--main-->
		<!-- InstanceBeginEditable name="maincontents" -->
		<main id="profile">
	
			<ul id="panlist">
	        	<li><a href="index.html">TOP</a></li>
	            <li><span>企業概要</span></li>
	        </ul>
	
			<section>
				<h2><img src="./images/rule/title-profile.png" width="724" height="39" alt="企業概要" /></h2>
				<table>
					<tr>
						<th>社名（商号）</th>
						<td>
							glass space 株式会社（グラススペース）
						</td>
					</tr>
					<tr>
						<th>所在地</th>
						<td>
							<p>〒900-0033<br>
							沖縄県那覇市久米1-1-13 プランビル久米6F</p>
						</td>
					</tr>
					<tr>
						<th>TEL / FAX</th>
						<td>
							TEL：098-988-8105　/　FAX:098-988-8106
						</td>
					</tr>
					<tr>
						<th>URL</th>
						<td>
							<a href="http://glaspe.net/">http://glaspe.net/</a>
						</td>
					</tr>
					<tr>
						<th>創 立</th>
						<td>
							平成25年5月29日
						</td>
					</tr>
					<tr>
						<th>代表取締役</th>
						<td>
							工藤 英樹
						</td>
					</tr>
					<tr>
						<th>事業内容</th>
						<td>
							<ul>
								<li>1.地域特化型旅行事業
									<ul><li>・地域限定レジャーサイト『ココトモ』の運営</li></ul>
								</li>
								<li>2.地域連携型集客事業
									<ul><li>・地域と連携したイベント企画・運営</li></ul>
								</li>
								<li>3.宿泊施設特化型販促支援事業
									<ul><li>・WEB宿泊予約サイトの運営代行等</li></ul>
								</li>
								<li>4.ツール型販促支援事業
									<ul><li>・各種営業支援ツールの販売・代理店等</li>
								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<th>旅行業登録</th>
						<td>
							沖縄県知事登録旅行業　第3-322号
						</td>
					</tr>
					<tr>
						<th>所属団体</th>
						<td>
							一般社団法人　全国旅行業協会　正会員
						</td>
					</tr>
				</table>
			</section>
	
	    </main>
		<!-- InstanceEndEditable -->    
	    <!--/main-->

</div>
<!--/content-->

<!--footer-->
<?php require("includes/box/common/footer_common.php");?>
<!--/footer-->

</body>
<!-- InstanceEnd --></html>
