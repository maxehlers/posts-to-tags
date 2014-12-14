<?php
	foreach($tax as $t){
		if(isset($terms[$t['slug']])){?>
			<tr class="<?php $i=0; $i++; if($i % 2) echo "alternate"; ?>">
				<td><strong><a href="admin.php?page=posts-to-tags&tax=<?= $t['slug']; ?>"><?php _e($t['realName'],'posts-to-tags'); ?></a></strong></td>
				<td><?php 
						$pt = 0;
						foreach($t['post_types'] as $thispt){
							$pt++;
							if($pt > 1) echo ", ";
							echo isset($posttypes[$thispt]['name'])? $posttypes[$thispt]['name']: "";
						}
					?>
				</td>
			</tr>
		
		<?php }
	} ?>