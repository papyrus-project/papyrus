<?php

/**
 * imageEdit short summary.
 *
 * imageEdit description.
 *
 * @version 1.0
 * @author Lennart
 */
class imageEdit
{
    public function resize($ratio, $inputFileName)
    {
        $info = getimagesize($inputFileName);
         
        $type = isset($info['type']) ? $info['type'] : $info[2];
        
        // Check support of file type
        if ( !(imagetypes() & $type) )
        {
            // Server does not support file type
            return false;
        }
         
        $width = isset($info['width']) ? $info['width'] : $info[0];
        $height = isset($info['height']) ? $info['height'] : $info[1];
        
        if($ratio < 1)
        {
                $tHeight = ceil($width * (1/$ratio));
                $tWidth = $width;
        }
        else if($ratio > 1)
        {
            $tWidth = ceil($height * ($ratio));
            $tHeight = $height;
        }
        else
        {
            if($width > $height)
            {
                $tWidth = $width;
                $tHeight = $width;
            }
            else
            {
                $tWidth = $height;
                $tHeight = $height;
            }
        }
        $newImg = imagecreatetruecolor($tWidth, $tHeight);
         
        // Using imagecreatefromstring will automatically detect the file type
        $sourceImage = imagecreatefromstring(file_get_contents($inputFileName));
        
        $white = imagecolorallocate($newImg, 255, 255, 255);
        imagefill($newImg, 0, 0, $white);
        if ( $sourceImage === false )
        {
            // Could not load image
            return false;
        }
        $dst_x=abs($tWidth-$width)/2;
        $dst_y=abs($tHeight-$height)/2;
        
        // Copy resampled makes a smooth resized image
        ImageCopy ( $newImg , $sourceImage , $dst_x , $dst_y , 0 , 0 , $width , $height );
        
		ImageEdit::imageToFile($newImg, $inputFileName);
    }
    function imageToFile($im, $fileName, $quality = 80)
    {
        if ( !$im )
            return false;
         
        $ext = strtolower(substr($fileName, strrpos($fileName, '.')));
         
        switch ( $ext )
        {
            case '.gif':
                imagegif($im, $fileName);
                break;
            
            case '.jpg':
            case '.jpeg':
                imagejpeg($im, $fileName, $quality);
                break;
            
            case '.png':
                imagepng($im, $fileName);
                break;
            
            case '.bmp':
                imagewbmp($im, $fileName);
                break;
            
            default:
                return false;
        }
         
        return true;
    }
}
