<?php
/*********
* Author: Koushik Rout
* Date  : 26 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For province detail
* 
* @package General
* @subpackage province
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/province/
*/

    /////////Css For Popup View//////////
    echo $css;
?>

<?php
    /////////Javascript For Popup View//////////
    echo $js;
?>
<base href="<?php echo base_url(); ?>" />
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    
    //$("table tr td").css("float","right");
    
})});    
</script>
<script type="text/javascript">
  jQuery(function($) {
 
    var galleries = $('.ad-gallery').adGallery();
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
  });
  </script>  
    
<style>
   /*  banner*/

.ad-gallery {
  width: 400px;
  background:url(../jquery.ad-gallery2/bg.png)  repeat-x bottom;
  height:210px;
}
.ad-gallery, .ad-gallery * {
  margin: 0;
  padding: 0;
}
  .ad-gallery .ad-image-wrapper {
    width: 100%;
    height: 160px;
    margin-bottom: 10px;
    position: relative;
    overflow: hidden;
  }
    .ad-gallery .ad-image-wrapper .ad-loader {
      position: absolute;
      z-index: 10;
      top: 48%;
      left: 48%;
      border: 1px solid #CCC;
    }
    .ad-gallery .ad-image-wrapper .ad-next {
      position: absolute;
      right: 0;
      top: 0;
      width: 25%;
      height: 100%;
      cursor: pointer;
      display: block;
      z-index: 100;
    }
    .ad-gallery .ad-image-wrapper .ad-prev {
      position: absolute;
      left: 0;
      top: 0;
      width: 25%;
      height: 100%;
      cursor: pointer;
      display: block;
      z-index: 100;
    }
    .ad-gallery .ad-image-wrapper .ad-prev, .ad-gallery .ad-image-wrapper .ad-next {
      /* Or else IE will hide it */
      background: url(non-existing.jpg)\9
    }
      .ad-gallery .ad-image-wrapper .ad-prev .ad-prev-image, .ad-gallery .ad-image-wrapper .ad-next .ad-next-image {
        background: url(images/slide/images/ad_prev.png);
        width: 30px;
        height: 30px;
        display: none;
        position: absolute;
        top: 47%;
        left: 0;
        z-index: 101;
      }
      .ad-gallery .ad-image-wrapper .ad-next .ad-next-image {
        background: url(images/slide/images/ad_next.png);
        width: 30px;
        height: 30px;
        right: 0;
        left: auto;
      }
    .ad-gallery .ad-image-wrapper .ad-image {
      position: absolute;
      overflow: hidden;
      top: 0;
      left: 0;
      z-index: 9;
    }
      .ad-gallery .ad-image-wrapper .ad-image a img {
        border: 0;
      }
      .ad-gallery .ad-image-wrapper .ad-image .ad-image-description {
        position: absolute;
        bottom: 0px;
        left: 0px;
        padding: 7px;
        text-align: left;
        width: 100%;
        z-index: 2;
        background: url(opa75.png);
        color: #000;
      }
      * html .ad-gallery .ad-image-wrapper .ad-image .ad-image-description {
        background: none;
        filter:progid:DXImageTransform.Microsoft.AlphaImageLoader (enabled=true, sizingMethod=scale, src='opa75.png');
      }
        .ad-gallery .ad-image-wrapper .ad-image .ad-image-description .ad-description-title {
          display: block;
        }
  .ad-gallery .ad-controls {
    height: 20px;
  }
    .ad-gallery .ad-info {
      float: left;
    }
    .ad-gallery .ad-slideshow-controls {
      float: right;
    }
      .ad-gallery .ad-slideshow-controls .ad-slideshow-start, .ad-gallery .ad-slideshow-controls .ad-slideshow-stop {
        padding-left: 5px;
        cursor: pointer;
      }
      .ad-gallery .ad-slideshow-controls .ad-slideshow-countdown {
        padding-left: 5px;
        font-size: 0.9em;
      }
    .ad-gallery .ad-slideshow-running .ad-slideshow-start {
      cursor: default;
      font-style: italic;
    }
  .ad-gallery .ad-nav {
    width:100%;
    position: relative;
    float:left;
  }
    .ad-gallery .ad-forward, .ad-gallery .ad-back {
      position: absolute;
      top: 0;
      height: 100%;
      z-index: 10;
    }
    /* IE 6 doesn't like height: 100% */
    * html .ad-gallery .ad-forward, .ad-gallery .ad-back {
      height: 100px;
    }
    .ad-gallery .ad-back {
      cursor: pointer;
      left: -20px;
      width: 13px;
      display: block;
      background:url(images/slide/images/ad_scroll_back.png) 0px 15px no-repeat;
    }
    .ad-gallery .ad-forward {
      cursor: pointer;
      display: block;
      right: -20px;
      width: 13px;
      background:url(images/slide/images/ad_scroll_forward.png) 0px 15px no-repeat;
    }
    .ad-gallery .ad-nav .ad-thumbs {
      overflow: hidden;
      width: 100%;
    }
      .ad-gallery .ad-thumbs .ad-thumb-list {
        float: left;
        width: 9000px;
        list-style: none;
      }
        .ad-gallery .ad-thumbs li {
          float: left;
          padding-right: 5px;
        }
          .ad-gallery .ad-thumbs li a {
            display: block;
    
          }
            .ad-gallery .ad-thumbs li a img {
              border: 1px solid #CCC;
              display: block;
      padding:2px;
      width:56px; height:33px;
            }
            .ad-gallery .ad-thumbs li a.ad-active img {
              border: 1px solid #dddddd;
            }
/* Can't do display none, since Opera won't load the images then */
.ad-preloads {
  position: absolute;
  left: -9000px;
  top: -9000px;
}
.left_photo{width:322px; float:left; margin:5px 0 0 10px;}
.left_photo ul li{ margin-right:17px; float:left; list-style:none;}
.left_photo ul li img{ border:none;}
</style>
<div>

    <p>&nbsp;</p>
    <div id="div_err">
        <?php
          show_msg();  
        ?>
    </div>     
    <div >
    <? /*****Modify Section Starts*******/?>
    <div  style="float: left;  width: 45%;">
      <table  border="0" cellspacing="0" cellpadding="0">
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Basic Informaion</strong></td></tr>
            <tr><td width="44%"><strong>Property ID :</strong></td><td>#1999</td></tr>
            <tr><td><strong>Property Name :</strong></td><td>Lorem Ipsum</td></tr>
            <tr><td><strong>Owner Name :</strong></td><td>Lorem Ipsum</td></tr>
            <tr><td><strong>Owner Email :</strong></td><td>Lorem Ipsum</td></tr>
            
            <tr><td colspan="2">&nbsp;<td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Location</strong></td></tr>
            
            <tr><td><strong>City :</strong></td><td>Lorem Ipsum</td></tr>
            <tr><td><strong>State :</strong></td><td>Lorem Ipsum</td></tr>
            <tr><td><strong>Country :</strong></td><td>Lorem Ipsum</td></tr>
            <tr><td><strong>Zipcode :</strong></td><td>Lorem Ipsum</td></tr>
            
            <tr><td colspan="2">&nbsp;<td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;" ><strong>Feature/Facilities</strong></td></tr>
            <tr><td><strong>Accommdation :</strong></td><td>Private Room</td></tr>
            <tr><td><strong>Property Type :</strong></td><td>House</td></tr>
            <tr><td><strong>Guests :</strong></td><td>5</td></tr>
            <tr><td><strong>Bed Type :</strong></td><td>Floor</td></tr>
            <tr><td><strong>Bed Rooms :</strong></td><td>2</td></tr>
            <tr><td><strong>Bath Rooms :</strong></td><td>3</td></tr>
            <tr><td><strong>Aminities :</strong></td><td>TV, Kitchen,Wireless Internet</td></tr>
            
            <tr><td colspan="2">&nbsp;<td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Price</strong></td></tr>
            <tr><td><strong>Standard Price :</strong></td><td>$49</td></tr>
            <tr><td><strong>Weekly Rate :</strong></td><td>$249</td></tr>
            <tr><td><strong>Monthly Rate :</strong></td><td>$999</td></tr>
            <tr><td><strong>Additional Guests :</strong></td><td>$19</td></tr>
            
            
            <tr><td colspan="2">&nbsp;<td></tr>
            <tr><td colspan="2" style="background-color: #D0D0D0;"><strong>Condition</strong></td></tr>
            <tr><td><strong>Check in After :</strong></td><td>22-06-2012</td></tr>
            <tr><td><strong>Check in Before :</strong></td><td>22-06-2012</td></tr>
            <tr><td><strong>Cancellation Policy :</strong></td><td>Strict</td></tr>
            
     

      </table>
      </div>
      <div  style="float: right;  width: 54%; " >
            <div id="container">
          <div id="gallery" class="ad-gallery">
            <div class="ad-image-wrapper"> </div>
            <div class="ad-nav" >
              <div class="ad-thumbs">
                <ul class="ad-thumb-list">
                  
                  <li> <a href="images/slide/images/1.jpg"><img src="images/slide/images/thumbs/t1.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="images/slide/images/2.jpg"><img src="images/slide/images/thumbs/t2.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="images/slide/images/3.jpg"><img src="images/slide/images/thumbs/t3.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="images/slide/images/4.jpg"><img src="images/slide/images/thumbs/t4.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="images/slide/images/5.jpg"><img src="images/slide/images/thumbs/t5.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="images/slide/images/6.jpg"><img src="images/slide/images/thumbs/t6.jpg" alt=""  title="" /> </a> </li>
                  <li> <a href="images/slide/images/7.jpg"><img src="images/slide/images/thumbs/t7.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="images/slide/images/8.jpg"><img src="images/slide/images/thumbs/t8.jpg" alt=""  title="" /></a> </li>
                  <li> <a href="images/slide/images/9.jpg"><img src="images/slide/images/thumbs/t9.jpg" alt=""  title="" /></a> </li>   
                </ul>
              </div>
            </div>
            <div class="spacer"></div>
          </div>
        </div>
        <div class="spacer"></div> 
         <div  style="margin-top: 5px;;" >
         <table>
         <tr><td style="background-color: #D0D0D0;"><strong>Description </strong></td></tr>
         <tr><td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><p> Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popul</p></td></tr>
         <tr><td>&nbsp;</td></tr>
         <tr><td style="background-color: #D0D0D0;"><strong>House Rules </strong></td></tr>
         <tr><td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p><p> Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popul</p></td></tr>
         </table>
         </div>
        
      </div>
    <? /*****end Modify Section*******/?>      
    </div>

</div>
