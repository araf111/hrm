<?php
namespace App\Model\SSO;

class Utility
{
	public function getNonce(){
		$factory = new RandomLib\Factory;	
		$generator = $factory->getMediumStrengthGenerator();
		
		return $generator->generate(32);
	}
}