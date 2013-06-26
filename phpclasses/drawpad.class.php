<?php
	class DrawPad
	{
		private $ressource;
		private $width;
		private $height;
		private $foreground;
		private $background;		
		private $fontSize;
	
		# Constructor
		# Creates a new image with the given width/heigth. 
		public function DrawPad($height, $width, Color $color = null)
		{
		
			$this->ressource = imagecreatetruecolor($height, $width);

			$this->width = $width;
			$this->height = $height;
			
			
			
			if($color != null)
			{
				$tempColor = imagecolorallocatealpha($this->ressource, $color->r(), $color->g(), $color->b(), $color->a());
				imagefilledrectangle($this->ressource, 0, 0, $height, $width, $tempColor);
			}
		}
		
		# Foreground color. 
		# If the color is given, the color will be set.
		# If the color is not set, it will return the current color
		public function foreground(Color $color = null)
		{
			
			if($color == null) 
			{
				return $this->foreground;
			}
			else
			{
				$this->foreground = imagecolorallocatealpha($this->ressource, $color->r(), $color->g(), $color->b(), $color->a());
			}
		}
		
		
		# Foreground controller. 
		# If the color is given, the color will be set.
		# If the color is not set, it will return the current color
		public function background(Color $color = null)
		{
			if($color == null) 
			{
				return $this->background;
			}
			else
			{
				$this->background = imagecolorallocatealpha($this->ressource, $color->r(), $color->g(), $color->b(), $color->a());
			}
		}
		
		# Draws a rectangle
		# Uses to Coordinates the gives X and Y values
		public function drawRectangle(Coordinate $c1, Coordinate $c2)
		{
			$x1 = $c1->getX();
			$y1 = $c1->getY();
			
			$x2 = $c2->getX();
			$y2 = $c2->getY();
		
			imagerectangle($this->ressource, $x1, $y1, $x2, $y2, $this->foreground);
		}
		
		# Draws a solid rectangle
		# Uses two coordinates to make the rectangle. 
		# The fill color will be the current backgroundcolor
		public function drawSolidRectangle(Coordinate $c1, Coordinate $c2)
		{
			$x1 = $c1->getX();
			$y1 = $c1->getY();
			
			$x2 = $c2->getX();
			$y2 = $c2->getY();
		
			imagefilledrectangle($this->ressource, $x1, $y1, $x2, $y2, $this->background);
		}
		
		# Draws a filled rectangle
		# Uses two coordinates to make the rectangle. 
		# The fill color will be the current backgroundcolor and the border color will be the foreground color
		public function drawFilledRectangle(Coordinate $c1, Coordinate $c2)
		{
			$this->drawSolidRectangle($c1, $c2);
			$this->drawRectangle($c1, $c2);
		}
		
		# Draws a line
		# Uses two sets of coordinates
		public function drawLine(Coordinate $c1, Coordinate $c2)
		{
			$x1 = $c1->getX();
			$y1 = $c1->getY();
			
			$x2 = $c2->getX();
			$y2 = $c2->getY();
			
			imageline($this->ressource, $x1, $y1, $x2, $y2, $this->foreground);

		}
		
		# Draws several lines. 
		# Takes an array of coordinates to draw all the lines
		# If $close is set to true, it will also draw a line from the last point to the beginning to close up.
		public function drawLines($lineCoordinates, $close = false)
		{
			foreach($lineCoordinates as $c => $coordinate)
			{
				if(isset($lineCoordinates[$c+1]))
				{
					$this->drawLine($lineCoordinates[$c], $lineCoordinates[$c+1]);					
				}
			}
			
			if($close)
			{
				$lastCoordinate = end($lineCoordinates);
				$firstCoordinate = $lineCoordinates[0];
				
				$this->drawLine($lastCoordinate, $firstCoordinate);
			}
		}
		
		# Outputs the image as png
		# If the filename is set it will also save the image to the server with the given name
		public function createImage($filename = null)
		{
			if($filename)
			{
				imagepng($this->ressource, $filename, 100);
			}
			else
			{

				header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
				header("content-type: image/png");
				imagepng($this->ressource);
			}
			imagedestroy($this->ressource);
		}
		
		# Writes on the DrawPad
		# Uses the forground color as textcolor and by default the size 3
		public function write(Coordinate $coord, $text, $size = 3, Color $color = null)
		{
			if($color != null)
			{
				$intColor = imagecolorallocatealpha($this->ressource, $color->r(), $color->g(), $color->b(), $color->a());
				imagestring($this->ressource, $size, $coord->getX(), $coord->getY(), $text, $intColor);
			}
			else
			{
				imagestring($this->ressource, $size, $coord->getX(), $coord->getY(), $text, $this->foreground);	
			}
			$this->fontSize = $size;
			return imagefontwidth($size)*strlen($text);
		}
		
		# BETA ONLY - Gets the color at at specific pixel
		# Takes a coordinate and return the color as a Color object
		public function getColorAt(Coordinate $c)
		{
			$x = $c->getX();
			$y = $c->getY();
			
			$hex = imagecolorat($this->ressource, $x, $y);
			
			$rgb = imagecolorsforindex($this->ressource, $hex);
			
			return new Color($rgb['red'], $rgb['green'], $rgb['blue']);
			
		}
		
		# Registers a specific color as transparetn
		# Takes the color as an argument
		public function setTransparency(Color $color)
		{
			$r = $color->r();
			$g = $color->g();
			$b = $color->b();
			
			$transparentColor = imagecolorallocate($this->ressource, $r, $g, $b);
			
			imagecolortransparent($this->ressource, $transparentColor);
		}
		
	}
	
	


?>