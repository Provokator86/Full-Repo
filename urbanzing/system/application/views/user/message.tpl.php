<div class="sign_up">
        <h1>Message</h1>
        <div class="margin15"></div>
        <h2><?=$message_page_text[0]['title']?></h2>
        <div class="margin15"></div>
        <?=html_entity_decode($message_page_text[0]['description'])?>

        <div class="margin15"></div>
        <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
        
        

        
   </div>