<?php
if ($jobPlan->getErrorCount() > 0) {
?>
			<?php print create_error_caption($jobPlan->getError())?>
<?php
}
?>
<script type="text/javascript">
page = window.page || {}
page.DraggableGrid = DraggableGrid;
</script>

<div id="page_grid">
	<?php
	foreach ($jobPlan->getCollection() as $data) {
	?>
	<div class="page_draggable">
		<div class="page_content circle">
			<p><?=$data["HOTELPLAN_NAME"]?></p>
			<?=$inputs->hidden("order[]",$data["HOTELPLAN_ID"])?>
		</div>
	</div>
	<?php
	}
	?>
</div>

<script type="text/javascript">
(function() {
new page.DraggableGrid('page_grid', {
  draggableClass: 'page_draggable',
  scroll:         true,
  fence:          true
});
})();
</script>
<br />
<ul class="buttons">
	<li><?=$inputs->submit("","regist","並び変え", "circle")?></li>
</ul>
