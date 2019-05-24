<?php
function sendimagetext($text, $bgCol, $textCol, $size) {
  $font_size = intval($size);

  $ts=explode("\n",$text);
  $width=0;
  foreach ($ts as $k=>$string) {
    $width=max($width,strlen($string));
  }

  $width  = imagefontwidth($font_size)*$width;
  $height = imagefontheight($font_size)*count($ts);
  $el=imagefontheight($font_size);
  $em=imagefontwidth($font_size);
  $img = imagecreatetruecolor($width,$height);
  $bg = imagecolorallocate($img, $bgCol[0], $bgCol[1], $bgCol[2]);
	
  imagefilledrectangle($img, 0, 0,$width ,$height , $bg);
  $color = imagecolorallocate($img, $textCol[0], $textCol[1], $textCol[2]);

  foreach ($ts as $k=>$string) {
    $len = strlen($string);
    $ypos = 0;
    for($i=0;$i<$len;$i++){
      $xpos = $i * $em;
      $ypos = $k * $el;
      imagechar($img, $font_size, $xpos, $ypos, $string, $color);
      $string = substr($string, 1);      
    }
  }
	
	imagesavealpha($img, true);
	$trans_colour = imagecolorallocatealpha($img, 0, 0, 0, 127);
	
	imagecolortransparent($img, $bg);
	imagefill($img, 0, 0, $trans_colour);
	
  header("Content-Type: image/png");
  imagepng($img);
  imagedestroy($img);
}
?>