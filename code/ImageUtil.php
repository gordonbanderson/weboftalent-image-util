<?php 


class ImageUtil extends Extension {

    function extraStatics() {
        return array();
    }

    public function generateRotateClockwise(GD $gd) {
        return $gd->rotate(90);
    }
     
    public function generateRotateCounterClockwise(GD $gd)  {
        return $gd->rotate(270);
    }
     
    public function clearResampledImages()  {
        $files = glob(Director::baseFolder().'/'.$this->Parent()->Filename."_resampled/*-$this->Name");
        foreach($files as $file) {unlink($file);}
    }
     
    public function IsLandscape() {
        return $this->getWidth() > $this->getHeight();
    }
     
    public function IsPortrait() {
        return $this->getWidth() < $this->getHeight();
    }
     
    function generatePaddedImageByWidth(GD $gd,$width=600,$color="fff"){
        return $gd->paddedResize($width, round($gd->getHeight()/($gd->getWidth()/$width),0),$color);
    }
     
    public function Exif(){
        //http://www.v-nessa.net/2010/08/02/using-php-to-extract-image-exif-data
        $image = $this->AbsoluteURL;
        $d=new DataObjectSet(); 
        $exif = exif_read_data($image, 0, true);
        foreach ($exif as $key => $section) {
            $a=new DataObjectSet(); 
            foreach ($section as $name => $val)
                $a->push(new ArrayData(array("Title"=>$name,"Content"=>$val)));
            $d->push(new ArrayData(array("Title"=>strtolower($key),"Content"=>$a)));
        }
        return $d;
    }


	 
	public function generateGreyscaleImage(GD $gd, $RGB) 
	{
	    $Vars = explode(' ', $RGB);     
	     
	    return $gd->greyscale( $Vars[0], $Vars[1], $Vars[2]);
	}


		/* Greyscale image */
	public function GreyscaleImage($RGBW = '30 30 30 200') 
	{
		//error_log("CUSTOM IMAGE T1");
	    return $this->owner->getFormattedImage('PromotedImage', $RGBW);
	}
	 
	public function generatePromotedImage(GD $gd, $RGBW) 
	{
	    $Vars = explode(' ', $RGBW);


	    error_log(print_r($Vars,1));
	   	
	   	// resize the image
		$result  = $gd->resizeByWidth($Vars[3]);
		
		// remove color
	    $result = $result->greyscale( $Vars[0], $Vars[1], $Vars[2]);

	    return $result;
	}


}