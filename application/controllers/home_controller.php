<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_Controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function _remap($method, $params = array())
	{
		if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $params);
		}
		redirect();
	}

	public function index()
	{
		$this->home();
	}

	public function home( $param = array() )
	{
		$msg 					= array();
		$data 					= array();
		$data['title'] 			= 'Plutro - Developers Playground';
		$data['description'] 	= PLUTRO_META_DESC;
		$data['view'] 			= 'mainTemplate';
		$data['layout'] 		= 'homeLayout';

		$content = Plutro::getTemplate( 'plutro/homeLayout', $data, true );
		$data['html'] = $content;

		Plutro::loadTemplate( 'plutro/mainTemplate', $data );
	}
}
