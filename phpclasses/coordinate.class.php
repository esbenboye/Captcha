<?php
	class Coordinate
	{
		private $x;
		private $y;
		
		public function Coordinate($x, $y)
		{

			$this->x = $x;
			$this->y = $y;
		}
		
		public function getX()
		{
			return $this->x;
		}
		
		public function getY()
		{
			return $this->y;
		}
	}
?>