<form action="admin.php" method="GET" id="ptt-searchform">
	<input type="hidden" name="page" value="posts-to-tags" />
	<input type="hidden" name="tag" id="ptt_term" value="<?= $given_tag; ?>" />
	<input type="hidden" name="tax" id="ptt_tax" value="<?= $given_taxonomy; ?>" />
	<p class="search-box">
		<label class="screen-reader-text" for="ptt-search-input"><?= _e('Search Posts'); ?>:</label>
		<input type="search" id="ptt-search-input" name="s" value="<?= $s; ?>" autofocus="autofocus" results="5" />
		<input type="submit" name="" id="search-submit" class="button" value="<?= _e('Search Posts'); ?>">
	</p>
</form>
<div style="clear: both;"></div>
<form action="admin.php" method="GET" class="ptt-pagination-form">
	<input type="hidden" name="page" value="posts-to-tags" />
	<input type="hidden" name="tag" id="ptt_term" value="<?= $given_tag; ?>" />
	<input type="hidden" name="tax" id="ptt_tax" value="<?= $given_taxonomy; ?>" />
	<input type="hidden" name="s" value="<?= $s; ?>" />
	<div class="tablenav-pages">
		<span class="displaying-num disabled"><?= $qu->found_posts; ?> <?= _e('Elements'); ?></span>
		<span class="pagination-links"><a class="first-page <?php if($current_page == 1) echo "disabled"; ?>" title="Go to first page" href="<?= $thislink; ?>">«</a> <a class="prev-page <?php if($current_page == 1) echo "disabled"; ?>" title="To prior page" href="<?= $thislink."&current_page=".$pag_priorpage; ?>">‹</a> <?php
		if($pag_lastpage > 1) { ?><span class="paging-input"><input type="number" class="current-page" title="<?= _e("Current Page",'posts-to-tags'); ?>" value="<?= $current_page; ?>" size="3" style="width: 60px; text-align:right;" name="current_page" /><?php } else echo $current_page; ?> <?= _e('of','posts-to-tags'); ?> <span class="total-pages"><?= $pag_lastpage; ?></span></span> <a class="next-page <?php if($current_page == $pag_lastpage) echo "disabled"; ?>" title="Next page" href="<?= $thislink."&current_page=".$pag_nextpage; ?>">›</a> <a class="last-page <?php if($current_page == $pag_lastpage) echo "disabled"; ?>" title="Last page" href="<?= $thislink."&current_page=".$pag_lastpage; ?>">»</a></span>
	</div>
</form>