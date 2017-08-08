<?php
class filesystem{
	
	public function resize($filename, $size){
		$pieces = explode("_", $filename);
		if($pieces[0]=="img/news/mini"){
			return $filename;
			exit;
		}
		if($pieces[0]=="img/news/enother"){
			return $filename;
			exit;
		}			
		$pref = 'img/news/mini_';
		$img = strtolower(strrchr(basename($filename), "."));
		$imgname = basename($filename);
		$formats = array('.jpg', '.gif', '.png', '.bmp');
		if (in_array($img, $formats))
		{
		list($width, $height) = getimagesize($filename);
		$new_height = $height * $size;
		$new_width = $new_height / $width;
		$thumb = imagecreatetruecolor($size, $new_width);
		switch ($img)
		{
		case '.jpg': $source = @imagecreatefromjpeg($filename); break;
		case '.gif': $source = @imagecreatefromgif($filename); break;
		case '.png': $source = @imagecreatefrompng($filename); break;
		case '.bmp': $source = @imagecreatefromwbmp($filename); break;
		}
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $size, $new_width, $width, $height);
		switch ($img)
		{
		case '.jpg': imagejpeg($thumb, $pref.$imgname); break;
		case '.gif': imagegif($thumb, $pref.$imgname); break;
		case '.png': imagepng($thumb, $pref.$imgname); break;
		case '.bmp': imagewbmp($thumb, $pref.$imgname); break;
		}
		}
		else return 'Error';
		@imagedestroy($thumb);
		@imagedestroy($source);
		$imgname = "img/news/mini_".$imgname;
		return $imgname;
	}
	
	public function resize_n($filename, $size){
		$pieces = explode("_", $filename);
		if($pieces[0]=="img/news/mini"){
			return $filename;
			exit;
		}
		if($pieces[0]=="img/news/enother"){
			return $filename;
			exit;
		}		
		$pref = 'img/news/enother_img/mini_';
		$img = strtolower(strrchr(basename($filename), "."));
		$imgname = basename($filename);
		$formats = array('.jpg', '.gif', '.png', '.bmp');
		if (in_array($img, $formats))
		{
		list($width, $height) = getimagesize($filename);
		$new_height = $height * $size;
		$new_width = $new_height / $width;
		$thumb = imagecreatetruecolor($size, $new_width);
		switch ($img)
		{
		case '.jpg': $source = @imagecreatefromjpeg($filename); break;
		case '.gif': $source = @imagecreatefromgif($filename); break;
		case '.png': $source = @imagecreatefrompng($filename); break;
		case '.bmp': $source = @imagecreatefromwbmp($filename); break;
		}
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $size, $new_width, $width, $height);
		switch ($img)
		{
		case '.jpg': imagejpeg($thumb, $pref.$imgname); break;
		case '.gif': imagegif($thumb, $pref.$imgname); break;
		case '.png': imagepng($thumb, $pref.$imgname); break;
		case '.bmp': imagewbmp($thumb, $pref.$imgname); break;
		}
		}
		else return 'Error';
		@imagedestroy($thumb);
		@imagedestroy($source);
		$imgname = "img/news/enother_img/mini_".$imgname;
		return $imgname;
	}	
	
	public function remove($filename,$uploads_dir){	
		$filename;		
		//$uploads_dir="img/news/";
		if (file_exists($filename)){			
				if (!copy($filename, $uploads_dir.$filename)) $result = "не удалось скопировать $file...\n";
				else if(!unlink($filename)) $result = "not delete trash file";
				$result = "true";
		}else {
			$result = "Файл $filename не существует";
		}
		return $result;
	}
}

?>