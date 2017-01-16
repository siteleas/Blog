<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
 ?>
 <div>
 	<label><?php echo ossn_print('blog:title');?></label>
    <input type="text" name="title" />
 </div>
 <div>
 	<label><?php echo ossn_print('blog:contents');?></label>
    <textarea name="contents"></textarea>
 </div>
 <div class="margin-top-10">
 	<input type="submit" class="btn btn-success" value="<?php echo ossn_print('save');?>" />
 </div>