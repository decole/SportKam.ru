<?php
$link= "http://img-fotki.yandex.ru/get/6726/229953285.1a/0_e3c67_94b94f45_XXL.jpg";
function miniature($link){
	$src = substr($link, 0, 16);
	//echo $src;
	if($src == "http://img-fotki"){
		$linker = substr($link, -14, 16);
		//echo $linker; // - 4b94f45_XL.jpg
		$a1 = explode('_', $linker);
		//print_r($a1); - Array ( [0] => f45 [1] => XL.jpg ) 
		$a2 = explode('.', $a1[1]);
		//print_r($a2); - Array ( [0] => XL [1] => jpg ) 
		$a2[0] = "XS";
		$src1 = substr($link, 0, -14);
		//echo $src1; // http://img-fotki.yandex.ru/get/6726/229953285.1a/0_e3c67_9
		$src1 = $src1.$a1[0]."_".$a2[0].".".$a2[1];
		return $src1;
	}
}
echo $link."<br>";
echo miniature($link);
?>