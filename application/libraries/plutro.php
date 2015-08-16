<?php defined('BASEPATH') or die('Unauthorized Access');
require_once 'PHPMailerAutoload.php';
require_once 'Mobile_Detect.php';

class Plutro {

	public static $CI;
	public static $detect;
	public static $isMobile;

	function __construct()
	{
		date_default_timezone_set('Asia/Kuala_Lumpur');

		$detect 			= new Mobile_Detect;
		Plutro::$detect 	= $detect;
		Plutro::$isMobile 	= $detect->isMobile();
		Plutro::$CI 		=& get_instance();

		// self::$CI->lang->load('english_lang', 'english');
	}

	public static function getTemplate( $templateName = '', $param = array(), $return = false )
	{
		$template 	= Plutro::$CI->load->view( $templateName, $param, true );

		if($return)
		{
			return $template;
		}
	}

	public static function loadTemplate( $templateName = '', $param = array(), $return = false )
	{
		$head 		= Plutro::$CI->load->view( 'head', $param, true );

		// Template load inside body.
		$template 	= Plutro::$CI->load->view( $templateName, $param, true );

		// Javascript load right before </body> tag.
		$javascript = Plutro::$CI->load->view( 'javascript', $param, true );

		$bodyData = array();
		$bodyData['template'] 	= $template;
		$bodyData['javascript'] = $javascript;

		$body 		= Plutro::$CI->load->view( 'body', $bodyData, true );

		$footer 	= Plutro::$CI->load->view( 'footer', '', true );

		// Load everything in html.
		$html = Plutro::$CI->load->view( 'html', array( 'head' => $head, 'body' => $body, 'footer' => $footer ), $return );

		if($return)
		{
			return $html;
		}
	}

	public static function getModels( $name = '' )
	{
		$name = $name . '_model';
		$ci =& get_instance();
		$ci->load->model( $name );

		return new $name;
	}

	public static function getHelpers( $name = '' )
	{
		$name = $name . '_helper';
		$ci =& get_instance();
		$ci->load->helper( $name );

		return new $name;
	}

	public static function getLibraries( $name = '' )
	{
		$ci =& get_instance();
		$ci->load->library( $name );

		return new $name;
	}

	public static function setSession( $name = '', $value = array() )
	{
		$ci =& get_instance();
		if( empty($name) && !empty($value) )
		{
			foreach( $value as $key => $data )
			{
				$ci->session->set_userdata( $key, $data );
			}
		}
		else if( !empty($name) && !empty($value) )
		{
			$ci->session->set_userdata( $name, $value );
		}
	}

	public static function getSession( $name = '' )
	{
		$ci =& get_instance();
		if( empty($name) )
		{
			return $ci->session->all_userdata();
		}

		return $ci->session->userdata( $name );
	}

	public static function unsetSession( $name = '' )
	{
		$ci =& get_instance();

		if( !empty($name) )
		{
			$ci->session->unset_userdata( $name );
			return true;
		}

		// Unset all
		$ci->session->unset_userdata( 'user' );
		$ci->session->unset_userdata( 'usergroup' );
		$ci->session->unset_userdata( 'timezone' );
		$ci->session->sess_destroy();
		return true;
	}

/*	public function setPlutroCookie( $userId = '' )
	{
		if( empty($userId) )
		{
			return false;
		}

		$this->load->helper( 'cookie' );
		$helper 		= Plutro::getHelpers('helper');
		$passwordHelper = Plutro::getHelpers('password');
		$userModel 		= Plutro::getModels('users');

		$user = $userModel->getUsers( $userId );
		if( empty($user) )
		{
			return false;
		}

		// 31556952 = 1 year.
		$duration 	= 31556952;
		$salt 		= $passwordHelper->getSalt();
		$key 		= $helper->generateCode();

		$browser 		= $_SERVER['HTTP_USER_AGENT'];
		$fingerprint 	= $passwordHelper->getFingerprint();
		$token 			= $passwordHelper->encrypt( $key.$fingerprint, $salt );

		$cookie = array();
		$cookie['name'] 	= 'geoCookie';
		$cookie['value'] 	= $token;
		$cookie['expire'] 	= $duration;

		set_cookie( $cookie );

		// Prevent duplicate cookies of the same user.
		$query 	= 'DELETE FROM `geo_cookies` WHERE `user_id` = ?';
		$bind 	= array( $user['id'] );
		$this->db->query( $query, $bind );

		$table = array();
		$table['user_id'] 	= $user['id'];
		$table['key'] 		= $key;
		$table['salt'] 		= $salt;
		$table['token'] 	= $token;
		$table['browser'] 	= $browser;
		$this->db->insert( 'geo_cookies', $table );

		// Update last_login date
		$table = array();
		$table['last_login'] = time();
		$this->db->update( 'geo_users', $table, array( 'id' => $user['id'] ) );

		return true;
	}
*/
}
