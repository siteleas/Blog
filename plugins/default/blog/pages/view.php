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
 ?>
<div class="ossn-page-contents">
	<div class="blog">
    		<div class="blog-title"><?php echo $params['blog']->title;?></div>
			<div class="blog-body"><?php echo nl2br($params['blog']->description);?></div>
            <div class="aba">
            		<?php
						$user = ossn_user_by_guid($params['blog']->owner_guid);
					?>
				<div class="user-data">
                                 <div class="author">
                 				<img src="<?php echo $user->iconURL()->small;?>" />
                                <div class="name"><a href="<?php echo $user->profileURL();?>"><?php echo $user->fullname;?></a></div>
                 </div>
                <div class="date">
                	<span class="time-created"><?php echo date("F d, Y", $params['blog']->time_created);?></span>
                </div>
                </div>
                <div class="controls">
                	<?php if(ossn_loggedin_user()->guid == $params['blog']->owner_guid || ossn_loggedin_user()->canModerate()){ ?>
                	<a href="<?php echo $params['blog']->profileURL('edit');?>" class="btn btn-success"><?php echo ossn_print('edit');?></a>
                	<a href="<?php echo $params['blog']->deleteURL();?>" class="btn btn-danger"><?php echo ossn_print('delete');?></a>
                    <?php } ?>
                </div>
            </div>
	</div>
</div>