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
$guid = input('guid');

$blog = ossn_get_blog($guid);
if(!$blog){
	ossn_trigger_message(ossn_print("blog:edit:failed"), 'error');
	redirect(REF);	
}
$blog->title = $title;
$blog->description = $description;

if((($blog->owner_guid == ossn_loggedin_user()->guid) || ossn_loggedin_user()->canModerate()) && $blog->save()){
	ossn_trigger_message(ossn_print("blog:edited"));
	
	$translit = OssnTranslit::urlize($title);
	redirect("blog/view/{$blog->guid}/{$translit}");
}
ossn_trigger_message(ossn_print("blog:edit:failed"), 'error');
redirect(REF);