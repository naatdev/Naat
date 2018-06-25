<?php
/*
    La classe qui gêre les accès aux données
*/
Class giveColorFromEquivalent
{

	public function __construct()
	{

	}
	static public function giveFromName($name)
	{
		$colors = array(
			"lightorange"		=> "#f39c12",
			"lightblue"			=> "#3498db",
			"amethyst"			=> "#9b59b6",
			"yellow"			=> "#f1c40f",
			"red"				=> "#e74c3c",
			"rose"				=> "#FC6264",
			"lightgrey"			=> "#252928",
			"turquoise"			=> "#1DAE8B",
			"parme"				=> "#962543",
			"violet"			=> "#927FBF",
			"chaire"			=> "#FFB5A6",
			"bordeaux"			=> "#682E2D",
			"chaire_leger"		=> "#F9EDD7",
			"rouge_sang"		=> "#98091B",
			"kaki"				=> "#5E6C31",
			"bleu_fonce"		=> "#010035",
			"grey"				=> "#8D8276",
			"marron_clair"		=> "#9E906E",
			"kaki_fonce"		=> "#54573A",
			"bleu_gris"			=> "#444B54"

		);
		return $colors[$name];
	}
	static public function giveColorsFromName()
	{
		$colors = array(
			"lightorange"		=> "#f39c12",
			"lightblue"			=> "#3498db",
			"amethyst"			=> "#9b59b6",
			"yellow"			=> "#f1c40f",
			"red"				=> "#e74c3c",
			"rose"				=> "#FC6264",
			"lightgrey"			=> "#252928",
			"turquoise"			=> "#1DAE8B",
			"parme"				=> "#962543",
			"violet"			=> "#927FBF",
			"chaire"			=> "#FFB5A6",
			"bordeaux"			=> "#682E2D",
			"chaire_leger"		=> "#F9EDD7",
			"rouge_sang"		=> "#98091B",
			"kaki"				=> "#5E6C31",
			"bleu_fonce"		=> "#010035",
			"grey"				=> "#8D8276",
			"marron_clair"		=> "#9E906E",
			"kaki_fonce"		=> "#54573A",
			"bleu_gris"			=> "#444B54"

		);
		return $colors;
	}
	static public function giveColors()
	{
		$colors = array(
			"lightorange"		=> "Orange clair",
			"lightblue"			=> "Bleu clair",
			"amethyst"			=> "Amethyste",
			"yellow"			=> "Jaune",
			"red"				=> "Rouge",
			"rose"				=> "Rose",
			"lightgrey"			=> "Gris light",
			"turquoise"			=> "Turquoise",
			"parme"				=> "Parme",
			"violet"			=> "Violet",
			"chaire"			=> "Chaire",
			"bordeaux"			=> "Bordeaux",
			"chaire_leger"		=> "Chaire light",
			"rouge_sang"		=> "Rouge sang",
			"kaki"				=> "Kaki",
			"bleu_fonce"		=> "Bleu foncé",
			"grey"				=> "Gris",
			"marron_clair"		=> "Marron clair",
			"kaki_fonce"		=> "Kaki foncé",
			"bleu_gris"			=> "Bleu gris"
		);
		return $colors;
	}
	static public function giveColorsList()
	{
		$colors = array(
			"lightorange",
			"lightblue",
			"amethyst",
			"yellow",
			"red",
			"rose",
			"lightgrey",
			"turquoise",
			"parme",
			"violet",
			"chaire",
			"bordeaux",
			"chaire_leger",
			"rouge_sang",
			"kaki",
			"bleu_fonce",
			"grey",
			"marron_clair",
			"kaki_fonce",
			"bleu_gris"
		);
		return $colors;
	}
}