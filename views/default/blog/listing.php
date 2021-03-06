<?php

	/**
	 * Elgg blog listing
	 * 
	 * @package ElggBlog
	 */
	 $feature = get_plugin_setting('feature','blog');
	if ($feature != 'no'){
	 	if(isadminloggedin()){
						if($vars['entity']->featured_blog == "yes"){
							$featured_url = elgg_add_action_tokens_to_url($vars['url'] . "action/blog/featured?blogguid=" . $vars['entity']->guid . "&action_type=unfeature");
							$wording = elgg_echo("blog:unfeature");
						}else{
							$featured_url = elgg_add_action_tokens_to_url($vars['url'] . "action/blog/featured?blogguid=" . $vars['entity']->guid . "&action_type=feature");
							$wording = elgg_echo("blog:feature");
						}}
					}
						
		$tags = elgg_view('output/tags', array('tags' => $vars['entity']->tags));
								
						
						
		$canedit = $vars['entity']->canEdit();
		$owner = $vars['entity']->getOwnerEntity();
		$created_by = elgg_echo('blog:created:by') . $owner->name . ", ";
		$views = $vars['entity']->getAnnotations("blogview");
		if ($views != FALSE){
		$current_count = $views[0]->value;
		
		}
		else
		{
		  $current_count = 0;
		}
		$friendlytime = elgg_view_friendly_time($vars['entity']->time_created);
		$icon = elgg_view(
				"profile/icon", array(
										'entity' => $owner,
										'size' => 'small',
									  )
			);
		
		if($vars['entity'] instanceof ElggObject){
			        //get the number of comments
		$num_comments = elgg_count_comments($vars['entity']);
		$comments = "<a href='{$vars['entity']->getURL}'>" . sprintf(elgg_echo('comments')) . " (" . $num_comments . ")</a>";
		}
		$edit = "<a href='{$vars['url']}mod/blog/edit.php?blogpost={$vars['entity']->getGUID()}'>" . elgg_echo('edit') . "</a>";
		$delete = elgg_view("output/confirmlink", array('href' => $vars['url'] . "action/blog/delete?blogpost=" . $vars['entity']->getGUID(),'text' => elgg_echo('delete'),'confirm' => elgg_echo('deleteconfirm'),));
		$description = elgg_get_excerpt($vars['entity']->description, 500);
						// add a "read more" link if cropped.
						if (elgg_substr($description, -3, 3) == '...') {
							$description .= " <a href=\"{$vars['entity']->getURL()}\">" . elgg_echo('blog:read_more') . '</a>';
						}	
		$star = $vars['url']."mod/blog/graphics/star.png";
			 		$featured_star = "<img src='$star'>";
			        $featured = "$featured_star";
			
		
		
		if ($_SESSION['user']->admin){

		  $info = "<div class='blog_index_listing'>";
		  $info .= "<h3><a href='{$vars['entity']->getURL()}'>{$vars['entity']->title}</a></h3>";
    	  $info .= "<div class='listing_content_left'>";
    	  $info .= "<span style='float:left;margin-right:4px;'>" . $icon . "</span>" . $created_by . $friendlytime . " | " . $comments . " | " . elgg_echo('blog:stats:blogview') . "(" . $current_count . ")";    	      	  
    	  if ($tags){
	  $info .= '<p class="tags">' . $tags . '</p>';
	  }
    	  if($vars['entity']->featured_blog == "yes"){
		  $info .= "<div class='featured_blog_spot'>" . $featured . elgg_echo('blog:featured:yes') .  "</div>";
	  	  }
		  $info .= "</div>";
    	  $info .= "<div class='listing_content_right'>";
  		  $info .= elgg_view('output/longtext', array('value' => $description));
  		  $info .= "</div>"; 
 		  $info .= "<div class='admin_block'>";
 		  if($canedit){
	 	  $info .= "(" . $edit . ")" . "  " . "(" . $delete . ")" . "  ";
		  }
 		  $info .= "(<a href='$featured_url'>$wording</a>)";
 		  $info .= "</div></div>";
		  echo $info;

	  }else{
		  
		  $info = "<div class='blog_index_listing'>";
		  $info .= "<h3><a href='{$vars['entity']->getURL()}'>{$vars['entity']->title}</a></h3>";
    	  $info .= "<div class='listing_content_left'>";
    	  $info .= "<span style='float:left;margin-right:4px;'>" . $icon . "</span>" . $created_by . $friendlytime . " | " . $comments . " | " . elgg_echo('blog:stats:blogview') . "(" . $current_count . ")";    	      	  
	  if ($tags){
	    $info .= '<p class="tags">' . $tags . '</p>';}
    	  if($vars['entity']->featured_blog == "yes"){
		  $info .= "<div class='featured_blog_spot'>" . $featured . elgg_echo('blog:featured:yes') .  "</div>";
	  	  }
    	  $info .= "</div>";
    	  $info .= "<div class='listing_content_right'>";
  		  $info .= elgg_view('output/longtext', array('value' => $description));
 		  $info .= "</div>";
 		  $info .= "<div class='listing_content' id='listing_content_".$vars['entity']->guid."'>";
 		  if($canedit){
	 	  $info .= "(" . $edit . ")" . "  " . "(" . $delete . ")" . "  ";
		  }
 		  $info .= "</div></div>";
		  echo $info;
			

		}
		
?>	
