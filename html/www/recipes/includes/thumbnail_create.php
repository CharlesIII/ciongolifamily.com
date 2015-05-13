<?php
if(class_exists('Thumbnail') != true) {
    class Thumbnail {
	    /**
	     * Thumbnail::Thumbnail()
	     * 
	     * @param $resource_file - root or relative path + filename of image to be thumbnailed
	     * @param $max_width - maximum width of thumbnail in pixels
	     * @param $max_height - maximum height of thumbnail in pixels
	     * @param $destination_file - root or relative path + filename(+extension) of saved thumbnail
	     * @param $compression - % quality of output file - 85 is normally considered good
	     * @param $transform - see above
	     * @return 
	     */
	    function Thumbnail($resource_file, $max_width, $max_height, $destination_file="", $compression=80, $transform="")
		    {
		    $this->a = $resource_file;		// image to be thumbnailed
		    $this->c = $transform;
		    $this->d = $destination_file;	// thumbnail saved to
		    $this->e = $compression;		// compression ration for jpeg thumbnails
		    $this->m = $max_width;
		    $this->n = $max_height;

		    $this->compile();
		    if($this->c !== "")
			    {
			    $this->manipulate();
			    $this->create();
			    }
		    }
	    function compile()
		    {	
		    $this->h = getimagesize($this->a);
		    if(is_array($this->h))
			    {
			    $this->i = $this->h[0];
			    $this->j = $this->h[1];
			    $this->k = $this->h[2];
		    
			    $this->o = ($this->i / $this->m);
			    $this->p = ($this->j / $this->n);
			    $this->q = ($this->o > $this->p) ? $this->m : round($this->i / $this->p); // width
			    $this->r = ($this->o > $this->p) ? round($this->j / $this->o) : $this->n; // height
			    }
		    $this->s = ($this->k < 4) ? ($this->k < 3) ? ($this->k < 2) ? ($this->k < 1) ? Null : imagecreatefromgif($this->a) : imagecreatefromjpeg($this->a) : imagecreatefrompng($this->a) : Null;
		    if($this->s !== Null)
			    {
			    $this->t = imagecreatetruecolor($this->q, $this->r); // created thumbnail reference
			    $this->u = imagecopyresampled($this->t, $this->s, 0, 0, 0, 0, $this->q, $this->r, $this->i, $this->j);
			    }
		    }

	    function hex2rgb($hex_value)
		    {
		    $this->decval = hexdec($hex_value);
		    return $this->decval;
		    }
	    function bevel($edge_width=10, $light_colour="FFFFFF", $dark_colour="000000")
		    {
		    $this->edge = $edge_width;
		    $this->dc = $dark_colour;
		    $this->lc = $light_colour;
		    $this->dr = $this->hex2rgb(substr($this->dc,0,2));
		    $this->dg = $this->hex2rgb(substr($this->dc,2,2));
		    $this->db = $this->hex2rgb(substr($this->dc,4,2));
		    $this->lr = $this->hex2rgb(substr($this->lc,0,2));
		    $this->lg = $this->hex2rgb(substr($this->lc,2,2));
		    $this->lb = $this->hex2rgb(substr($this->lc,4,2));
		    $this->dark = imagecreate($this->q,$this->r);
		    $this->nadir = imagecolorallocate($this->dark,$this->dr,$this->dg,$this->db);
		    $this->light = imagecreate($this->q,$this->r);
		    $this->zenith = imagecolorallocate($this->light,$this->lr,$this->lg,$this->lb);
		    for($this->pixel = 0; $this->pixel < $this->edge; $this->pixel++)
			    {
			    $this->opac =  100 - (($this->pixel+1) * (100 / $this->edge));
			    ImageCopyMerge($this->t,$this->light,$this->pixel,$this->pixel,0,0,1,$this->r-(2*$this->pixel),$this->opac);
			    ImageCopyMerge($this->t,$this->light,$this->pixel-1,$this->pixel-1,0,0,$this->q-(2*$this->pixel),1,$this->opac);
			    ImageCopyMerge($this->t,$this->dark,$this->q-($this->pixel+1),$this->pixel,0,0,1,$this->r-(2*$this->pixel),max(0,$this->opac-10));
			    ImageCopyMerge($this->t,$this->dark,$this->pixel,$this->r-($this->pixel+1),0,0,$this->q-(2*$this->pixel),1,max(0,$this->opac-10));
			    }
		    ImageDestroy($this->dark);
		    ImageDestroy($this->light);		
		    }
	    function manipulate()
		    {
		    if($this->c !== "" && $this->s !== Null)
			    {
			    eval("\$this->maniparray = array(".$this->c.");");
			    foreach($this->maniparray as $manip)
				    {
				    eval("\$this->".$manip.";");
				    }
			    }
		    }
	    function create()
		    {
		    if($this->s !== Null)
			    {
			    if($this->d !== "")
				    {
				    ob_start();
				    imagejpeg($this->t, $this->d, $this->e);
				    ob_end_clean();
				    }
			    imagedestroy($this->s);
			    imagedestroy($this->t);
			    }
		    }
	    }
}
?>