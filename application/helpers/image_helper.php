<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Image_Helper
{
	public function getImageSize( $path = '' )
	{
		if( empty($path) )
			return false;

		// Remove hostname.
		if( strpos($path, $_SERVER['HTTP_HOST']) !== false  )
		{
			$path = parse_url($path);
			$path = $path['path'];
		}

		// Remove first slash if any.
		$path = ltrim($path, '/');

		return getimagesize( $path );
	}

	public function imageCssType( $path = '' )
	{
		if( empty($path) )
			return false;

		$parsePath = parse_url($path);
		if( $parsePath['host'] == 'graph.facebook.com' )
		{
			return 'square';
		}

		$size = $this->getImageSize($path);

		// Index[0] = width, index[1] = height.
		if( $size[0] > $size[1] )
		{
			return 'wide';
		}
		else if( $size[0] < $size[1] )
		{
			return 'long';
		}
		else
		{
			return 'square';
		}

		return false;
	}

	public function generateThumbnail($sourceImagePath, $thumbnailImagePath)
	{
		list($sourceImageWidth, $sourceImageHeight, $sourceImageType) = getimagesize($sourceImagePath);

		switch($sourceImageType)
		{
			case IMAGETYPE_GIF:
				$sourceGdImage = imagecreatefromgif($sourceImagePath);
				break;
			case IMAGETYPE_JPEG:
				$sourceGdImage = imagecreatefromjpeg($sourceImagePath);
				break;
			case IMAGETYPE_PNG:
				$sourceGdImage = imagecreatefrompng($sourceImagePath);
				break;
		}

		if($sourceGdImage === false)
		{
			return false;
		}

		$sourceAspectRatio = $sourceImageWidth / $sourceImageHeight;
		$thumbnail_aspect_ratio = OFFICE_THUMBNAIL_IMAGE_MAX_WIDTH / OFFICE_THUMBNAIL_IMAGE_MAX_HEIGHT;

		if($sourceImageWidth <= OFFICE_THUMBNAIL_IMAGE_MAX_WIDTH && $sourceImageHeight <= OFFICE_THUMBNAIL_IMAGE_MAX_HEIGHT)
		{
			$thumbnailImageWidth = $sourceImageWidth;
			$thumbnailImageHeight = $sourceImageHeight;
		}
		elseif( $thumbnail_aspect_ratio > $sourceAspectRatio )
		{
			$thumbnailImageWidth = (int) (OFFICE_THUMBNAIL_IMAGE_MAX_HEIGHT * $sourceAspectRatio);
			$thumbnailImageHeight = OFFICE_THUMBNAIL_IMAGE_MAX_HEIGHT;
		}
		else
		{
			$thumbnailImageWidth = OFFICE_THUMBNAIL_IMAGE_MAX_WIDTH;
			$thumbnailImageHeight = (int) (OFFICE_THUMBNAIL_IMAGE_MAX_WIDTH / $sourceAspectRatio);
		}

		$thumbnailGdImage = imagecreatetruecolor($thumbnailImageWidth, $thumbnailImageHeight);

		// Set background color.
		$white = imagecolorallocate( $thumbnailGdImage, 255, 255, 255 );
		imagefill($thumbnailGdImage, 0, 0, $white);

		// Make the background transparent if using .png
		// imagecolortransparent($thumbnailGdImage, $white);

		imagecopyresampled($thumbnailGdImage, $sourceGdImage, 0, 0, 0, 0, $thumbnailImageWidth, $thumbnailImageHeight, $sourceImageWidth, $sourceImageHeight);

		// Thumbnail jpg is smaller size than .png
		imagejpeg($thumbnailGdImage, $thumbnailImagePath, 100);
		// imagepng($thumbnailGdImage, $thumbnailImagePath, 0);

		imagedestroy($sourceGdImage);
		imagedestroy($thumbnailGdImage);
		return true;
	}

	public function adjustOrientation( $imagePath = '' )
	{
		if( empty($imagePath) )
			return false;

		$ext 		= pathinfo($imagePath, PATHINFO_EXTENSION);
		$ext 		= strtolower( $ext );
		$allowed 	= array( 'jpg', 'jpeg', 'tif', 'tiff' );
		if( !in_array( $ext, $allowed ) )
			return false;

		// Determine rotation (Due to mobile uploaded image contain EXIF data)
		$exif = exif_read_data($imagePath);
		if (!empty($exif['Orientation']))
		{
			switch ($exif['Orientation'])
			{
				case 3:
					$angle = 180 ;
					break;
				case 6:
					$angle = -90;
					break;
				case 8:
					$angle = 90;
					break;
				default:
					$angle = 0;
					break;
			}

			if (preg_match("/.*\.jpg/i", $imagePath))
			{
				$source = imagecreatefromjpeg($imagePath);
			}
			else
			{
				$source = imagecreatefrompng($imagePath);
			}
			$source = imagerotate($source, $angle, 0);
			imagejpeg($source, $imagePath);
		}

		return true;
	}

	public function cropImage( $imagePath = '', $cropX = '', $cropY = '', $cropW = '', $cropH = '', $ratio = '' )
	{
		if( !empty($imagePath) && !empty($cropW) && !empty($cropH) && !empty($ratio) )
		{
			// Original image's details
			list($originalWidth, $originalHeight, $originalType) = getimagesize($imagePath);
			switch($originalType)
			{
				case IMAGETYPE_GIF:
					$image = imagecreatefromgif($imagePath);
					break;
				case IMAGETYPE_JPEG:
					$image = imagecreatefromjpeg($imagePath);
					break;
				case IMAGETYPE_PNG:
					$image = imagecreatefrompng($imagePath);
					break;
			}

			// Crop image
			if(function_exists('imagecreatetruecolor') )
			{
				$startX = $cropX * $ratio;
				$startY = $cropY * $ratio;
				$endX 	= $cropW * $ratio;
				$endY 	= $cropH * $ratio;

				if( $temp = imagecreatetruecolor($endX, $endY) )
				{
					// Cut out from original image.
					imagecopyresampled($temp, //new
										$image, //ori
										0, 0, //new
										$startX, $startY, //ori
										$endX, $endY, //new
										$endX, $endY ); //ori
				}
				// if( $temp = imagecreatetruecolor($cropW, $cropH) )
				// {
				// 	// Cut out and resize based on display image.
				// 	imagecopyresampled($temp, //new
				// 						$image, //ori
				// 						0, 0, //new
				// 						$startX, $startY, //ori
				// 						$cropW, $cropH, //new
				// 						$endX, $endY ); //ori
				// }
			}
			// else
			// {
			// 	$temp = imagecreate($cropW, $cropH);
			// 	imagecopyresized($temp, $image, 0, 0, $cropX, $cropY, $cropW, $cropH, $originalWidth, $originalHeight);
			// }

			if( $originalType == 3 )
			{
				imagepng($temp, $imagePath, 0);
			}
			else
			{
				imagejpeg($temp, $imagePath, 100);
			}
		}
	}

	public function getUserAvatar( $userId = '' )
	{
		$profileModel 	= Portal::getModels('profiles');
		$profile 		= $profileModel->getProfiles( $userId );

		if( empty($profile['avatar']) )
		{
			return base_url( 'images/users/avatars/default/avatar.jpg' );
		}

		return base_url( 'images/users/avatars/'.$profile['id'].'/'.$profile['avatar'] );
	}
}

