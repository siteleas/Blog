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
class Blog extends OssnObject {
		/**
		 * InitializeAttributes;
		 *
		 * return void;
		 */
		private function initializeAttributes() {
				$this->annontation = new OssnAnnotaions;
		}
		/**
		 * Add blog;
		 *
		 * @param string $title A title for blog
		 * @param string $descriptionn A body/contents for blog
		 *
		 * return boolean;
		 */
		public function addBlog($title = '', $description = '') {
				$user = ossn_loggedin_user();
				if(!empty($title) && !empty($description) && $user) {
						$this->title       = $title;
						$this->description = $description;
						$this->type        = 'user';
						$this->subtype     = 'blog';
						$this->owner_guid  = $user->guid;
						if($this->addObject()) {
								return $this->getObjectId();
						}
				}
				return false;
		}
		/**
		 * Get a blog by blog id;
		 *
		 * @param integer $guid A valid blog id
		 *
		 * return object|false;
		 */
		public function getBlog($guid = '') {
				if(!empty($guid)) {
						$blog = ossn_get_object($guid);
						if($blog) {
								return $blog;
						}
				}
				return false;
		}
		/**
		 * Get all site blogs
		 *
		 * return object|false;
		 */
		public function getBlogs(array $params = array()) {
				return $this->searchObject(array_merge(array(
						'type' => 'user',
						'subtype' => 'blog'
				), $params));
		}
		/**
		 * Get user blogs
		 *
		 * @param object $user A valid users
		 *
		 * return object|false;
		 */
		public function getUserBlogs($user, $params = array()) {
				if($user instanceof OssnUser) {
						return $this->searchObject(array_merge(array(
								'type' => 'user',
								'subtype' => 'blog',
								'owner_guid' => $user->guid
						), $params));
				}
				return false;
		}
		/**
		 * Profile URL of blog
		 *
		 * return string;
		 */
		public function profileURL($type = 'view') {
				$title = OssnTranslit::urlize($this->title);
				return ossn_site_url("blog/{$type}/$this->guid/$title");
		}
		/**
		 * Profile URL of blog
		 *
		 * return string;
		 */
		public function deleteURL($type = 'view') {
				return ossn_site_url("action/blog/delete?guid=$this->guid", true);
		}		
} //class