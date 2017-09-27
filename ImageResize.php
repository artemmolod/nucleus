<?php

    class ImageResize
    {
          public $filename;

          public function __construct($filename, $resizeX, $resizeY) {
              $this->filename = $filename;
              $this->resize($resizeX, $resizeY);
          }

          public function resize($x, $y) {
              list($width, $height, $type) = getimagesize($this->filename);
              $newWidth  = $x;
              $newHeight = $y;

              switch ($type) {
                   case IMAGETYPE_JPEG:
                        //loading
                        $thumb = imagecreatetruecolor($newWidth, $newHeight);
                        $source = imagecreatefromjpeg($this->filename);

                        //resize
                        //imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        //output
                        header("Content-Type: Image/jpeg");
                        imagejpeg($thumb);
                   break;
                   case IMAGETYPE_PNG:
                        //loading
                        $thumb = imagecreatetruecolor($newWidth, $newHeight);
                        $source = imagecreatefrompng($this->filename);

                        imagecolortransparent($thumb, imagecolorallocatealpha($thumb, 0, 0, 0, 127));
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);

                        //resize
                        //imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                        //output
                        header("Content-Type: Image/png");
                        imagepng($thumb);
                   break;
              }
          }
    }

    $url = $_GET['url'];
    $x   = $_GET['width'];
    $y   = $_GET['height'];

    $ImageResize = new ImageResize($url, $x, $y);
