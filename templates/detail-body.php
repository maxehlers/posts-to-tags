<?php
	if($qu -> have_posts()){
		while ($qu->have_posts()) : $qu->the_post();
			if(has_term($given_tag, $given_taxonomy)){
				$checked = 'checked = "checked"';
			}
			else{
				$checked = "";
			}
		?>
			<tr class="<?php $i++; if($i % 2) echo "alternate"; ?>">
				<th class="check-column"><input type="checkbox" name="ptt" class="ptt-checkbox" data-id="<?= the_id(); ?>" value="<?= the_id(); ?>" <?  echo $checked; ?> /></th>
				<td colspan="2" class="ptt_post_title"><?= the_title(); ?></td>
			</tr>
		<?php endwhile; 
	}
?>