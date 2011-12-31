<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * IP-to-Geo Encoding using FreeGeoIP.net Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Adrienne L. Travis
 * @link		
 */

$plugin_info = array(
	'pi_name'		=> 'IP-to-Geo Encoding using FreeGeoIP.net',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Adrienne L. Travis',
	'pi_author_url'	=> '',
	'pi_description'=> 'Takes an IP address and geocodes it with FreeGeoIP.net',
	'pi_usage'		=> Alt_iptogeo::usage()
);


class Alt_iptogeo {

    public $settings = array(
        'base_url' => 'http://freegeoip.net/json/'
        );

    public $geodata = array();
	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
        // get IP address and get our settings populated properly
        $this->settings['ip_address'] = $_SERVER["REMOTE_ADDR"];
        $this->settings['complete_url'] = $this->settings['base_url'].$this->settings['ip_address'];
        $this->_get_json();
	}
	
	// ----------------------------------------------------------------

    private function _get_json() {
        if(isset($this->settings['complete_url'])) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->settings['complete_url']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $jstring = curl_exec($ch);
            curl_close($ch);
            $this->geodata = json_decode($jstring,TRUE);

            $this->return_data = "(".$this->geodata['latitude'].",".$this->geodata['longitude'].")";
            }

        }


	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

(Other services can be used instead if you change the settings base_url)
<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.alt_iptogeo.php */
/* Location: /system/expressionengine/third_party/alt_iptogeo/pi.alt_iptogeo.php */