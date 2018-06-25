<?php
/*
	La librairie qui permet de manipuler des images
*/
Class imagesTransform {
	
	public function __construct() {

	}

	static public function darkroom($img, $to, $largeur = 0, $hauteur = 0, $utiliser_gd = True) {
	 
		$dimensions = getimagesize($img);
		$rapport = $dimensions[0] / $dimensions[1];

		if($largeur == 0 && $hauteur == 0) {
			$largeur = $dimensions[0];
			$hauteur = $dimensions[1];
		}
		elseif($hauteur == 0){
			$hauteur = round($largeur / $rapport);
		}
		elseif ($largeur == 0){
			$largeur = round($hauteur * $rapport);
		}
	 
		if($dimensions[0] > ($largeur / $hauteur) * $dimensions[1]) {
			$dimensionY = $hauteur;
			$dimensionX = round($hauteur * $dimensions[0] / $dimensions[1]);
			$decalageX = ($dimensionX - $largeur) / 2;
			$decalageY = 0;
		}
		if($dimensions[0] < ($largeur / $hauteur) * $dimensions[1]) {
			$dimensionX = $largeur;
			$dimensionY = round($largeur * $dimensions[1] / $dimensions[0]);
			$decalageY = ($dimensionY - $hauteur) / 2;
			$decalageX = 0;
		}
		if($dimensions[0] == ($largeur / $hauteur) * $dimensions[1]) {
			$dimensionX = $largeur;
			$dimensionY = $hauteur;
			$decalageX = 0;
			$decalageY = 0;
		}

		if($utiliser_gd) {
			$pattern = imagecreatetruecolor($largeur, $hauteur);
			$type = mime_content_type($img);
			switch (substr($type, 6)) {
				case 'jpeg':
					$image = imagecreatefromjpeg($img);
					break;
				case 'gif':
					$image = imagecreatefromgif($img);
					break;
				case 'png':
					$image = imagecreatefrompng($img);
					break;
			}
			imagecopyresampled($pattern, $image, 0, 0, 0, 0, $dimensionX, $dimensionY, $dimensions[0], $dimensions[1]);
			imagedestroy($image);
			imagejpeg($pattern, $to, 100);
	 
			return True;

		}
		else{
			$cmd = '/usr/bin/convert -resize '.$dimensionX.'x'.$dimensionY.' "'.$img.'" "'.$dest.'"';
	       		shell_exec($cmd);
	 		$cmd = '/usr/bin/convert -gravity Center -quality '.self::$quality.' -crop '.$largeur.'x'.$hauteur.'+0+0 -page '.$largeur.'x'.$hauteur.' "'.$dest.'" "'.$dest.'"';
	            shell_exec($cmd);	
		}
		return True;
	}
}

$imageTransform = new imageTransform();