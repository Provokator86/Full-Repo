<?php

include("Base_class.php");

class getallcontacts extends Base_class {

    private $login_ok=false;
    public $showContacts=true;
    public $internalError=false;

    public $debug_array=array(
      'login_post'=>'Auth=',
      'contact_xml'=>'xml'
    );

    public function getGmailContacts($user,$pass) {
        $this->resetDebugger();
        $this->service='gmail';
        $this->service_user=$user;
        $this->service_password=$pass;
        if (!$this->init()) return false;

        $post_elements=array('accountType'=>'HOSTED_OR_GOOGLE','Email'=>$user,'Passwd'=>$pass,
                             'service'=>'cp','source'=>'OpenInviter-OpenInviter-'.$this->base_version);
        $res=$this->post("https://www.google.com/accounts/ClientLogin",$post_elements,true);
		if(strstr($res,'Error=BadAuthentication') == false) {
			$auth=substr($res,strpos($res,'Auth=')+strlen('Auth='));
	
			$contactsRawData=$this->get("http://www.google.com/m8/feeds/contacts/default/full?max-results=10000",
										true,false,true,false,array("Authorization"=>"GoogleLogin auth={$auth}"));
			$res = $contactsRawData;
			$contacts=array();
			$doc=new DOMDocument();libxml_use_internal_errors(true);if (!empty($res)) $doc->loadHTML($res);libxml_use_internal_errors(false);
			$xpath=new DOMXPath($doc);$query="//entry";$data=$xpath->query($query);
			foreach ($data as $node) 
				{
				$entry_nodes=$node->childNodes;
				$tempArray=array();	
				foreach($entry_nodes as $child)
					{ 
					$domNodesName=$child->nodeName;
					switch($domNodesName)
						{
						case 'title' : { $tempArray['first_name']=$child->nodeValue; } break;
						case 'organization': { $tempArray['organization']=$child->nodeValue; } break;
						case 'email' : 
							{ 
							if (strpos($child->getAttribute('rel'),'home')!==false)
								$tempArray['email_1']=$child->getAttribute('address');
							elseif(strpos($child->getAttribute('rel'),'work')!=false)  	
								$tempArray['email_2']=$child->getAttribute('address');
							elseif(strpos($child->getAttribute('rel'),'other')!==false)  	
								$tempArray['email_3']=$child->getAttribute('address');
							} break;
						case 'phonenumber' :
							{
							if (strpos($child->getAttribute('rel'),'mobile')!==false)
								$tempArray['phone_mobile']=$child->nodeValue;
							elseif(strpos($child->getAttribute('rel'),'home')!==false)  	
								$tempArray['phone_home']=$child->nodeValue;	
							elseif(strpos($child->getAttribute('rel'),'work_fax')!==false)  	
								$tempArray['fax_work']=$child->nodeValue;
							elseif(strpos($child->getAttribute('rel'),'pager')!=false)  	
								$tempArray['pager']=$child->nodeValue;
							} break;
						case 'postaladdress' :
							{
							if (strpos($child->getAttribute('rel'),'home')!==false)
								$tempArray['address_home']=$child->nodeValue;
							elseif(strpos($child->getAttribute('rel'),'work')!==false)  	
								$tempArray['address_work']=$child->nodeValue;
							} break;	
						}
					}
				if (!empty($tempArray['email_1']))$contacts[$tempArray['email_1']]=$tempArray;
				if(!empty($tempArray['email_2'])) $contacts[$tempArray['email_2']]=$tempArray;
				if(!empty($tempArray['email_3'])) $contacts[$tempArray['email_3']]=$tempArray;
				}
			foreach ($contacts as $email=>$name) if (!$this->isEmail($email)) unset($contacts[$email]);
			return $contacts;
		} else {
		 	return false;
		}
    }

    public function getYahooContacts($user,$pass) {
        $this->resetDebugger();
        $this->service='yahoo';
        $this->service_user=$user;
        $this->service_password=$pass;
        if (!$this->init()) return false;

        $res=$this->get("https://login.yahoo.com/config/mail?.intl=us&rl=1");
        $post_elements=$this->getHiddenElements($res); 
        $post_elements["save"]="Sign+In";
        $post_elements['login']=$user;
        $post_elements['passwd']=$pass;
        $res=htmlentities($this->post("https://login.yahoo.com/config/login?",$post_elements,true));

        $this->login_ok=$this->login_ok="http://address.mail.yahoo.com/?_src=&VPC=print";
        $url=$this->login_ok;

        $res=$this->get($url,true);

        $post_elements=array('VPC'=>'print',
                             'field[allc]'=>1,
                             'field[catid]'=>0,
                             'field[style]'=>'detailed',
                             'submit[action_display]'=>'Display for Printing'
                            );
        $res=$this->post("http://address.mail.yahoo.com/?_src=&VPC=print",$post_elements);
		if(strstr($res,'<tr class="phead">') != false) {
			$emailA=array();$bulk=array();
			$res=str_replace(array('  ','	',PHP_EOL,"\n","\r\n"),array('','','','',''),$res);
			preg_match_all("#\<tr class\=\"phead\"\>\<td colspan\=\"2\"\>(.+)\<\/tr\>(.+)\<div class\=\"first\"\>\<\/div\>\<div\>\<\/div\>(.+)\<\/div\>#U",$res,$bulk);
			
			if (!empty($bulk)) {
				foreach($bulk[1] as $key=>$bulkName) {
					$nameFormated=trim(strip_tags($bulkName));
					if (preg_match('/\&nbsp\;\-\&nbsp\;/',$nameFormated))  {
							$emailA=explode('&nbsp;-&nbsp;',$nameFormated);
							if (!empty($emailA[1])) $contacts[$emailA[1].'@yahoo.com']=array('first_name'=>$emailA[0],'email_1'=>$emailA[1].'@yahoo.com');
					}
					elseif (!empty($bulk[3][$key])) { $email=strip_tags(trim($bulk[3][$key])); $contacts[$email]=array('first_name'=>$nameFormated,'email_1'=>$email); }
				}
			}
	
			return $contacts;
		} else {
		 	return false;
		}
    }

   //NOT YET FINISHED.
   public function getRediffContacts($user,$pass) {
     $this->resetDebugger();
	 $this->service='rediff';
	 $this->service_user=$user;
	 $this->service_password=$pass;
	 if (!$this->init()) return false;
	 $post_elements=array("login"=>"{$user}",
							"passwd"=>"{$pass}",
							"FormName"=>"existing");
	 $res=htmlentities($this->post("http://mail.rediff.com/cgi-bin/login.cgi",$post_elements,true));
	 $link_to_extract = $this->getElementString($res, 'window.location.replace(&quot;', '&quot;);');
	 $this->siteAddr = $this->getElementString($link_to_extract,'http://','/');
	 $this->username = $user;
	 $this->sess_id = $this->getElementString($link_to_extract,'&amp;session_id=','&amp;');					
	 $url_redirect = "http://{$this->siteAddr}/bn/toggle.cgi?flipval=1&login={$this->username}&session_id={$this->sess_id}&folder=Inbox&formname=sh_folder&user_size=1";
	 $res = ($this->get($url_redirect, true));
	 $url_contact="http://{$this->siteAddr}/prism/exportaddrbook?output=web";
	 $this->login_ok = $url_contact;
	 $url=$this->login_ok;
	 if(strstr($url,'http://f6plus.rediff.com/prism') != false) {
	 $res=$this->get($url);
	 $post_elements=array('output'=>'web','els'=>$this->getElementString($res,'name="els" value="','"'),'exporttype'=>'outlook');		
	 $form_action="http://{$this->siteAddr}/prism/exportaddrbook?service=outlook";
	 $res=$this->post($form_action,$post_elements);
	 $temp=$this->parseCSV($res);
	 $contacts=array();
	 foreach ($temp as $values)
		{
		$name=$values['0'].(empty($values['1'])?'':(empty($values['0'])?'':'-')."{$values['1']}").(empty($values['3'])?'':" \"{$values['3']}\"").(empty($values['2'])?'':' '.$values['2']);
		if (!empty($values['5']))
			$contacts[$values['5']]=array('first_name'=>$name,'email_1'=>$values['5']);			
		}
			
	 foreach ($contacts as $email=>$name) if (!$this->isEmail($email)) unset($contacts[$email]);
	 return $contacts;	
	 }else{
	  return false;
	 }
   }
   
  public function getHotmailContacts($user,$pass) {
    $this->resetDebugger();
	$this->service='hotmail';
	$this->service_user=$user;
	$this->service_password=$pass;
	$this->init();
	//if (!$this->init()) return false;
	$res=$this->get("http://login.live.com/login.srf?id=2",true);
	$post_action=$this->getElementString($res,'method="POST" target="_top" action="','"');
	$post_elements=$this->getHiddenElements($res);
	$post_elements["LoginOptions"]=3;
	$post_elements["login"]=$user;
	$post_elements["passwd"]=$pass;
	$res=$this->post($post_action,$post_elements,true);
	if(strstr($res,'http://www.hotmail.msn.com/cgi-bin/sbox') != false) {
		$url_redirect=$this->getElementString($res,'.location.replace("','"');
		$res=$this->get($url_redirect,true);
		
		if(strpos($res,"self.location.href = '")!==false)
		 {
				$url_redirect=urldecode(str_replace('\x', '%',$this->getElementString($res,"self.location.href = '","'")));
				$base_url="http://".$this->getElementString($url_redirect,'http://','mail/');
				$res=$this->get($url_redirect,true);
		 }
		if (strpos($res,'MessageAtLoginForm')!==false)
		{ 
				$form_action=$base_url.'mail/'.html_entity_decode($this->getElementString($res,'method="post" action="','"'));
				$post_elements=$this->getHiddenElements($res);$post_elements['TakeMeToInbox']='Continue';
				$res=$this->post($form_action,$post_elements,true);
		}
		$this->login_ok=$base_url;
		$res=$this->get("{$base_url}mail/EditMessageLight.aspx?n=");
		$urlContacts="{$base_url}mail/ContactList.aspx".$this->getElementString($res,'ContactList.aspx','"');
		$res=$this->get($urlContacts);
		$contacts=array();
			$bulkStringArray=explode("['",$res);unset($bulkStringArray[0]);unset($bulkStringArray[count($bulkStringArray)]);
			foreach($bulkStringArray as $stringValue)
				{
				$stringValue=str_replace(array("']],","'"),'',$stringValue);
				if (strpos($stringValue,'0,0,0,')!==false) 
					{
					$tempStringArray=explode(',',$stringValue);
					if (!empty($tempStringArray[2])) $name=html_entity_decode(urldecode(str_replace('\x', '%', $tempStringArray[2])),ENT_QUOTES, "UTF-8");
					}
				else
					{
					$emailsArray=array();$emailsArray=explode('\x26\x2364\x3b',$stringValue);
					if (count($emailsArray)>0) 
						{
						//get all emails
						$bulkEmails=explode(',',$stringValue);
						if (!empty($bulkEmails)) foreach($bulkEmails as $valueEmail)
							{ $email=html_entity_decode(urldecode(str_replace('\x', '%', $valueEmail))); if(!empty($email)) { $contacts[$email]=array('first_name'=>(!empty($name)?$name:false),'email_1'=>$email);$email=false; } }
						$name=false;	
						}	
					}
				}
		if (!empty($contacts[$this->service_user])) unset($contacts[$this->service_user]);
		foreach ($contacts as $email=>$name) if (!$this->isEmail($email)) unset($contacts[$email]);
		return $contacts;
	} else {
	 	return false;
	}
  }
	
}

/*$contacts = new getallcontacts;
echo 'GMAIL';
echo '<pre>';
print_r($contacts->getGmailContacts('dynamichydra@gmail.com','rubel123'));
echo '</pre>';

/*echo '<br /><br />YAHOO';
echo '<pre>';
print_r($contacts->getYahooContacts('',''));
echo '</pre>';

echo '<br /><br />HOTMAIL';
echo '<pre>';
print_r($contacts->getHotmailContacts('',''));
echo '</pre>';*/

/*echo '<br /><br />REDIFFMAIL';
echo '<pre>';
print_r($contacts->getRediffContacts('',''));
echo '</pre>';
*/