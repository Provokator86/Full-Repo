<div class="PageLayout-column PageLayout-leftColumn Grid-cell u-size4of12 u-sm-sizeFill u-md-sizeFill is-collapsible is-collapsed">
	<div class="PageLayout-column-collapseToggle"></div>
	<aside class="SidebarFirst">
		<div class="region region-sidebar-first">
			<div class="SystemBlock">
				<div class="menu-block-wrapper menu-block-feature-dev-docs-menu menu-name-main-menu parent-mlid-0 menu-level-2">
					<ul class="menu">
					<?php
						# looping through parent-menu(s)...
						foreach($menu_parent_links as $parent_key=>$parent_value) :	// Begin - Parent
						
							$parent_menu_link = ($parent_key=='overview')
												? base_url()
												: base_url() ."{$parent_key}";
							$li_css_class = ($CURRENT_MENU==$parent_key)
											? 'expanded active-trail': 'collapsed';
							$A_css_class = ($CURRENT_MENU==$parent_key)
											? 'active-trail': '';
							
					?>
						<li class="<?= $li_css_class ?>">
							<a href="<?= $parent_menu_link ?>" class="<?= $A_css_class ?>"><?= $parent_value ?></a>
						<?php
							// show sub-menu iff "Public APIs"
							if($parent_key=='public-api-calls') :	// Begin - "Public APIs"
						?>
							<ul class="menu">
							<?php
								// looping thru doc-sub-menu array...
								$counter = 1; $last_index = count($menu_sub_links);
								foreach($menu_sub_links as $sub_key=>$sub_value) : // Begin - Sub
								
									$li_sub_css_class = ($CURRENT_SUBMENU==$sub_key)
														? ' active-trail active': '';
									$A_sub_css_class = ($CURRENT_SUBMENU==$sub_key)
													   ? 'active-trail active api-sidebar'
													   : 'api-sidebar';
									$li_last_css_class = ($counter==$last_index)
														 ? 'last leaf': 'leaf';
							?>
								<li class="<?= $li_last_css_class . $li_sub_css_class ?>">
									<a id="<?= $sub_key ?>" href="javascript:void(0)" class="<?= $A_sub_css_class ?>"><wbr>
										<?= $sub_value ?></a>
								</li>
							<?php
									$counter++;
									
								endforeach;	  // End - Sub
							?>
							</ul>
						<?php
							endif;	// End - "Public APIs"
						?>
						</li>
					<?php
						endforeach;	 // End - Parent
					?>
					</ul>
				</div>
			</div>
		</div>
	</aside>
</div>
