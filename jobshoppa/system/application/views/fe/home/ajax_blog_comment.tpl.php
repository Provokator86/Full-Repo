
                    <h6>All Comments</h6>
                    <?php
                    if($all_comments) 
                    {
                        foreach($all_comments as $key=>$val)
                        {
                            if($key & 1) //////Checking even and odd
                            {
                    ?>
                      <div class="single_comment"> 
                        <p><?php echo $val['s_comment']; ?></p>
                        <h2>- <?php echo $val['s_name']; ?> <br />
                            <span><?php echo $val['dt_created_on']; ?></span></h2>
                    </div>
                    <?php     
                            }
                            else
                            {
                    ?>
                    <div class="single_comment grey_back">
                        <p><?php echo $val['s_comment']; ?></p>
                        <h2>- <?php echo $val['s_name']; ?> <br />
                            <span><?php echo $val['dt_created_on']; ?></span></h2>
                    </div>
                    <?php
                            }
                        }
                    }
                    ?>
                    
                    <div class="clr"></div>
                    <div class="paging_box" style="padding-top:10px;">
                          <?php echo $page_links;?>   
                    </div>

                    
                    <div class="clr"></div>
