<?php
require_once('includes/applicationInc.php');

$dbMaster = new dbMaster();

$sess = new sessionMember($dbMaster);
$sess->start();
require("includes/box/login/loginAction.php");


$inputs = new inputs();
?>
<?php require("includes/box/common/doctype.php"); ?>
<html>
<head>
<?php require("includes/box/common/meta.php"); ?>
<title>人数設定 ｜ <?php print SITE_PUBLIC_NAME?></title>
<meta name="keywords" content="<?php print SITE_PUBLIC_KEYWORD?>" />
<meta name="description" content="<?php print SITE_PUBLIC_DESCRIPTION?>" />
<script type="text/javascript">
function setData() {
	<?php /*
	<?php for ($i=1; $i<=6; $i++) {?>
	var num<?php print $i?> = $("#child_number<?php print $i?>").val();
	<?php }?>
	*/?>
	parent.setData();
}

function totalAdult() {
	var total=0;
	$(".adultset").each(function(){
		var point = $(this).val()?$(this).val():0;
		total = parseInt(point)+total;
	});

	parent.$("#adult_text").text(total);
}
function totalChild() {
	var total=0;
	$(".adultset").each(function(){
		var point = $(this).val()?$(this).val():0;
		total = parseInt(point)+total;
	});

	parent.$("#adult_text").text(total);
}

$(document).ready(function(){

	//	部屋数から表示すうを変更
	$("#room_num").change(function () {
		$('.numboxset').addClass('dspNon');
	});

	var i;
	for (i = 1; i <= parseInt(parent.$('#room_numbers').val()); i = i +1){
		$('#datainput'+i).removeClass('dspNon');
	}
	var child;
	var setAdult;
	var setChild;

	//	全ての部屋のデータを上書き
	for (i = 1; i <=<?php print SITE_ROOM_NUM?>; i = i +1){
		//	設定済み人数 大人
		setAdult = 0;
		if (parseInt(parent.$('#room_numbers').val()) >= i) {
			if (parent.$('#adult_number'+i).val() != '') {
				setAdult = parent.$('#adult_number'+i).val();
			}
		}
		else {
			parent.$('#adult_number'+i).val(0);
		}

		
		//第二至最后一个默??置?1
		if(setAdult==0  && i<=parseInt(parent.$('#room_numbers').val())){
			setAdult=2;
			parent.$('#adult_number'+i).val(2);
		}


		$('#adult_number'+i).val(setAdult);

		//	設定済み人数 子供
		for (child = 1; child<=6; child=child +1){
			setChild = 0;
			if (parseInt(parent.$('#room_numbers').val()) >= i) {
				if (parent.$('#child_number'+i+child).val() != '') {
					setChild = parent.$('#child_number'+i+child).val();
				}
			}
			else {
				parent.$('#child_number'+i+child).val(0);
			}
			$('#child_number'+i+child).val(setChild);
		}

	}

	totalAdult();
	totalChild();
});


</script>
</head>
<body style="background: none;">

<?php for ($roomNum=1; $roomNum<=SITE_ROOM_NUM; $roomNum++) {?>

<div id="datainput<?php print $roomNum?>" class="datainputset dspNon">
<p><?php print $roomNum?>部屋目</p>
<table class="tblInput" width="100%">



	<tr >
		<th rowspan="2" style="border-right: 1px solid #dcdcdc; text-align:center;">大人</th>
		<th rowspan="2" style="border-right: 1px solid #dcdcdc; text-align:center;">小学生<br />(低学年)</th>
		<th rowspan="2" style="border-right: 1px solid #dcdcdc; text-align:center;">小学生<br />(高学年)</th>
		<th colspan="4" style="text-align:center;">幼児</th>
	</tr>
	<tr >
		<th style="border-right: 1px solid #dcdcdc; text-align:center;">食事・布団あり</th>
		<th style="border-right: 1px solid #dcdcdc; text-align:center;">食事あり</th>
		<th style="border-right: 1px solid #dcdcdc; text-align:center;">布団あり</th>
		<th>食事・布団なし</th>
	</tr>
	<tr>
		<td style="border-right: 1px solid #dcdcdc; text-align:center;">
			<select id="adult_number<?php print $roomNum?>" name="adult_number<?php print $roomNum?>" class="adultset">
				 <!-- <option value="0">0</option> --> 
				<?php for ($i=1; $i<=SITE_ADULT_NUM; $i++) {?>
				<option value="<?php print $i?>" ><?php print $i?><?php print ($i==9)?'～':''?></option>
				<?php }?>
			</select>

			<script type="text/javascript">
			$(document).ready(function(){
            	$("#adult_number<?php print $roomNum?>").change(function () {
            		parent.$('#adult_number<?php print $roomNum?>').val(""+$(this).val());
            	});
            });
			</script>

		</td>
		<?php for ($j=1; $j<=6; $j++) {?>
		<td style="border-right: 1px solid #dcdcdc; text-align:center;">

			<select id="child_number<?php print $roomNum?><?php print $j?>" name="child_number<?php print $roomNum?><?php print $j?>" class="childset">
				<option value="0">0</option>
				<?php for ($i=1; $i<=SITE_CHILD_NUM; $i++) {?>
				<option value="<?php print $i?>" <?php print $selected;?>><?php print $i?></option>
				<?php }?>
			</select> 名

			<script type="text/javascript">
			$(document).ready(function(){
            	$("#child_number<?php print $roomNum?><?php print $j?>").change(function () {
            		parent.$('#child_number<?php print $roomNum?><?php print $j?>').val(""+$(this).val());
            	});
            });
			</script>

		</td>
		<?php }?>
	</tr>


</table>

</div>
<?php }?>
<br />
<script type="text/javascript">
$(document).ready(function(){
	$(".adultset").change(function () {
		var total=0;
		$(".adultset").each(function(){
			var point = $(this).val()?$(this).val():0;
			total = parseInt(point)+total;
		});

		parent.$("#adult_text").text(total);

		totalAdult();

    });
	$(".childset").change(function () {
		var total=0;
		$(".childset").each(function(){
			var point = $(this).val()?$(this).val():0;
			total = parseInt(point)+total;
		});
		parent.$("#child_text").text(total);

		totalChild();
    });
});
</script>


<table width="100%">
<tr>
		<td style="text-align:center;"><input type="button" value="閉じる" onclick="setData();"></td>
	</tr>
</table>
</body>
<!-- InstanceEnd --></html>
