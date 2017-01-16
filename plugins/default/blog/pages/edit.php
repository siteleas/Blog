<div class="ossn-page-contents">
	<div class="blog">
			<?php
					echo ossn_view_form('blog/edit', array(
							'action' => ossn_site_url() . 'action/blog/edit',
							'params' => $params,
					));
			?>
	</div>
</div>