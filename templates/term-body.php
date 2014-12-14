<?php
	$i = 0;
	foreach($terms as $term){ ?>
		<tr class="<?php $i++; if($i % 2) echo "alternate"; ?>">
			<td><a href="<?= $thislink; ?>&tag=<?= $term->slug; ?>" title="<?= $term->name; ?>"><?= $term->name; ?></a></td>
			<td>
				<?php
					$pi = 0;
					$query_args = array(
									'post_type' => $tax->object_type,
									'posts_per_page' => 5,
									'orderby' => 'title',
									'order' => 'asc',
									'tax_query' => array(
										'taxonomy' => $given_taxonomy,
										'field' => 'term_id',
										'terms' => $term->term_id)
								);
					$qu = new WP_Query($query_args);
					
					if($qu -> have_posts()){
						while ($qu->have_posts()) : $qu->the_post();
							if(has_term($term->term_id, $given_taxonomy)){
								$pi++;
								if($pi != 1) echo ", ";
								the_title();
								$showmore = true;
							}
							else $showmore = false;
						endwhile; 
						if($qu->found_posts > 5 && $showmore === true) echo ", ...";
					}
				?>
			</td>
			<td>
				<div class="post-com-count-wrapper"><a href="<?= $thislink; ?>&tag=<?= $term->slug; ?>" title="Details" class="post-com-count"><span class="comment-count"><?= (isset($showmore) && $showmore == true && isset($qu->found_posts))? $qu->found_posts: $pi; ?></span></a></div>
			</td>
		</tr>
		<?php
	}
?>