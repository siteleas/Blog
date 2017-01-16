<?php
/**
 * Open Source Social Network
 *
 * @package   (Informatikon.com).ossn
 * @author    OSSN Core Team <info@opensource-socialnetwork.org>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
 
$title = input('title');
$description = input('contents');

$blog = new Blog;
if($guid = $blog->addBlog($title, $description)){
	ossn_trigger_message(ossn_print("blog:added"));
	
	$translit = OssnTranslit::urlize($title);
	redirect("blog/view/{$guid}/{$translit}");
}
ossn_trigger_message(ossn_print("blog:add:failed"), 'error');
redirect(REF);