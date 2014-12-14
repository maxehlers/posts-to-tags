<div class="wrap">
	<h2>Allocate Posts to "<?= $tax->labels->name." / ".$tag->name; ?>"</h2>
	<?php
		include($tdir."detail-saved-message.php");
	?>
	<div class="tablenav top">
		<div style="actions alignleft">
			<ul class="subsubsub">
				<li class="all"><a href="admin.php?page=posts-to-tags" title="Select another Tag">« <?= _e('Back to','posts-to-tags'); ?> Start</a></li>
				<li class="all"><a href="admin.php?page=posts-to-tags&tax=<?= $given_taxonomy; ?>" title="<?= _e('Back to', 'posts-to-tags'); ?> <?= $tax->labels->name; ?>">‹ <?= _e('Back to','posts-to-tags'); ?> "<?= $tax->labels->name; ?>"</a></li>
			</ul>
		</div>
		<?php include($tdir."detail-pagination.php"); ?>
	</div>
	
	<?=  wp_nonce_field( 'save-post-to-tags', 'post-to-tags-nonce' ); ?>	
	<table class="wp-list-table widefat fixed">
		<thead>
			<?php include($tdir."detail-thead-tfoot.php"); ?>
		</thead>
		<tbody>