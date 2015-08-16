<?php defined('BASEPATH') or die('Unauthorized Access');

class Ajax_Controller extends CI_Controller {

	// public static $isMobile;

	function __construct( $param = array() )
	{
		parent::__construct();
		date_default_timezone_set( 'Asia/Kuala_Lumpur' );
		// $detect 		= new Mobile_Detect;
		// Ajax_Controller::$isMobile = $detect->isMobile();
		// $this->lang->load('english_lang', 'english');
	}

	function _remap($method, $params = array())
	{
		if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $params);
		}
		exit;
	}

	public function index()
	{
		return;
	}

	public function ajaxUnixReader()
	{
		$param 	= $this->input->post( 'param' );
		$unix 	= preg_replace('/\s+/', '', $param['value']);

		if( !empty($unix) && is_numeric($unix) )
		{
			if( empty($param['timezone']) )
			{
				date_default_timezone_set('America/New_York');
			}
			else
			{
				if (in_array($param['timezone'], DateTimeZone::listIdentifiers())) {
					date_default_timezone_set( $param['timezone'] );
				}
				else {
					echo 'Invalid timezone format<br>Please refer the correct format <a href="http://php.net/manual/en/timezones.php" target="_blank">here</a>';exit;
				}
			}

			echo date('d/m/Y | H:i:s', $unix);
		}
	}

	public function ajaxRandomCharacters()
	{
		$param = $this->input->post( 'param' );

		if( !empty($param['amount']) )
		{
			$content = Plutro::getTemplate( 'text/stories', '', true );

			$words = str_word_count($content, 1);
			shuffle($words);
			$selected = array_slice($words, 0, $param['amount']);
			$implode = implode( ' ', $selected);

			// Get the amount of characters
			$characters = substr($implode, 0, $param['amount']);
			echo $characters;
		}
	}

	public function ajaxRandomWords()
	{
		$param = $this->input->post( 'param' );

		if( !empty($param['amount']) )
		{
			$content = Plutro::getTemplate( 'text/stories', '', true );

			$words = str_word_count($content, 1);
			shuffle($words);

			// Get the amount of words
			$selected = array_slice($words, 0, $param['amount']);
			$implode = implode( ' ', $selected);
			echo $implode;
		}
	}

	public function ajaxCountCharacters()
	{
		$param = $this->input->post( 'param' );
		if( !empty($param['amount']) )
		{
			echo mb_strlen( $param['amount'] );
		}
	}

	public function ajaxCountWords()
	{
		$param = $this->input->post( 'param' );
		if( !empty($param['amount']) )
		{
			echo str_word_count( $param['amount'] );
		}
	}
}
