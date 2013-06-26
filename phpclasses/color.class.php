<?php class Color
	{
		private $r;
		private $g;
		private $b;
		private $a;
		
		public function __construct($r = 0, $g = 0, $b = 0, $alpha = 0)
		{
			$this->r = $r;
			$this->g = $g;
			$this->b = $b;
			$this->a = $alpha;
		}
		
		public function r()
		{
			return $this->r;	
		}
		
		public function g()
		{
			return $this->g;
		}
		
		public function b()
		{
			return $this->b;
		}
		
		public function a()
		{
			return $this->a;	
		}
	}
?>