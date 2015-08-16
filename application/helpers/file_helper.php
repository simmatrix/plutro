<?php defined('BASEPATH') OR exit('No direct script access allowed');

class File_Helper
{
	public function removeFiles( $path = null )
	{
		if( empty($path) )
		{
			return false;
		}

		// Remove the first "/" from url if any.
		$path 	= ltrim($path, '/');

		// If wish to clean the entire folder, specify the folder path and end with a slash.
		// Example: images/folder/
		// Example: images/folder, will only detect one item at a time.
		$files 	= glob($path . '*');
		foreach($files as $file)
		{
			if(is_file($file))
			{
				unlink($file);
			}
		}

		return true;
	}

	public function removeFolders( $folders = array() )
	{
		if( empty($folders) )
		{
			return false;
		}

		foreach( $folders as $folder )
		{
			if( is_dir($folder) )
			{
				rmdir( $folder );
			}
		}

		return true;
	}

	public function createFolder( $path = null )
	{
		if( empty($path) )
			return false;

		// Check if the user folder exist?
		if( !file_exists( $path ) )
		{
			// Create if does not exist
			mkdir( $path, '0755', true );
			return true;
		}

		return false;
	}

	public function download( $filename = '', $path = '' )
	{
		if( file_exists($path) )
		{
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($filename).'"');
			header('Content-Transfer-Encoding: binary');
			header('Connection: Keep-Alive');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($path));
			ob_clean();
			flush();
			readfile($path);
			exit;
		}
		else
		{
			return false;
		}
	}
}
