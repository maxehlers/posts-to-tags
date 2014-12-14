<?php 
/**
 * Plugin Name: Posts to tags
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Allocating posts to taxonomies as easy as the other way round
 * Version: 1.0
 * Author: Maximilian Ehlers
 * Author http://maxehlers.de/
 * License: GPL2
 */
 
 add_action('admin_menu', 'ptt_menu');
 
 if(!function_exists("ptt_menu")){
	 function ptt_menu() {
	 	add_menu_page( 'Allocate posts to tags', 'Posts to Tags', 'manage_options', 'posts-to-tags', 'ptt_render', "", 7 );
	 }
 }
 if(!function_exists('ptt_render')){
 	function ptt_render(){

 		$renderPtt = true;
 		wp_enqueue_script('ptt_scripts', plugins_url()."/posts-to-tags/js/posts-to-tags.js", array('jquery'), '1.0.0', false );
 		// Saving the choice of the user
 		if(isset($_POST) && isset($_POST['ajax']) && $_POST['ajax'] == "true" && isset($_POST['toDo'])){

			if($_POST['toDo'] == "remove"){
				wp_remove_object_terms( $_POST['postid'], $_GET['tag'], $_GET['tax'] );
				$ret = $_GET['tag']." for ".$_POST['postid']." was removed";
			}
			elseif($_POST['toDo'] == "set"){
				wp_add_object_terms( $_POST['postid'], $_GET['tag'], $_GET['tax'] );
				$ret = $_GET['tag']." for ".$_POST['postid']." was added";
			}
			$renderPtt = false;
 		}

 		if($renderPtt === true){
 			
 			if(isset($_GET['current_page'])) $current_page = (int) $_GET['current_page'];
 			else $current_page = 1;

 			if(isset($_GET['s'])) $s = $_GET['s'];
 			else $s = "";

	 		// Rendering the detailed term page
	 		if(isset($_GET['tag']) && isset($_GET['tax'])){
	 			ptt_render_detail($_GET['tag'], $_GET['tax'], $current_page, $s);
	 		}
	 		elseif(!isset($_GET['tag']) && isset($_GET['tax'])){
	 			ptt_render_term($_GET['tax'], $current_page, $s);
	 		}
	 		else{
	 		
		 		$tdir = plugin_dir_path(__FILE__)."templates/";
		 		$args = array('public' => true);
		 		// Taxonomies auflisten
		 		if(isset($_GET['object_type']) && $_GET['object_type'] != ""){
		 			$args['object_type'][] = $_GET['object_type'];
		 		}
		 		if(isset($_GET['taxonomy']) && $_GET['taxonomy'] != ""){
		 			$args['name'] = $_GET['taxonomy'];
		 		}
		 		$post_types = get_post_types(array('public' => true));
		 		$taxonomies = get_taxonomies($args);
		 		$posttypes = array();
		 		$tax = array();
		 		$terms = array();
		 		foreach($post_types as $pt){
		 			$pobj = get_post_type_object($pt);
		 			$pobj_label = $pobj->labels;
		 			$posttypes[$pt]['slug'] = $pt;
		 			$posttypes[$pt]['name'] = $pobj_label->name;
		 		}
		 		foreach($taxonomies as $t){
		 			$tobj = get_taxonomy($t);
		 			$tlabels = $tobj->labels;
		 			$tax[$t]['slug'] = $t;
		 			$tax[$t]['name'] = $tobj->name;
		 			$tax[$t]['realName'] = $tlabels->name;
		 			$tax[$t]['post_types'] = $tobj->object_type;
		 			$thisterms = get_terms($t, array('hide_empty' => false));
		 			$ti = 0;
		 			foreach($thisterms as $t2){
		 				$terms[$t][$ti]['name'] = $t2->name;
		 				$terms[$t][$ti]['slug'] = $t2->slug;
		 				$terms[$t][$ti]['term_id'] = $t2->term_id;
						$ti++;
		 			}
		 		}
		 		include($tdir."index-header.php");
		 		
		 		include($tdir."index-body.php");
		 		
		 		include($tdir."index-footer.php");
	 		}
	 	}
 	}
 }
 if(!function_exists('ptt_render_term')){
 	function ptt_render_term($given_taxonomy, $current_page = 1, $s = ""){
		$tdir = plugin_dir_path(__FILE__)."templates/";
		$tax = get_taxonomy( $given_taxonomy );

		// How many terms should be displayed per page
		$to_be_displayed = 20;
		// Count all terms
		$total_terms = get_terms($given_taxonomy, array('hide_empty' => false, 'search' => $s));
		$terms_count = count($total_terms);

		$terms = get_terms($given_taxonomy, array(
				'hide_empty' => false,
				'number' => $to_be_displayed,
				'offset' => ($current_page - 1) * $to_be_displayed,
				'search' => $s));
		// Pagination for terms
		$thislink = "admin.php?page=posts-to-tags&tax=".$given_taxonomy."&s=".$s;


		$pag_firstpage = 1;
		$pag_priorpage = $current_page - 1;
		$pag_nextpage = $current_page + 1;
		$pag_lastpage = ceil($terms_count / $to_be_displayed);

		include($tdir."term-header.php");
		include($tdir."term-body.php");
		include($tdir."term-footer.php");
		
 	}
 }
 if(!function_exists('ptt_render_detail')){
 	function ptt_render_detail($given_tag, $given_taxonomy, $current_page = 1, $s = ""){
		$tdir = plugin_dir_path(__FILE__)."templates/";
		$thislink = "admin.php?page=posts-to-tags&tag=".$given_tag."&tax=".$given_taxonomy."&s=".$s;
		//$tax = get_taxonomy( $given_taxonomy );
		$tax = get_taxonomy( $given_taxonomy );
		$tag = get_term_by( 'slug', $given_tag, $given_taxonomy);
		
		
		$post_type = $tax->object_type;
		$i = 0;
		$to_be_displayed = 20;
		$query_args = array(
						'post_type' => $post_type,
						'posts_per_page' => $to_be_displayed,
						'paged' => $current_page,
						'order' => 'asc',
						'orderby' => 'title',
						's' => $s
					);
		$qu = new WP_Query($query_args);

		// Pagination
		$pag_firstpage = 1;
		$pag_priorpage = $current_page - 1;
		$pag_nextpage = $current_page + 1;
		$pag_lastpage = ceil($qu->found_posts / $to_be_displayed);

		include($tdir."detail-header.php");
		include($tdir."detail-body.php");
		include($tdir."detail-footer.php");
		
 	}
 }
 if(!function_exists('ptt_init')){
 	function ptt_init(){
 		$plugin_dir = basename(dirname(__FILE__))."/languages/";
 		load_plugin_textdomain( 'posts-to-tags', false, $plugin_dir );
 		add_filter( "tag_row_actions", "ptt_tags_row_action", 10, 2 );
 		add_filter( "category_row_actions", "ptt_tags_row_action", 10, 2 );
 	}
 }
 add_action( "plugins_loaded", "ptt_init" );

 if(!function_exists('ptt_tags_row_action')){
 	function ptt_tags_row_action($actions, $tag){
 		$add = '<a href="admin.php?page=posts-to-tags&tag='.$tag->slug.'&tax='.$tag->taxonomy.'">Post to Tags</a>';
 		$actions['ptt'] = $add;
 		return $actions;
 	}
 }
?>