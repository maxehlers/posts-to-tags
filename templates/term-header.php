<div class="wrap">
	<h2>Allocate Posts to "<?= $tax->labels->name; ?>"</h2>
	<div class="tablenav top">
		<div class="alignleft actions">
			<ul class="subsubsub">
				<li class="all"><a href="admin.php?page=posts-to-tags" title="Select another Tag">« Back to overview</a></li>
			</ul>
		</div>
		<?php include($tdir."term-pagination.php"); ?>
	</div>
	<table class="wp-list-table widefat fixed">
		<thead>
			<?php include($tdir."term-thead-tfoot.php"); ?>
		</thead>
		<tbody>