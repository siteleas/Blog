<div class="ossn-page-contents">
	<div class="blog">
			<?php
				$blogs = $params['blogs'];
				$count = $params['count'];
				if($blogs){
					foreach($blogs as $item){
						echo ossn_plugin_view('blog/list/item', array('item' => $item));	
					}
					echo ossn_view_pagination($count);
				}
			?>
	</div>
</div>