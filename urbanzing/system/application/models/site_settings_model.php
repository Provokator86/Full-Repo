<?php
//for MLM
class Site_settings_model extends Model
{
    public $default_currency_array	= array('#36;'=>'USD','#8364;'=>'Euro','#163;'=>'Pound','#165;'=>'Yen','#84;L'=>'TL');
    public $paypal_cuency	= array('USD'=>'U.S. Dollars','AUD'=>'Australian Dollars','BRL'=>'Brazilian Real','GBP'=>'British Pounds','CAD'=>'Canadian Dollars','CZK'=>'Czech Koruny','DKK'=>'Danish Kroner','EUR'=>'Euros','HKD'=>'Hong Kong Dollars','HUF'=>'Hungarian Forints','ILS'=>'Israeli New Shekels','JPY'=>'Japanese Yen','MYR'=>'Malaysian Ringgits','MXN'=>'Mexican Pesos','NZD'=>'New Zealand Dollars','NOK'=>'Norwegian Kroner','PHP'=>'Philippine Pesos','PLN'=>'Polish Zlotych','SGD'=>'Singapore Dollars','SEK'=>'Swedish Kronor','CHF'=>'Swiss Francs','TWD'=>'Taiwan New Dollars','THB'=>'Thai Baht');
    public function __construct()
    {
        parent::__construct();
    }

    function get_site_settings_all()
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}site_settings ";
        $sql    .= ' LIMIT 0,1';
        $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
    }

    function get_site_settings($item='')
    {
        if(!$item || $item=='')
            return null;
        $sql    = "SELECT * FROM {$this->db->dbprefix}site_settings ";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if(is_array($item))
        {
            $tmp	= array();
            foreach ($item as $value)
            {
                if(isset($result_arr[0][$value]))
                    $tmp[$value]=$result_arr[0][$value];
            }
            return $tmp;
        }
        else
        {
            if(isset($result_arr[0][$item]))
                return $result_arr[0][$item];
        }
        return null;
    }

    function set_site_settings_update($arr)
    {
        $sql = "SELECT * FROM {$this->db->dbprefix}site_settings  ";
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return $this->db->insert('site_settings', $arr);
        else
            return $this->db->update('site_settings', $arr, array());
    }
	
	function truncate_table()
	{
		$sql = "TRUNCATE {$this->db->dbprefix}address_book";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_claimed";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_correction";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_cuisine";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_hour";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_menu";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_picture";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_reviews";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_review_like";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}business_review_rating";
		$this->db->query($sql);
		$sql = "DELETE FROM {$this->db->dbprefix}business_type WHERE parent_id!=0";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}cuisine";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}home_page_image";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}invites";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}mailing_list";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}newsletter";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}newsletter_user";
		$this->db->query($sql);
		$sql = "TRUNCATE {$this->db->dbprefix}occasion";
		$this->db->query($sql);	
		$sql = "TRUNCATE {$this->db->dbprefix}occupation";
		$this->db->query($sql);	
		$sql = "TRUNCATE {$this->db->dbprefix}party";
		$this->db->query($sql);	
		$sql = "TRUNCATE {$this->db->dbprefix}party_status";
		$this->db->query($sql);	
		$sql = "TRUNCATE {$this->db->dbprefix}price_range";
		$this->db->query($sql);	
		$sql = "TRUNCATE {$this->db->dbprefix}request_for_coupon";
		$this->db->query($sql);	
		$sql = "TRUNCATE {$this->db->dbprefix}reviews";
		$this->db->query($sql);	
		$sql = "TRUNCATE {$this->db->dbprefix}review_like";
		$this->db->query($sql);	
		$sql = "DELETE FROM {$this->db->dbprefix}users WHERE id!=1";
		$this->db->query($sql);	
	
	}
	
}
