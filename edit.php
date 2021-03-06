<?php

	/**
	 * Elgg blog edit entry page
	 *
	 * @package ElggBlog
	 */

	// Load Elgg engine
		require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
		gatekeeper();

	// Get the current page's owner
		$page_owner = page_owner_entity();
		if ($page_owner === false || is_null($page_owner)) {
			$page_owner = $_SESSION['user'];
			set_page_owner($_SESSION['guid']);
		}

	// Get the post, if it exists
		$blogpost = (int) get_input('blogpost');
		if ($post = get_entity($blogpost)) {

			if ($post->canEdit()) {

				$area1 = elgg_view_title(elgg_echo('blog:editpost'));
				$area1 .= elgg_view("blog/forms/edit", array('entity' => $post));
			// Set the title appropriately
				$title = sprintf(elgg_echo("blog:posttitle"),$page_owner->name,$blogpost->title);
		
			// Display through the correct canvas area
				$body = elgg_view_layout("one_column_layout", '', $area1);

			}

		}

	// Display page
		page_draw($title,$body);

?>
