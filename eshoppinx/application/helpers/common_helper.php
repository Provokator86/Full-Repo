<?php
/**
* Displays the pre-formatted array 
* @param mix $mix_arr
* @param int $i_then_exit
* @return void
*/

function pr($mix_arr = array(), $i_then_exit = 0)
{
    try
        {
             echo '<pre>';
            print_r($mix_arr);
            echo '</pre>';
            unset($mix_arr);
            if($i_then_exit)
            {
                exit();
            }
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}

/**
* Displays the pre-formatted array with array element type
* @param mix $mix_arr
* @param int $i_then_exit
* @return void
*/

function vr($mix_arr = array(), $i_then_exit = 0)
{

    try
        {
             echo '<pre>';
            var_dump($mix_arr);
            echo '</pre>';
            unset($mix_arr);
            if($i_then_exit)
            {
                exit();
            }

        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}

/****
* Function to compare string
*
*****/
function my_receive($str)
{
    try
    {  
        return addslashes(trim($str));
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}

/****
* Function to show string
*
*****/
function my_show($str)
{
    try
    {  
        return htmlspecialchars($str);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}

function now()
{
    $CI    = &get_instance();
    $rslt  =   $CI->db->query("SELECT NOW() AS now")->row_array();
    return $rslt['now'];    
}

/*
+-----------------------------------------------+
| Set congfiguration for front end pagination     |
+-----------------------------------------------+
| Added by mm on 13 Jan 2015                    |
+-----------------------------------------------+
*/
function fe_ajax_pagination($ctrl_path = '',$total_rows = 0, $start, $limit = 0, $paging_div = '')
{
    $CI =   &get_instance();
    $CI->load->library('jquery_pagination');
    
    $config['base_url']     = $ctrl_path;
    $config['total_rows']     = $total_rows;
    $config['per_page']     = $limit;
    $config['cur_page']     = $start;
    $config['uri_segment']     = 0;
    $config['num_links']     = 3;
    $config['page_query_string'] = false;    
    $config['full_tag_open'] = '<ul>';
    $config['full_tag_close'] = '</ul>';    
    
    $config['prev_link'] = '&laquo; ';
    $config['next_link'] = ' &raquo;';
    
    $config['num_tag_open'] = '';
    $config['num_tag_close'] = '';
    $config['cur_tag_open'] = '<li><a class="select">';
    $config['cur_tag_close'] = '</a></li>';
    
    $config['next_tag_open'] = '';
    $config['next_tag_close'] = '';
    $config['prev_tag_open'] = '';
    $config['prev_tag_close'] = '';     
       
    $config['first_link'] = '&laquo; First';
    $config['last_link'] = ' Last&raquo;';
    
    $config['div'] = '#'.$paging_div;
    
    $CI->jquery_pagination->initialize($config);
    return $CI->jquery_pagination->create_links();
}

function select_chain_category_ids($cat_id=0) 
{    
    $CI = & get_instance();
    $sql = "SELECT id FROM ".CATEGORY." WHERE rootID IN({$cat_id}) ";    
    //echo '</br>';
    $rs  = $CI->db->query($sql);
    $sttr = "";
    $sttr1 = '';
    if($rs->num_rows()>0)
    {
      foreach($rs->result() as $row)
      {
          //echo $row->i_id;echo '</br>';
            if($sttr1=='')         
                $sttr1 = $row->id;    
            else     
                  $sttr1 = $sttr1.','.$row->id;    
      }
      //echo '</br>'.$sttr;
      $sttr = $sttr.select_chain_category_ids($sttr1);
      
    }
    else
    {
        return $cat_id;
    }
    
    return $cat_id.','.$sttr;
   
}

function getCategoryName($cat_id='')
{
    $CI = &get_instance();
    $ret_=0;
    if($cat_id!='')        
    {
        $sql = "SELECT cat_name FROM ".CATEGORY." WHERE id ='".$cat_id."' "; 
        $rs=$CI->db->query($sql); 
        $res = $rs->result_array();
        $ret_ = $res[0]["cat_name"];            
    }
    return $ret_;
}

function get_category_id($s_url='') 
{    
    $CI = & get_instance();
    $sql = "SELECT id,cat_name FROM ".CATEGORY." WHERE seourl = '".addslashes(trim($s_url))."' ";    
    $rs  = $CI->db->query($sql);
    $cat_id = "";        
    if($rs->num_rows()>0)
    {
      foreach($rs->result() as $row)
      {
              $cat_id = $row->id;                
      }      
    }
   
    return $cat_id;
}

/**
* For geting extension of a file
* @param string $s_filename
* @return string
*/

function getExtension($s_filename = '')
{
    try
        {
            if(empty($s_filename))
            return FALSE;
            $mix_matches = array();
            preg_match('/\.([^\.]*)$/', $s_filename, $mix_matches);
            unset($s_filename);        
            return strtolower($mix_matches[0]);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
}

/**
* For geting filename without extension of a file
* @param string $s_filename
* @return string
*/

function getFilenameWithoutExtension($s_filename = '')
{
    try
        {
             if(empty($s_filename))
            return FALSE;

            $mix_matches = array();
            preg_match('/(.+?)(\.[^.]*$|$)/', $s_filename, $mix_matches);
            unset($s_filename);
            $entities = array(" ",'.','!', '*', "'","-", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]", "!");
            //$s_new_filename = str_replace($entities,"_",$mix_matches[1]);
            
            //$s_new_filename = str_replace($entities,"_",$mix_matches[1]).'_'.time();
            $s_new_filename = str_replace($entities,"_",$mix_matches[1]).'_'.time();
            return strtolower($s_new_filename);
             
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}
