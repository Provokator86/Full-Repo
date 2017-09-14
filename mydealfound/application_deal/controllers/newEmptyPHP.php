<?php

/**

 * The main template file.

 *

 * This is the most generic template file in a WordPress theme

 * and one of the two required files for a theme (the other being style.css).

 * It is used to display a page when nothing more specific matches a query.

 * E.g., it puts together the home page when no home.php file exists.

 * Learn more: http://codex.wordpress.org/Template_Hierarchy

 *

 * @package WordPress

 * @subpackage Twenty_Ten

 * @since Twenty Ten 1.0

 */



get_header(); ?>



		

                    <?/*<!-- left column start here------------->*/?>

                      <?php require(get_template_directory().'/leftmenu.php'); ?>

                     <?/*  <!-- left column end  here------------->*/?>

                       

                        <?/*<!-- right column start here------------->*/?>

                      <div id="rightcolumn">

                      

                        <?/*<!--banner start here------------->*/?>

                        <div id="banner">

                          <object id="FlashID2" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="720" height="290">

                             <param name="movie" value="<?php bloginfo('template_directory'); ?>/FLASHINTRO.swf" />

                             <param name="quality" value="high" />

                             <param name="wmode" value="opaque" />

                             <param name="swfversion" value="9.0.45.0" />

                             <?/*<!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don't want users to see the prompt. -->*/?>

                             <param name="expressinstall" value="<?php bloginfo('template_directory'); ?>/Scripts/expressInstall.swf" />

                            <?/* <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->*/?>

                             <!--[if !IE]>-->

                             <object type="application/x-shockwave-flash" data="<?php bloginfo('template_directory'); ?>/FLASHINTRO.swf" width="720" height="290">

                               <!--<![endif]-->

                               <param name="quality" value="high" />

                               <param name="wmode" value="opaque" />

                               <param name="swfversion" value="9.0.45.0" />

                               <param name="expressinstall" value="<?php bloginfo('template_directory'); ?>/Scripts/expressInstall.swf" />

                               <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->

                               <div>

                                 <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>

                                 <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>

                               </div>

                               <!--[if !IE]>-->

                             </object>

                             <!--<![endif]-->

                          </object>

                        </div>

                      <?/*  <!--banner end here------------->*/?>

                        

                        

                       <?/* <!-- article section start here------------->*/?>

                        

                        <div class="article_section">

							<?php if(is_home()){ ?> 

                            <?php if (have_posts()) :

                            $my_query = new WP_Query('category_name=home&showposts=1');?>

                            <?php 

                            $inc=1;

                            while ($my_query->have_posts()) : $my_query->the_post(); ?>

                            	<p><?php the_content(); ?></p>

							<?php 

                            $inc++;

                            endwhile;

                            ?>

                            <?php endif; ?> 

                            <?php } ?> 

                        </div>

                        

                      </div>

                      <?/* <!-- right column end here------------->*/?>

                      



<?php //get_sidebar(); ?>

<?php get_footer(); ?>