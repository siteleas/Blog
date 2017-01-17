<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
define('BLOG', ossn_route()->com . 'Blog/');
require_once(BLOG . 'classes/Blog.php');

/**
 * Blog Init
 *
 * @return void
 */
function blog_init() {
		if(ossn_isLoggedin()) {
				ossn_register_action('blog/add', BLOG . 'actions/add.php');
				ossn_register_action('blog/edit', BLOG . 'actions/edit.php');
				ossn_register_action('blog/delete', BLOG . 'actions/delete.php');
		}
		ossn_register_callback('user', 'delete', 'ossn_user_blog_delete');
		ossn_register_callback('page', 'load:profile', 'ossn_profile_blog_menu');

		ossn_extend_view('css/ossn.default', 'css/blog');
		ossn_register_page('blog', 'ossn_blog_page_handler');

		ossn_register_sections_menu('newsfeed', array(
				'text' => ossn_print('blog:all'),
				'url' => ossn_site_url('blog/all'),
				'section' => 'blog',
				'icon' => true
		));
		ossn_register_sections_menu('newsfeed', array(
				'text' => ossn_print('blog:add'),
				'url' => ossn_site_url('blog/add'),
				'section' => 'blog',
				'icon' => true,
		));
}
/**
 * Get blog object
 *
 * @param integer $guid A blog guid
 *
 * @return object|boolean
 */
function ossn_get_blog($guid) {
		if($object = ossn_get_object($guid)) {
				$type = (array) $object;
				if($object->subtype = 'blog') {
						return arrayObject($type, 'Blog');
				}
		}
		return false;
}
/**
 * Blog pages
 *
 * @param array $pages A pages
 *
 * @return mixdata
 */
function ossn_blog_page_handler($pages) {
		$page = $pages[0];
		switch($page) {
				case 'add':
						if(!ossn_isLoggedin()){
							ossn_error_page();
						}
						$title               = ossn_print('blog:add');
						$contents['content'] = ossn_plugin_view('blog/pages/add');
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
				case 'view':
						$blog = ossn_get_blog($pages[1]);
						if(!$blog) {
								ossn_error_page();
						}

						$title               = $blog->title;
						$contents['content'] = ossn_plugin_view('blog/pages/view', array(
								'blog' => $blog
						));
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
				case 'edit':
						if(!ossn_isLoggedin()){
							ossn_error_page();
						}
						$blog = ossn_get_blog($pages[1]);
						if(!$blog) {
								ossn_error_page();
						}
						if(($blog->owner_guid == ossn_loggedin_user()->guid) || ossn_loggedin_user()->canModerate()) {
								$title               = ossn_print('blog:edit');
								$contents['content'] = ossn_plugin_view('blog/pages/edit', array(
										'blog' => $blog
								));
								$content             = ossn_set_page_layout('newsfeed', $contents);
								echo ossn_view_page($title, $content);
						} else {
								ossn_error_page();
						}
						break;
				case 'all':
						$blog = new Blog;
						if(!isset($pages[1])) {
								$blogs = $blog->getBlogs();
								$count = $blog->getBlogs(array(
										'count' => true
								));
						} else {
								$user  = ossn_user_by_guid($pages[1]);
								$blogs = $blog->getUserBlogs($user);
								$count = $blog->getUserBlogs($user, array(
										'count' => true
								));
						}
						$title               = ossn_print('blog:all');
						$contents['content'] = ossn_plugin_view('blog/pages/all', array(
								'blogs' => $blogs,
								'count' => $count
						));

						$contents['content'] .= "<div class=\"ossn-widget\">\n<div class=\"widget-heading\">\n";
						$contents['content'] .= $count .' post';
						if ($count > 1) {$contents['content'] .= 's';}
						$contents['content'] .= "</div>\n</div>\n";
						$content             = ossn_set_page_layout('newsfeed', $contents);
						echo ossn_view_page($title, $content);
						break;
		}
}
/**
 * Delete user events
 *
 * @param string $callback A name of callback
 * @param string $type A event type
 * @param array  $params A option values
 *
 * @return void
 */
function ossn_user_blog_delete($callback, $type, $params) {
		if(!empty($params['entity']->guid)) {
				$blogs = new Blog;
				$list  = $blogs->getUserBlogs($params['entity']->guid, array(
						'page_limit' => false
				));
				foreach($list as $item) {
						$item->deleteObject();
				}
		}
}
/**
 * Event profile menu
 *
 * @param string $event A name of callback
 * @param string $type A event type
 * @param array  $params A option values
 *
 * @return void
 */
function ossn_profile_blog_menu($event, $type, $params) {
		$guid = ossn_get_page_owner_guid();
		$url  = ossn_site_url();
		ossn_register_menu_item('user_timeline', array(
				'name' => 'blog',
				'href' => ossn_site_url("blog/all/{$guid}"),
				'text' => ossn_print('blogs')
		));
}
ossn_register_callback('ossn', 'init', 'blog_init');
