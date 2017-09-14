 <!-- Footer_start -->
  <div id="footer">
    <?php 
     if (count($cmsPages)>0){         
        foreach ($cmsPages as $cmsRow){
            if ($cmsRow['category'] == 'Main'){
    ?>
    <ul>
      <li><a href="pages/<?php echo $cmsRow['seourl'];?>"><?php echo $cmsRow['page_name'];?></a></li>
    </ul>
    <!--<ul>
      <li><a href="javascript:">Terms and conditions</a></li>
    </ul>
    <ul>
      <li><a href="javascript:">Contact Us</a></li>
    </ul>
    <ul>
      <li><a href="javascript:">Privacy</a></li>
    </ul>-->
    <?php }} } ?>
    <p class="social-media"> <span><a href="javascript:" class="facebook">Facebook</a></span> <span><a href="javascript:" class="twitter">Twitter</a></span> <span><a href="javascript:" class="pinterest">Pinterest</a></span> </p>
    <p class="copyright"><?php echo $footer?></p>
  </div>
  <!-- Footer_end  --> 
</div>
<!--- container --->
				
</body>
</html>