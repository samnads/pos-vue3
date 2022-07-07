<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Gd extends CI_Controller
{
	public $login_redirect = FALSE;
	public function index()
	{
		header("Content-Type: image/png");
		$im = @imagecreate($this->uri->segment(2), $this->uri->segment(3))
			or die("Cannot Initialize new GD image stream");
		$background_color = imagecolorallocate($im, 0, 0, 0);
		$text_color = imagecolorallocate($im, 255, 255, 255);
		imagestring($im, 50, 5, 5,  "CyberLikes", $text_color);
		imagepng($im);
		imagedestroy($im);
	}
}
