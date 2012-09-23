<?php 


class ImageUtil extends Extension {

    function extraStatics() {
        return array();
    }


    /*
    Rotate an image clockwise
    */
    public function RotateClockwise() 
    {
        return $this->owner->getFormattedImage('RotateClockwise');
    }

    /*
    Rotates an image clockwise, called from $RotateClockwise in a template
    */
    public function generateRotateClockwise(GD $gd) {
        return $gd->rotate(270);
    }

    /*
    Rotate an image anti clockwise
    */
    public function RotateAntiClockwise() 
    {
        return $this->owner->getFormattedImage('RotateAntiClockwise');
    }

    /*
    Rotates an image clockwise, called from $RotateAntiClockwise in a template
    */
    public function generateRotateAntiClockwise(GD $gd)  {
        return $gd->rotate(90);
    }

    public function clearResampledImages()  {
        $files = glob(Director::baseFolder().'/'.$this->Parent()->Filename."_resampled/*-$this->Name");
        foreach($files as $file) {unlink($file);}
    }
    
    /*
    Check whether or not an image is landscape aspect
    */
    public function IsLandscape() {
        return $this->owner->getWidth() > $this->owner->getHeight();
    }
    

    /*
    Check whether not an image is portrait aspect
    */
    public function IsPortrait() {
        return $this->owner->getWidth() < $this->owner->getHeight();
    }
    

    /*
    Generate a padded image with the padding background color configurable.  Silverstripe's default is white
    */ 
    function generatePaddedImageWithColor(GD $gd,$colorWidth="fff 600 400"){
        $Vars = explode(' ', $colorWidth); 
        $height = $Vars[2];
        $width = $Vars[1];
        $color = $Vars[0];
        return $gd->paddedResize($width, $height,$color);
    }

    public function PaddedImageWithColor($colorWidthHeight) 
    {
        return $this->owner->getFormattedImage('PaddedImageWithColor', $colorWidthHeight);
    }
     
    public function ExifData(){
        //http://www.v-nessa.net/2010/08/02/using-php-to-extract-image-exif-data
        $image = $this->owner->AbsoluteURL;
        $d=new DataObjectSet(); 
        $exif = exif_read_data($image, 0, true);
        foreach ($exif as $key => $section) {
            $a=new DataObjectSet(); 
            foreach ($section as $name => $val) {
                $a->push(new ArrayData(array("Name"=>$name,"Value"=>$val)));
            }
            $d->push(new ArrayData(array("Name"=>strtolower($key),"Value"=>$a)));
        }
        return $d;
    }


	 


	/* Greyscale image */
	public function Greyscale($RGBW = '30 30 30 100') 
	{
	    return $this->owner->getFormattedImage('GreyscaleWithWidth', $RGBW);
	}

    
	 
	public function generateGreyscaleWithWidth(GD $gd, $RGBW) 
	{
	    $Vars = explode(' ', $RGBW);
	   	
	   	// resize the image
		$result  = $gd->resizeByWidth($Vars[3]);
		
		// remove color
	    $result = $result->greyscale( $Vars[0], $Vars[1], $Vars[2]);

	    return $result;
	}


}