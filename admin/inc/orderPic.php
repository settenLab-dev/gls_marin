<?php
if ($jobPic->getErrorCount() > 0) {
?>
			<?php print create_error_caption($jobPic->getError())?>
<?php
}
?>
<script type="text/javascript">
page = window.page || {}
page.DraggableGrid = DraggableGrid;
</script>

<div id="page_grid">
	<?php
	foreach ($jobPic->getCollection() as $data) {
	?>
	<div class="page_draggable">
		<div class="page_content circle">
			<p><?=$inputsOnly->image("HOTELPIC_DATA", $data["HOTELPIC_DATA"], IMG_HOTEL_APP_WIDTH, IMG_HOTEL_APP_HEIGHT, IMG_HOTEL_APP_SIZE, "", 3)?></p>
			<?=$inputs->hidden("order[]",$data["HOTELPIC_ID"])?>
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
