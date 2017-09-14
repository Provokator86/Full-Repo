<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of couponApi
 *
 * @author user
 */
namespace CouponApi;
use XML_To_Array\XML_Array;
use Helper;

class couponApi {
    //put your code here
    private $xmlToArryObj;
    private $feedMeta;
    private $tempFile;
    private $fileDir;


    public function __construct() {
        
        $this->xmlToArryObj = new XML_Array();
        $this->fileDir = dirname(__FILE__) . '/feed_dump/';
        $this->tempFile = $this->fileDir.'localfile.tmp';
        $this->omgCouponUrl = 'http://admin.omgpm.com/v2/Reports/Affiliate/ProgrammesExport.aspx?Agency=95&Country=26&Affiliate=519376&Search=&Sector=0&UidTracking=False&PayoutTypes=&ProductFeedAvailable=False&Format=XML&AuthHash=7EF2CBA5FD38DEC5D11B2BE81AD47190&AuthAgency=95&AuthContact=519376&ProductType=';
        /**coupon data*/
        $this->feedMeta = array(
            'ghadiwala'=>array(
                'file'=>$this->fileDir.'ghadiwala.xml',
                'url'=>'http://www.ghadiwala.com/feeds/feed.xml'
                ),
             'snapDeal'=>array(
                'file'=>$this->fileDir.'snapdeal.xml',
                'url'=>'http://www.snapdeal.com/api/rest/xml/getproductdeals?apikey=b96524f6af234937a717f1d1855b5aa9&category=364'
                ),
             'homeShop18'=>array(
                'file'=>$this->fileDir.'hs18products.xml',
                'url'=>'www.homeshop18.com/feeds/hs18products.xml'
                ),
             'indiatimes'=>array(
                'file'=>$this->fileDir.'indiatimes.xml',
                'url'=>'http://shopping.indiatimes.com/googlefeed.xml'
                ),
             'greendust'=>array(
                'file'=>$this->fileDir.'greendust.xml',
                'url'=>'http://greendust.com/feed.php'
                ),
            'shopclues'=>array(
                'file'=>$this->fileDir.'shopclues.csv',
                'url'=>'http://admin.shopclues.com/tools/feed.php'
                ), 
            'yebhi'=>array(
                'file'=>$this->fileDir.'yebhi.xml',
                'url'=>'http://na.bigshoebazaar.com/feeds/google-feeds_test.xml'
                ),
            );
    }
    
    private function getCurl($url = NULL){
           if($url){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Coupon Request');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
                $head = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch); 
                return $httpCode;
           }
            echo 0;
    }
    
    private function downloadFile($url, $tempFile = NULL) {
        try {
            if($tempFile == NULL){
                $tempFile = $this->tempFile ;
            }
            set_time_limit(0);
            $fp = fopen ($tempFile, 'w+');//This is the file where we save the    information
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 250);
            curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
            curl_exec($ch); // get curl response
            curl_close($ch);
            fclose($fp);
            return TRUE;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return FALSE;
        }
           
    }
    
    private function getData($storeName = NULL){
        return file_get_contents($this->feedMeta[$storeName]['file']);
    }

    /**
     * implemented successfully
     */
    
    public function ghadiwala(){
        $stdArray = array();
        $xmlData = $this->getData('ghadiwala');
        $arrayData = $this->xmlToArryObj->xml_to_array($xmlData);
       // pr($arrayData);
        foreach ($arrayData['rss']['_child']['product'] as $key => $feedValue) {
            
            /*1*/$stdArray['productFeed'][$key]['offer_group_id'] =  '';
            /*2*/$stdArray['productFeed'][$key]['offer_id'] =  '';
            
            /*3*/$stdArray['productFeed'][$key]['product_id']            =  @$feedValue['_child']['id']['_value'];
            /*4*/$stdArray['productFeed'][$key]['product_title']         =  @$feedValue['_child']['title']['_value'];
            
            /*5*/$stdArray['productFeed'][$key]['start_date']            =  '';
            /*6*/$stdArray['productFeed'][$key]['end_date']              =  '';
            
            /*7*/$stdArray['productFeed'][$key]['discount']              =  '';
            /*8*/$stdArray['productFeed'][$key]['maximum_retail_price']  =  @$feedValue['_child']['mrp']['_value'];
            /*9*/$stdArray['productFeed'][$key]['selling_price']         =  @$feedValue['_child']['price']['_value'];

            /*10*/$stdArray['productFeed'][$key]['imageurl']             =  @$feedValue['_child']['image']['_value'];
            /*11*/$stdArray['productFeed'][$key]['product_page_url']     =  @$feedValue['_child']['url']['_value'];
            
            /*12*/$stdArray['productFeed'][$key]['product_brand']        =  '';
            /*13*/$stdArray['productFeed'][$key]['cod_available']        =  '';
            /*14*/$stdArray['productFeed'][$key]['available']            =  '';
            /*15*/$stdArray['productFeed'][$key]['emi_available']        =  '';
            /*16*/$stdArray['productFeed'][$key]['model']                =  @$feedValue['_child']['model']['_value'];
            
            /*17*/$stdArray['productFeed'][$key]['category']            =  '';
            /*18*/$stdArray['productFeed'][$key]['category_id']         =  '';
            /*19*/$stdArray['productFeed'][$key]['subcategory']         =  '';
            /*20*/$stdArray['productFeed'][$key]['subcategory_id']      =  '';
            /*21*/$stdArray['productFeed'][$key]['istv']                =  '';
            /*22*/$stdArray['productFeed'][$key]['rank']                =  '';
            /*23*/$stdArray['productFeed'][$key]['stock']               =  '';
        
            /*24*/$stdArray['productFeed'][$key]['dispatch-days']       =  '';
            /*25*/$stdArray['productFeed'][$key]['warranty']            =  '';
            /*26*/$stdArray['productFeed'][$key]['return-policy']       =  '';
            /*27*/$stdArray['productFeed'][$key]['condition']           =  '';
            /*28*/$stdArray['productFeed'][$key]['store']               =  'ghadiwala';
            
        }
        return $stdArray;       
    }
     
    public function snapDeal(){
        $stdArray = array();
        $xmlData = $this->getData('snapDeal');
        $arrayData = $this->xmlToArryObj->xml_to_array($xmlData);
        foreach ($arrayData['GetProductDealsResponse']['_child']['product_List']['_child']['product_offer_group'] as $key => $feedValue) {
            
            /*1*/$stdArray['productFeed'][$key]['offer_group_id']       =  @$feedValue['_child']['product_offer_group_id']['_value'];
            /*2*/$stdArray['productFeed'][$key]['offer_id']             =  @$feedValue['_child']['product_offer_id']['_value'];
          
            /*3*/$stdArray['productFeed'][$key]['product_id']           =  '';
            /*4*/$stdArray['productFeed'][$key]['product_title']        =  @$feedValue['_child']['product_title']['_value'];
            
            /*5*/$stdArray['productFeed'][$key]['start_date']           =  @isset($feedValue['_child']['start_date']['_value'])?$feedValue['_child']['start_date']['_value']:'';
            /*6*/$stdArray['productFeed'][$key]['end_date']             =  @$feedValue['_child']['end_date']['_value'];
            
            /*7*/$stdArray['productFeed'][$key]['discount']             =  @$feedValue['_child']['discount']['_value'];
            /*8*/$stdArray['productFeed'][$key]['maximum_retail_price'] =  '';
            /*9*/$stdArray['productFeed'][$key]['selling_price']        =  @$feedValue['_child']['selling_price']['_value'];
            
            /*10*/$stdArray['productFeed'][$key]['imageurl']            =  @$feedValue['_child']['imageurl']['_value'];
            /*11*/$stdArray['productFeed'][$key]['product_page_url']    =  @$feedValue['_child']['product_page_url']['_value'];
            
            /*11*/$stdArray['productFeed'][$key]['product_brand']       =  @$feedValue['_child']['product_brand']['_value'];
            /*13*/$stdArray['productFeed'][$key]['cod_available']       =  @$feedValue['_child']['cod_available']['_value'];
            /*14*/$stdArray['productFeed'][$key]['available']           =  @$feedValue['_child']['available']['_value'];
            /*15*/$stdArray['productFeed'][$key]['emi_available']       =  @$feedValue['_child']['emi_available']['_value'];
            /*16*/$stdArray['productFeed'][$key]['model']               =  '';
            
            /*17*/$stdArray['productFeed'][$key]['category']            =  '';
            /*18*/$stdArray['productFeed'][$key]['category_id']         =  '';
            /*19*/$stdArray['productFeed'][$key]['subcategory']         =  '';
            /*20*/$stdArray['productFeed'][$key]['subcategory_id']      =  '';
            /*21*/$stdArray['productFeed'][$key]['istv']                =  '';
            /*22*/$stdArray['productFeed'][$key]['rank']                =  '';
            /*23*/$stdArray['productFeed'][$key]['stock']               =  '';
            
            /*24*/$stdArray['productFeed'][$key]['dispatch-days']       =  '';
            /*25*/$stdArray['productFeed'][$key]['warranty']            =  '';
            /*26*/$stdArray['productFeed'][$key]['return-policy']       =  '';
            /*27*/$stdArray['productFeed'][$key]['condition']           =  '';
            /*28*/$stdArray['productFeed'][$key]['store']               =  'snapdeal';

            /*additionals*/
//            $extra = array();
//            if(isset($feedValue['_child']['highLights']['_child']['highlight'])&&count($feedValue['_child']['highLights']['_child']['highlight'])>0){
//                
//                foreach ($feedValue['_child']['highLights']['_child']['highlight'] as $highLightsKey => strip_tags($highLights)) {
//                 $extra[$highLightsKey] = $highLights['_value'];
//                }
//            
//                
//            }
            //$stdArray['productFeed'][$key]['extra']               = json_encode($extra);
        }
        return $stdArray;       
    }
    
    public function homeShop18(){
        $stdArray = array();
        $xmlData = $this->getData('homeShop18');
        $arrayData = $this->xmlToArryObj->xml_to_array($xmlData);

        foreach ($arrayData['feed']['_child']['product'] as $key => $feedValue) {
            /*1*/$stdArray['productFeed'][$key]['offer_group_id']       =  '';
            /*2*/$stdArray['productFeed'][$key]['offer_id']             =  '';
          
            /*3*/$stdArray['productFeed'][$key]['product_id']           =  @$feedValue['_child']['id']['_value'];
            /*4*/$stdArray['productFeed'][$key]['product_title']        =  @$feedValue['_child']['name']['_value'];
            
            /*5*/$stdArray['productFeed'][$key]['start_date']           =  '';
            /*6*/$stdArray['productFeed'][$key]['end_date']             =  '';
            
            /*7*/$stdArray['productFeed'][$key]['discount']             =  '';
            /*8*/$stdArray['productFeed'][$key]['maximum_retail_price'] =  @$feedValue['_child']['mrp']['_value'];
            /*9*/$stdArray['productFeed'][$key]['selling_price']        =  @$feedValue['_child']['price']['_value'];
            
            /*10*/$stdArray['productFeed'][$key]['imageurl']            =  @$feedValue['_child']['image']['_value'];
            /*11*/$stdArray['productFeed'][$key]['product_page_url']    =  @$feedValue['_child']['link']['_value'];
            
            /*11*/$stdArray['productFeed'][$key]['product_brand']       =  @$feedValue['_child']['product_brand']['_value'];
            /*13*/$stdArray['productFeed'][$key]['cod_available']       =  @$feedValue['_child']['cod_available']['_value'];
            /*14*/$stdArray['productFeed'][$key]['available']           =  @$feedValue['_child']['available']['_value'];
            /*15*/$stdArray['productFeed'][$key]['emi_available']       =  @$feedValue['_child']['emi_available']['_value'];
            /*16*/$stdArray['productFeed'][$key]['model']               =  '';
            /*17*/$stdArray['productFeed'][$key]['category']            =  @$feedValue['_child']['categoryname']['_value'];
            /*18*/$stdArray['productFeed'][$key]['category_id']         =  @$feedValue['_child']['categoryid']['_value'];
            /*19*/$stdArray['productFeed'][$key]['subcategory']         =  @$feedValue['_child']['subcatname']['_value'];
            /*20*/$stdArray['productFeed'][$key]['subcategory_id']      =  @$feedValue['_child']['subcatid']['_value'];
            /*21*/$stdArray['productFeed'][$key]['istv']                =  @$feedValue['_child']['istv']['_value'];
            /*22*/$stdArray['productFeed'][$key]['rank']                =  @$feedValue['_child']['rank']['_value'];
            /*23*/$stdArray['productFeed'][$key]['stock']               =  @$feedValue['_child']['stock']['_value'];

            /*24*/$stdArray['productFeed'][$key]['dispatch-days']       =  '';
            /*25*/$stdArray['productFeed'][$key]['warranty']            =  '';
            /*26*/$stdArray['productFeed'][$key]['return-policy']       =  '';
            /*27*/$stdArray['productFeed'][$key]['condition']           =  '';
            /*28*/$stdArray['productFeed'][$key]['store']               =  'homeshop18';

        }
        return $stdArray;       
    }
    
    public function indiatimes(){
        $stdArray = array();
        $xmlData = $this->getData('indiatimes');
        $arrayData = $this->xmlToArryObj->xml_to_array($xmlData);
       
        foreach ($arrayData['rss']['_child']['channel']['_child']['item'] as $key => $feedValue) {
            /*1*/$stdArray['productFeed'][$key]['offer_group_id']       =  '';
            /*2*/$stdArray['productFeed'][$key]['offer_id']             =  '';
          
            /*3*/$stdArray['productFeed'][$key]['product_id']           =  @$feedValue['_child']['g:id']['_value'];
            /*4*/$stdArray['productFeed'][$key]['product_title']        =  @$feedValue['_child']['title']['_value'];
            
            /*5*/$stdArray['productFeed'][$key]['start_date']           =  '';
            /*6*/$stdArray['productFeed'][$key]['end_date']             =  '';
            
            /*7*/$stdArray['productFeed'][$key]['discount']             =  '';
            /*8*/$stdArray['productFeed'][$key]['maximum_retail_price'] =  '';
            /*9*/$stdArray['productFeed'][$key]['selling_price']        =  @$feedValue['_child']['g:price']['_value'];
            
            /*10*/$stdArray['productFeed'][$key]['imageurl']            =  @$feedValue['_child']['g:image_link']['_value'];
            /*11*/$stdArray['productFeed'][$key]['product_page_url']    =  @$feedValue['_child']['link']['_value'];
            
            /*11*/$stdArray['productFeed'][$key]['product_brand']       =  @$feedValue['_child']['g:brand']['_value'];
            /*13*/$stdArray['productFeed'][$key]['cod_available']       =  '';
            /*14*/$stdArray['productFeed'][$key]['available']           =  '';
            /*15*/$stdArray['productFeed'][$key]['emi_available']       =  '';
            /*16*/$stdArray['productFeed'][$key]['model']               =  '';
            /*17*/$stdArray['productFeed'][$key]['category']            =  @$feedValue['_child']['g:product_type']['_value'];
            /*18*/$stdArray['productFeed'][$key]['category_id']         =  '';
            /*19*/$stdArray['productFeed'][$key]['subcategory']         =  @$feedValue['_child']['g:google_product_category']['_value'];
            /*20*/$stdArray['productFeed'][$key]['subcategory_id']      =  '';
            /*21*/$stdArray['productFeed'][$key]['istv']                =  '';
            /*22*/$stdArray['productFeed'][$key]['rank']                =  '';
            /*23*/$stdArray['productFeed'][$key]['stock']               =  '';
            
            /*24*/$stdArray['productFeed'][$key]['dispatch-days']       =  '';
            /*25*/$stdArray['productFeed'][$key]['warranty']            =  '';
            /*26*/$stdArray['productFeed'][$key]['return-policy']       =  '';
            /*27*/$stdArray['productFeed'][$key]['condition']           =  '';
            /*28*/$stdArray['productFeed'][$key]['store']               =  'indiatimes';
        }
        return $stdArray;       
    }
    
    public function greendust(){
        $stdArray = array();
        $xmlData = $this->getData('greendust');

        $arrayData = $this->xmlToArryObj->xml_to_array($xmlData);
        
        
        foreach ($arrayData['channel']['_child']['item'] as $key => $feedValue) {
            /*1*/$stdArray['productFeed'][$key]['offer_group_id']       =  '';
            /*2*/$stdArray['productFeed'][$key]['offer_id']             =  '';
          
            /*3*/$stdArray['productFeed'][$key]['product_id']           =  @$feedValue['_child']['SKU']['_value'];
            /*4*/$stdArray['productFeed'][$key]['product_title']        =  @$feedValue['_child']['product-name']['_value'];
            
            /*5*/$stdArray['productFeed'][$key]['start_date']           =  '';
            /*6*/$stdArray['productFeed'][$key]['end_date']             =  '';
            
            /*7*/$stdArray['productFeed'][$key]['discount']             =  '';
            /*8*/$stdArray['productFeed'][$key]['maximum_retail_price'] =  '';
            /*9*/$stdArray['productFeed'][$key]['selling_price']        =  @$feedValue['_child']['product-price']['_value'];
            
            /*10*/$stdArray['productFeed'][$key]['imageurl']            =  @$feedValue['_child']['product-image-url']['_value'];
            /*11*/$stdArray['productFeed'][$key]['product_page_url']    =  @$feedValue['_child']['product-page-url']['_value'];
            
            /*11*/$stdArray['productFeed'][$key]['product_brand']       =  @$feedValue['_child']['brand']['_value'];
            /*13*/$stdArray['productFeed'][$key]['cod_available']       =  '';
            /*14*/$stdArray['productFeed'][$key]['available']           =  '';
            /*15*/$stdArray['productFeed'][$key]['emi_available']       =  '';
            /*16*/$stdArray['productFeed'][$key]['model']               =  '';
            /*17*/$stdArray['productFeed'][$key]['category']            =  @$feedValue['_child']['category']['_value'];
            /*18*/$stdArray['productFeed'][$key]['category_id']         =  '';
            /*19*/$stdArray['productFeed'][$key]['subcategory']         =  '';
            /*20*/$stdArray['productFeed'][$key]['subcategory_id']      =  '';
            /*21*/$stdArray['productFeed'][$key]['istv']                =  '';
            /*22*/$stdArray['productFeed'][$key]['rank']                =  '';
            /*23*/$stdArray['productFeed'][$key]['stock']               =  '';

            /*24*/$stdArray['productFeed'][$key]['dispatch-days']       =  @$feedValue['_child']['dispatch-days']['_value'];
            /*25*/$stdArray['productFeed'][$key]['warranty']            =  @$feedValue['_child']['warranty']['_value'];
            /*26*/$stdArray['productFeed'][$key]['return-policy']       =  @$feedValue['_child']['return-policy']['_value'];
            /*27*/$stdArray['productFeed'][$key]['condition']           =  @$feedValue['_child']['g:condition']['_value'];
            /*28*/$stdArray['productFeed'][$key]['store']               =  'greendust';
        }
        return $stdArray;       
    }
    
    public function shopclues(){
        $stdArray = array();
        $arrayData = array();
        $csvFields =array();;
        $csvData = $this->getData('shopclues');
        $row = -1;
        if (($handle = fopen($this->feedMeta['shopclues']['file'], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                
                $row++;
                if(!$row){
                   $csvFields = $data;
                   continue;
                }
                
                /**
                 * consistency cheeck cause this file is erronious
                 * **/
                if(count($csvFields)!=$num){
                    continue;
                }
                
                for ($c=0; $c < $num; $c++) {
                    $arrayData[$row][$csvFields[$c]] = $data[$c];
                }
            }
            fclose($handle);
        }
        
        foreach ($arrayData as $key => $feedValue) {
            /*1*/$stdArray['productFeed'][$key]['offer_group_id']       =  '';
            /*2*/$stdArray['productFeed'][$key]['offer_id']             =  '';
          
            /*3*/$stdArray['productFeed'][$key]['product_id']           =  @$feedValue['Product ID'];
            /*4*/$stdArray['productFeed'][$key]['product_title']        =  @$feedValue['Product Name'];
            
            /*5*/$stdArray['productFeed'][$key]['start_date']           =  '';
            /*6*/$stdArray['productFeed'][$key]['end_date']             =  '';
            
            /*7*/$stdArray['productFeed'][$key]['discount']             =  @$feedValue['Discount (%age)'];;
            /*8*/$stdArray['productFeed'][$key]['maximum_retail_price'] =  '';
            /*9*/$stdArray['productFeed'][$key]['selling_price']        =  @$feedValue['Price'];
            
            /*10*/$stdArray['productFeed'][$key]['imageurl']            =  @$feedValue['image_path'];
            /*11*/$stdArray['productFeed'][$key]['product_page_url']    =  @$feedValue['Product URL'];
            
            /*11*/$stdArray['productFeed'][$key]['product_brand']       =  @$feedValue['Brand'];
            /*13*/$stdArray['productFeed'][$key]['cod_available']       =  '';
            /*14*/$stdArray['productFeed'][$key]['available']           =  '';
            /*15*/$stdArray['productFeed'][$key]['emi_available']       =  '';
            /*16*/$stdArray['productFeed'][$key]['model']               =  '';
            /*17*/$stdArray['productFeed'][$key]['category']            =  @$feedValue['category'];
            /*18*/$stdArray['productFeed'][$key]['category_id']         =  '';
            /*19*/$stdArray['productFeed'][$key]['subcategory']         =  '';
            /*20*/$stdArray['productFeed'][$key]['subcategory_id']      =  '';
            /*21*/$stdArray['productFeed'][$key]['istv']                =  '';
            /*22*/$stdArray['productFeed'][$key]['rank']                =  '';
            /*23*/$stdArray['productFeed'][$key]['stock']               =  '';

            /*24*/$stdArray['productFeed'][$key]['dispatch-days']       =  '';
            /*25*/$stdArray['productFeed'][$key]['warranty']            =  '';
            /*26*/$stdArray['productFeed'][$key]['return-policy']       =  '';
            /*27*/$stdArray['productFeed'][$key]['condition']           =  '';
            /*27*/$stdArray['productFeed'][$key]['store']           =  'shopclues';
        }
        return $stdArray;       
    }
    /**implemented successfully*/
    public function yebhi(){
        $stdArray = array();
        $xmlData = $this->getData('yebhi');
        $arrayData = $this->xmlToArryObj->xml_to_array($xmlData);
        foreach ($arrayData['rss']['_child']['channel']['_child']['item'] as $key => $feedValue) {
            /*1*/$stdArray['productFeed'][$key]['offer_group_id']       =  '';
            /*2*/$stdArray['productFeed'][$key]['offer_id']             =  '';
          
            /*3*/$stdArray['productFeed'][$key]['product_id']           =  @$feedValue['_child']['g:id']['_value'];
            /*4*/$stdArray['productFeed'][$key]['product_title']        =  @$feedValue['_child']['title']['_value'];
            
            /*5*/$stdArray['productFeed'][$key]['start_date']           =  '';
            /*6*/$stdArray['productFeed'][$key]['end_date']             =  '';
            
            /*7*/$stdArray['productFeed'][$key]['discount']             =  @$feedValue['_child']['g:discount_percent']['_value'];;
            /*8*/$stdArray['productFeed'][$key]['maximum_retail_price'] =  '';
            /*9*/$stdArray['productFeed'][$key]['selling_price']        =  @$feedValue['_child']['g:sale_price']['_value'];
            
            /*10*/$stdArray['productFeed'][$key]['imageurl']            =  @$feedValue['_child']['g:image_link']['_value'];
            /*11*/$stdArray['productFeed'][$key]['product_page_url']    =  @$feedValue['_child']['link']['_value'];
            
            /*11*/$stdArray['productFeed'][$key]['product_brand']       =  @$feedValue['_child']['g:brand']['_value'];
            /*13*/$stdArray['productFeed'][$key]['cod_available']       =  '';
            /*14*/$stdArray['productFeed'][$key]['available']           =  @$feedValue['_child']['g:availability']['_value'];;
            /*15*/$stdArray['productFeed'][$key]['emi_available']       =  '';
            /*16*/$stdArray['productFeed'][$key]['model']               =  @$feedValue['_child']['g:mpn']['_value'];;
            /*17*/$stdArray['productFeed'][$key]['category']            =  @$feedValue['_child']['g:google_product_category']['_value'];
            /*18*/$stdArray['productFeed'][$key]['category_id']         =  @$feedValue['_child']['g:g:item_group_id']['_value'];;
            /*19*/$stdArray['productFeed'][$key]['subcategory']         =  '';
            /*20*/$stdArray['productFeed'][$key]['subcategory_id']      =  '';
            /*21*/$stdArray['productFeed'][$key]['istv']                =  '';
            /*22*/$stdArray['productFeed'][$key]['rank']                =  '';
            /*23*/$stdArray['productFeed'][$key]['stock']               =  @$feedValue['_child']['g:quantity']['_value'];

            /*24*/$stdArray['productFeed'][$key]['dispatch-days']       =  @$feedValue['_child']['dispatch-days']['_value'];
            /*25*/$stdArray['productFeed'][$key]['warranty']            =  @$feedValue['_child']['warranty']['_value'];
            /*26*/$stdArray['productFeed'][$key]['return-policy']       =  @$feedValue['_child']['return-policy']['_value'];
            /*27*/$stdArray['productFeed'][$key]['condition']           =  @$feedValue['_child']['g:condition']['_value'];
            /*28*/$stdArray['productFeed'][$key]['store']           =  'yebhi';
         
            //md5_file($filename)
            /*it has many extra fields not listed here*/
        
            
        }
        return $stdArray;       
    }

    public function refreshFeedFile($store = null) {
        if($store){
            if(array_key_exists($store, $this->feedMeta)){
                $meta = $this->feedMeta[$store];
                if($this->downloadFile($meta['url'])){
                    if(md5_file($meta['file'])== md5_file($this->tempFile)){
                        unlink($this->tempFile);
                        echo $store.':unchanged<br>';
                    } else {
                        unlink($meta['file']);
                        rename($this->tempFile, $meta['file']);
                        echo $store.':changed<br/>';
                    }
                }
            }
        } else {
            foreach ($this->feedMeta as $store => $meta) {
                if($this->downloadFile($meta['url'])){
                    if(md5_file($meta['file'])== md5_file($this->tempFile)){
                        unlink($this->tempFile);
                        echo $store.':unchanged<br>';
                    } else {
                        unlink($meta['file']);
                        rename($this->tempFile, $meta['file']);
                        echo $store.':changed<br/>';
                    }
                }
            }
            
        }
    }
            
    public function saveOmgCoupons() {
        //pr($this->getCurl($this->omgCouponUrl));
        $this->downloadFile($this->omgCouponUrl,  $this->fileDir.'omgCoupon.xml');
    }
    
    public function processOmgCoupons($filter=array('ProgrammeStatus'=>'Live')) {
        
        $omgCouponData = array();
        $filtered = TRUE;
        $xmlData = file_get_contents( $this->fileDir.'omgCoupon.xml');
        $arrayData = $this->xmlToArryObj->xml_to_array($xmlData);
        foreach ($arrayData['Report']['_child']['table1']['_child']['Detail_Collection']['_child']['Detail'] as $dataMeta) {
           $filtered = TRUE;
            foreach ($filter as $key => $value) {
                if($dataMeta['_attribute'][$key]!=$value){
                    $filtered = FALSE;
                    break;
                }
                
            }
            if($filtered)
                $omgCouponData[] = $dataMeta['_attribute'];
            else
                continue;
        }
        pr($omgCouponData);
        
    }
}

?>
