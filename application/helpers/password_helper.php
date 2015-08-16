<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Password_Helper
{
	public function getSalt()
	{
		return strtr(base64_encode(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)), '+', '.');
	}

	public function encrypt( $data = '', $salt = '' )
	{
		// Hashing
		if( empty($salt) )
		{
			$salt = $this->getSalt();
		}

		$encrypt = md5($data . $salt);

		return $encrypt;
	}

	public function getFingerprint()
	{
		$browser 		= $_SERVER['HTTP_USER_AGENT'];
		// $fingerprint 	= get_browser($_SERVER['HTTP_USER_AGENT'], true);
		// $fingerprint 	= implode( ' ', array_filter($fingerprint) );
		// $fingerprint 	= $browser . $fingerprint;
		return $browser;
	}
}

