<div class="Navigation-inner">
	<ul class="Navigation-inner-list Navigation-inner-list--breadcrumb">
		<li class="NavigationItem NavigationItem--main NavigationItem--breadcrumb"><a class="NavigationItem-link" href="<?= project_url() ?>wsdl_server.php" title="Home"></a></li>
		<li data-is-clickable="false" class="NavigationItem NavigationItem--main NavigationItem--breadcrumb NavigationItem--withChildren"><a class="NavigationItem-link" href="javascript:void(0)">Documentation</a>
			<ul class="Navigation Navigation--sub">
			<?php
				# looping through Parent-Menu Item(s)...
				foreach($menu_parent_links as $parent_key=>$parent_value) :
				
					$NAV_URL = ($parent_key=='overview')
							   ? base_url()
							   : base_url() ."{$parent_key}";
			?>
				<li class="NavigationItem NavigationItem--sub"><a class="NavigationItem-link" href="<?= $NAV_URL ?>"><?= $parent_value ?></a></li>
			<?php
				endforeach;
			?>
			</ul>
		</li>
		<li class="NavigationItem NavigationItem--main NavigationItem--breadcrumb"><a class="NavigationItem-link" href="javascript:void(0)"><?= $DOC_BREADCRUMB_HEADER ?></a></li>
	</ul>
</div>
