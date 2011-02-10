<?php
	
	$owner_guid = (int) get_input('owner_guid');
	$my_guid = $_SESSION['user']->guid;
	
	$already_watching = check_entity_relationship($my_guid, 'blogwatcher', $owner_guid);
	if($already_watching != FALSE){
		remove_entity_relationship($my_guid, 'blogwatcher', $owner_guid);
		system_message(elgg_echo('blog:watch:delete:success'));
	}else{
		add_entity_relationship($my_guid, 'blogwatcher', $owner_guid);
		system_message(elgg_echo('blog:watch:add:success'));
	}
	forward($_SERVER['HTTP_REFERER']);
?>