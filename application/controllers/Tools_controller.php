<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools_Controller extends CI_Controller {

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
		redirect();
	}

	public function unixReader()
	{
		$msg					= array();
		$data					= array();
		$data['title']			= 'Unix Reader - Plutro';
		$data['description']	= PLUTRO_META_DESC;
		$data['view']			= 'mainTemplate';
		$data['layout']			= 'unixReaderLayout';

		$content		= Plutro::getTemplate( 'plutro/unixReaderLayout', $data, true );
		$data['html']	= $content;

		Plutro::loadTemplate( 'plutro/mainTemplate', $data );
	}

	public function randomText()
	{
		$msg					= array();
		$data					= array();
		$data['title']			= 'Random Text Generator - Plutro';
		$data['description']	= PLUTRO_META_DESC;
		$data['view']			= 'mainTemplate';
		$data['layout']			= 'randomTextLayout';

		$content		= Plutro::getTemplate( 'plutro/randomTextLayout', $data, true );
		$data['html']	= $content;

		Plutro::loadTemplate( 'plutro/mainTemplate', $data );
	}

	public function flatColors()
	{
		$msg					= array();
		$data					= array();
		$data['title']			= 'Flat Colors - Plutro';
		$data['description']	= PLUTRO_META_DESC;
		$data['view']			= 'mainTemplate';
		$data['layout']			= 'flatColors';

		$content		= Plutro::getTemplate( 'plutro/flatColorsLayout', $data, true );
		$data['html']	= $content;

		Plutro::loadTemplate( 'plutro/mainTemplate', $data );
	}

	public function textCounter()
	{
		$msg					= array();
		$data					= array();
		$data['title']			= 'Text Counter - Plutro';
		$data['description']	= PLUTRO_META_DESC;
		$data['view']			= 'mainTemplate';
		$data['layout']			= 'textCounterLayout';

		$content		= Plutro::getTemplate( 'plutro/textCounterLayout', $data, true );
		$data['html']	= $content;

		Plutro::loadTemplate( 'plutro/mainTemplate', $data );
	}
}
