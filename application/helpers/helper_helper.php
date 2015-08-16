<?php defined('BASEPATH') or die('Unauthorized Access');

class Helper_Helper
{
	/*
	Validate an email address.
	Provide email address (raw input)
	Returns true if the email address has the email
	address format and the domain exists.
	*/
	public function checkEmail( $email )
	{
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex)
		{
			$isValid = false;
		}
		else
		{
			$domain 	= substr($email, $atIndex+1);
			$local 		= substr($email, 0, $atIndex);
			$localLen 	= strlen($local);
			$domainLen 	= strlen($domain);

			if ($localLen < 1 || $localLen > 64)
			{
				// local part length exceeded
				$isValid = false;
			}
			else if ($domainLen < 1 || $domainLen > 255)
			{
				// domain part length exceeded
				$isValid = false;
			}
			else if ($local[0] == '.' || $local[$localLen-1] == '.')
			{
				// local part starts or ends with '.'
				$isValid = false;
			}
			else if (preg_match('/\\.\\./', $local))
			{
				// local part has two consecutive dots
				$isValid = false;
			}
			else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
			{
				// character not valid in domain part
				$isValid = false;
			}
			else if (preg_match('/\\.\\./', $domain))
			{
				// domain part has two consecutive dots
				$isValid = false;
			}
			else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
			{
				// character not valid in local part unless
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
				{
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
			{
				// domain not found in DNS
				$isValid = false;
			}
		}
		return $isValid;
	}

	public function getExtensionType( $extension = null )
	{
		if( empty($extension) )
		{
			return '';
		}

		$extensionType = '';
		switch( $extension )
		{
			case 'doc' :
				$extensionType = 'application/msword';
				break;
			case 'docx' :
				$extensionType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
				break;
			case 'xls' :
				$extensionType = 'application/vnd.ms-excel';
				break;
			case 'xlsx' :
				$extensionType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
				break;
			case 'ppt' :
				$extensionType = 'application/vnd.ms-powerpoint';
				break;
			case 'pptx' :
				$extensionType = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
				break;
			case 'txt' :
				$extensionType = 'text/plain';
				break;
			case 'pdf' :
				$extensionType = 'application/pdf';
				break;
			case 'rar' :
				$extensionType = 'application/x-rar-compressed';
				break;
			case 'zip' :
				$extensionType = 'application/zip';
				break;
			case 'jpg' :
				$extensionType = 'image/jpg';
				break;
			case 'png' :
				$extensionType = 'image/png';
				break;
			case 'gif' :
				$extensionType = 'image/gif';
				break;
			default:
				$extensionType = '';
				break;
		}

		return $extensionType;
	}

	public function allowedExt( $type = null, $extension = null, $extensionType = null )
	{
		if( empty($type) || empty($extension) || empty($extensionType) )
		{
			return false;
		}

		$imageExts 	= array( 'jpeg', 'jpg', 'png' );
		$imageType 	= array( 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png', 'image/x-png' );
		$fileExts 	= array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf', 'rar', 'zip');
		$fileType 	= array('application/msword',
							 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
							 'application/vnd.ms-excel',
							 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
							 'application/vnd.ms-powerpoint',
							 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
							 'text/plain',
							 'application/pdf',
							 'application/x-rar-compressed',
							 'application/zip'
							 );
		if( $type == 'image' )
		{
			$allowedExts = $imageExts;
			$allowedType = $imageType;
		}
		if( $type == 'file' )
		{
			$allowedExts = $fileExts;
			$allowedType = $fileType;
		}
		if( $type == 'all' )
		{
			$allowedExts = array_merge($imageExts, $fileExts);
			$allowedType = array_merge($imageType, $fileType);
		}

		$validExt = in_array( strtolower($extension), $allowedExts );
		$validType = in_array( $extensionType, $allowedType );

		if( $validExt && $validType )
		{
			return true;
		}

		return false;
	}

	public function limitText( $text, $limit = '20' )
	{
		if (str_word_count($text, 0) > $limit)
		{
			// $words = str_word_count($text, 2);

			// This will work with hashtags
			$words = array();
			$textArr = explode(' ', $text);
			if( !empty($textArr) )
			{
				foreach( $textArr as $key => $word )
				{
					$position = strpos( $text, $word );
					$words[$position] = $word;
				}
			}

			$pos = array_keys($words);
			$text = substr($text, 0, $pos[$limit]);
		}
		return $text;
	}

	public function limitChars( $text, $limit = '20' )
	{
		if ( strlen($text) > $limit )
		{
			$text = substr($text, 0, $limit) . '...';
		}
		return $text;
	}

	public function randomColor()
	{
		$color = array();
		$color[] = 'success';
		$color[] = 'primary';
		$color[] = 'info';
		$color[] = 'warning';
		$color[] = 'danger';
		$color[] = 'default';

		$randomKey = array_rand( $color );
		return $color[$randomKey];
	}

	public function generateCode( $text = '' )
	{
		return md5( $text . date('Y-m-d H:i:s') . rand() . uniqid() );
	}

	public function filterText( $str = '' )
	{
		// Remove all non-alphanumeric but retain international language unicode.
		$str = preg_replace( '/\P{L}+/u', '', $str );
		return $str;
	}

	public function stringToAlias( $str = '' )
	{
		// Sample string to test
		// $str = 'hello this is my house 我 的2 家 123 ~!@#$%  ^&*()_+ `-={} |:"< >? []\;\',./';

		$alias = explode( ' ', $str );
		foreach( $alias as $key => $word )
		{
			$alias[$key] = $this->filterText( $word );
		}
		$alias = array_values(array_filter($alias));
		$alias = implode('-', $alias);
		return $alias;
	}

	public function checkSimilarImageName( $filename = '', $albumId = '', $type = '' )
	{
		if( empty($filename) || empty($albumId) || empty($type) )
		{
			echo 'Invalid';
			exit;
		}

		$imageModel = Ims::getModels('images');
		$images 	= $imageModel->getImagesByAlbum( $albumId, $type );
		if( !empty($images) )
		{
			foreach( $images as $image )
			{
				if( $filename == $image['filename'] )
				{
					return true;
				}
			}
		}

		// No similar name.
		return false;
	}

	public function multiSort( &$arr, $col = '', $dir = '' )
	{
		if( empty($col) )
		{
			return false;
		}

		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}

		$dir = SORT_DESC;
		if( $dir = "ASC" )
		{
			$dir = SORT_ASC;
		}

		array_multisort($sort_col, $dir, $arr);
	}

	public function checkUrl( $url = null )
	{
		if( empty($url) )
		{
			return false;
		}

		if(filter_var($url, FILTER_VALIDATE_URL) === FALSE)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public static function prepareMessage( $text = '', $type = OFFICE_MESSAGE_ERROR )
	{
		$message = new stdClass;
		$message->type = $type;
		$message->content = $text;

		return $message;
	}

	public static function showMessages( $path = '', $messages = array(), $data = '' )
	{
		// $session = Ims::getLibraries( 'session' );
		// $session->set_flashdata( 'messages', $messages );
		$CI =& get_instance();

		$CI->load->library('session');
		$CI->session->set_flashdata('messages', $messages);

		if( !empty($data) )
		{
			// $session->set_flashdata( 'data', $data );
			$CI->session->set_flashdata('data', $data);
		}

		redirect( $path );
	}

	public function getUriSegments( $referer = false )
	{
		if( $referer )
		{
			$uri = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
		}
		else
		{
			$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		}

		$segments = explode('/', $uri);

		return array_values( array_filter($segments) );
	}
}
