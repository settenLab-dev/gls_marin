<?php
	// クラス定義確認
	if(!class_exists('mArea')){
		require_once(PATH_SLAKER_COMMON.'includes/class/extends/mArea.php');
	}
	if(!class_exists('mActivityCategory')){
		require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategory.php');
	}
	if(!class_exists('mActivityCategoryDetail')){
		require_once(PATH_SLAKER_COMMON.'includes/class/extends/mActivityCategoryDetail.php');
	}
	
	// TOPエリア取得
	$mAreaTop = new mArea($dbMaster);
	$mAreaTop->selectTop();
	$mAreaTop->setPost();
	
	// 親エリア取得
	$mAreaParent = new mArea($dbMaster);
	$mAreaParent->selectParent();
	$mAreaParent->setPost();
	
	// 子エリア取得
	$mAreaChild = new mArea($dbMaster);
	$mAreaChild->selectChild();
	$mAreaChild->setPost();
	
	// エリア配列の作成
	// TOP
	$arrAreaTopData = $mAreaTop->getCollection();
	$arrAreaTop     = array();
	$arrAreaPlanCnt = array();
	
	foreach($arrAreaTopData as $top_data){
		$arrAreaTop[$top_data['M_AREA_ID']] = $top_data['M_AREA_NAME'];
		$arrAreaPlanCnt[$top_data['M_AREA_ID']] = 0;
	}
	
	// 親
	$arrAreaParentData = $mAreaParent->getCollection();
	$arrAreaParent = array();
	foreach($arrAreaParentData as $parent_data){
		$arrAreaParent[$parent_data['M_AREA_ID']] = $parent_data['M_AREA_NAME'];
	}
	
	// 子
	$arrAreaChildData = $mAreaChild->getCollection();
	$arrAreaChild = array();
	foreach($arrAreaChildData as $child_data){
		$arrAreaChild[$child_data['M_AREA_ID']] = $child_data['M_AREA_NAME'];
	}
	
	// エリア別プラン数取得
	$mAreaTopPlan       = new mArea($dbMaster);
	$arrAreaTopPlanData = $mAreaTopPlan->selectTopAreaPlanCnt();
	// エリア別プラン数配列生成
	foreach($arrAreaTopPlanData as $plan_data){
		$arrAreaPlanCnt[$plan_data['area_id']] = $plan_data['cnt'];
	}
	
	$collection = new collection($db);
	
	// カテゴリ取得
	$mActivityCategory = new mActivityCategory($dbMaster);
	$mActivityCategory->selectList($collection);
	
	$arrTopCategoryData = $mActivityCategory->getCollection();
	
	// 詳細カテゴリ取得
	$mActivityCategoryDetail = new mActivityCategoryDetail($dbMaster);
	$mActivityCategoryDetail->selectList($collection);
	
	$arrDetailCategoryData = $mActivityCategoryDetail->getCollection();
	
	$arrTopCategory       = array();
	$arrParentCategory    = array();
	$arrChildCategory     = array();
	$arrDetailCategory    = array();
	
	$arrCategoryPlanCnt = array();
	
	// カテゴリ配列作成
	foreach($arrTopCategoryData as $cat_data){
		// TOPカテゴリ
		if($cat_data['M_ACT_CATEGORY_TYPE'] == 1){
			$arrTopCategory[$cat_data['M_ACT_CATEGORY_ID']] = $cat_data['M_ACT_CATEGORY_NAME'];
			$arrCategoryPlanCnt[$cat_data['M_ACT_CATEGORY_ID']] = 0;
		}
		// 親カテゴリ
		if($cat_data['M_ACT_CATEGORY_TYPE'] == 2){
			$arrParentCategory[$cat_data['M_ACT_CATEGORY_ID']] = $cat_data['M_ACT_CATEGORY_NAME'];
		}
		// 子カテゴリ
		if($cat_data['M_ACT_CATEGORY_TYPE'] == 3){
			$arrChildCategory[$cat_data['M_ACT_CATEGORY_ID']] = $cat_data['M_ACT_CATEGORY_NAME'];
		}
	}
	
	// 詳細カテゴリ配列作成
	foreach($arrDetailCategoryData as $cat_data){
		// 詳細カテゴリ
		$arrDetailCategory[$cat_data['M_ACT_CATEGORY_D_ID']] = $cat_data['M_ACT_CATEGORY_D_NAME'];
	}
	
	// カテゴリ別プラン数取得
	$arrCategoryPlanData = $mAreaTopPlan->selectTopCategoryPlanCnt();
	// 配列生成
	foreach($arrCategoryPlanData as $plan_data){
		$arrCategoryPlanCnt[$plan_data['category_id']] = $plan_data['cnt'];
	}
?>
<script src="/js/stylebtn.js"></script>

<footer id="footer2016">

	<div id="footer-inner">
		<a href="#top" class="pagetop"><img src="images/common/icon_footer.png" width="72" height="42" alt="pagetop""></a>
		
		<div class="area_link">
			<h2 class="title_footer"><a href="/">エリアから探す</a></h2>
			<?php if(count($arrAreaTop) > 0):?>
				<ul class="area_inner">
					<?php foreach($arrAreaTop as $area_id => $area_name):?>
						<li>
							<a href="/plan-search.html?ta=<?php echo $area_id; ?>"><?php echo $area_name; ?>(<?php echo $arrAreaPlanCnt[$area_id]; ?>)</a>
						</li>
					<?php endforeach;?>
				</ul>
			<?php endif?>
		</div>
		
		<div class="cate_link">
			<h2 class="title_footer"><a href="/category.html">ジャンルから探す</a></h2>
			<?php if(count($arrTopCategory) > 0):?>
				<ul class="inner">
					<?php foreach($arrTopCategory as $category_id => $category_name):?>
						<li>
							<a href="/plan-search.html?tc=<?php echo $category_id; ?>"><?php echo $category_name; ?>(<?php echo $arrCategoryPlanCnt[$category_id]; ?>)</a>
						</li>
					<?php endforeach;?>
				</ul>
			<?php endif;?>
		</div>
		
		<div class="tag_link">
			<h2 class="title_footer"><a href="/theme.html">テーマ、こだわりから探す</a></h2>
			<ul class="inner">
				<li><a href="/about.html">PlayBookingについて</a></li>
				<li><a href="/help.html">ヘルプ</a></li>
				<li><a href="/member-terms.html">利用規約</a></li>
				<li><a href="/privacy.html">プライバシーポリシー</a></li>
				<li><a href="/corporate-profile.html">会社概要</a></li>
			</ul>
		</div>
		
		<div class="free_link">
			<h2 class="title_footer">人気のキーワード</h2>
			<ul class="inner">
				<li><a href="/about.html">PlayBookingについて</a></li>
				<li><a href="/help.html">ヘルプ</a></li>
				<li><a href="/member-terms.html">利用規約</a></li>
				<li><a href="/privacy.html">プライバシーポリシー</a></li>
				<li><a href="/corporate-profile.html">会社概要</a></li>
			</ul>
		</div>

				
		<div class="intro_link">
			<h2 class="title_footer">その他</h2>
			<ul class="inner">
				<li><a href="/about.html">レジャー会社から探す</a></li>
				<li><a href="/help.html">ジャンル一覧から探す</a></li>
				<li><a href="/member-terms.html">サイトへの掲載について</a></li>
				<li><a href="/privacy.html">PlayBooking＊TOPICS</a></li>
			</ul>
		</div>
	</div>
		
		<div class="site_link">
			<ul class="navi1">
				<li><a href="/about.html">PlayBookingについて</a></li>
				<li><a href="/help.html">ヘルプ</a></li>
				<li><a href="/member-terms.html">利用規約</a></li>
				<li><a href="/privacy.html">プライバシーポリシー</a></li>
				<li><a href="/corporate-profile.html">会社概要</a></li>
			</ul>
			<p class="copyright">copyright(c) All rights reserved GateSideMarine Inc.</p>
		</div>
</footer>