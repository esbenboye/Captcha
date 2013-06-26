<?php
session_start();

include("phpclasses/coordinate.class.php");
include("phpclasses/color.class.php");
include("phpclasses/drawpad.class.php");
include("setup.php");

$operators[] = "+";
$operators[] = "*";
$operators[] = "-";

shuffle($operators);
$operator = $operators[0];
$result = 0;


switch($operator)
{
	case "*":
		$first = rand(1,5);
		$last = rand(1,5);
		$result = $first * $last;
	break;
	
	case "+":
		$first = rand(1,9);
		$last = rand(1,9);
		$result = $first + $last;
	break;
	
	case "-":
		$first = rand(1,5);
		$last = rand(1,5);
		if(($first-$last) < 0)
		{
			$t1 = $first;
			$t2 = $last;
			$last = $t1;
			$first = $t2;
		}
		$result = $first - $last;
	break;

}
$c = new Color(255,0,255,0);

$img = new DrawPad(65,25, $c);
$img->setTransparency($c);
$img->write(new Coordinate(5,5),"$first $operator $last =",5);
$img->createImage();

$hashed = hash($setup->hashfunction, $setup->salt.$result);
$_SESSION[$setup->sessionname] = $hashed;

?>