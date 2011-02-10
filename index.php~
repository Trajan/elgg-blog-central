<?php

	/**
	 * Elgg blog index page
	 * 
	 * @package ElggBlog
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2010
	 * @link http://elgg.com/
	 */

	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	// access check for closed groups
	group_gatekeeper();
		$callback = get_input('callback');
	// Get the current page's owner
		$page_owner = page_owner_entity();
		if (($page_owner == false) || (is_null($page_owner))) {
			if (empty($callback)) {	
			// guess that logged in user is the owner - if no logged in send to all blogs page
			if (!isloggedin()) {
				forward('mod/blog/everyone.php');
			}}
			
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	//set blog title
		if ($page_owner == $_SESSION['user']) {
			$area2 = elgg_view_title(elgg_echo('blog:your'));
		} else {
			$area2 = elgg_view_title(sprintf(elgg_echo('blog:user'),$page_owner->name));
		}

		$offset = (int)get_input('offset', 0);
		
	// Get a list of blog posts
// $feature = get_plugin_setting('featuredmine','blog');
// if ($feature != 'no'){ 
// 		$area2 .= elgg_view('blog/top');
// }

		if (empty($callback)) {	
		
		$blog_objects .= elgg_list_entities(array('type' => 'object', 'subtype' => 'blog', 'container_guid' => page_owner(), 'limit' => 10, 'offset' => $offset, 'full_view' => FALSE, 'view_type_toggle' => FALSE));
		if ($blog_objects) {
		$area2 .= $blog_objects;
		}
		else
		{			
		$area2 .= elgg_echo ('blog:noblogs');
		}
	// Get blog tags

		// Get categories, if they're installed
		global $CONFIG;
		$area3 = elgg_view('blog/categorylist', array(
			'baseurl' => $CONFIG->wwwroot . 'pg/categories/list/?subtype=blog&owner_guid='.$page_owner->guid.'&category=',
			'subtype' => 'blog', 
			'owner_guid' => $page_owner->guid));
		
			$top = get_plugin_setting('top','blog');
			if ($top != 'no'){ 
			if (get_context() == 'blog'){
			elgg_extend_view('page_elements/owner_block','blog/top_blogger');
			 }
			//$area3 .= elgg_view('blog/top_blogger');		
			}
		
	// Display them in the page
        $body = elgg_view_layout("two_column_left_sidebar", '', $area2, $area3);
		
	// Display page
		page_draw(sprintf(elgg_echo('blog:user'),$page_owner->name),$body);
}
else
{
	//$title = sprintf(elgg_echo("groups:all"),page_owner_entity()->name);
	//$content = elgg_view_title($title);
	$content .= elgg_view('blog/everyone');
	// ajax callback
	header("Content-type: text/html; charset=UTF-8");
	echo $content;

}		
?>