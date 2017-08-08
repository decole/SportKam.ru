<?php
//---------iSKin-Core---------
//iSKin-core for SportKam
//developers: Sergey Galochkin

global $bus, $rool;

include_once("core/config.php"); //совокупность всех параметров
include_once("core/function/secure.php");
//include_once("core/function/statist.php");
include_once("core/function/autoriz.php"); // авторизация пользователя
include_once("core/function/parser.php"); // представление сайта
include_once("core/function/gallery.php");

$autoriz 	= new autorisation;
$parser 	= new template;
$secure  	= new law;

$temp 					= $autoriz->who_user($host,$user,$pass,$dbname);
$temp 					= explode("/",$temp);
$bus["name"] 			= $temp[0];
$bus["group"]			= $temp[1];
$bus["confirmed"]	 	= $temp[2]; // для регистрации подтверждения почты
$bus["id_user"]			= $temp[3];
$rool = $secure->rool($bus["group"]);
if(!$rool['read']){
	if($rool['block']==1){
		//echo " Вы заблокированный пользователь! ";
		include_once('tamplate/block.html');
	}
	die(""); // Выходит из скрипта, если нет прав
}
// Parser
if(isset($_GET["page"])) $bus["last_page"] = $_GET["page"];
if(isset($_POST["type"])){
	if($_POST["type"] == "autorisation") $bus["last_page"] = "autorisation";
	if($_POST["type"] == "registration") $bus["last_page"] = "registration";
	if($_POST["type"] == "confirm") 	 $bus["last_page"] = "confirm";
}
$page = $parser->page($bus["last_page"]);
if($page=="registr")  		$bus["registration"]	= $autoriz->registration($host,$user,$pass,$dbname);
if($page=="autorisation")	$bus["autorisation"] 	= $autoriz->autoriz($host,$user,$pass,$dbname);
if($page=="confirm")  		$bus["confirm"] 		= $autoriz->user_confirm($host,$user,$pass,$dbname);
if($page=="logout")   		$bus["name"] 			= $autoriz->logout();
if($page=="index"){			$news 					= $parser->generate_content($rool,$host,$user,$pass,$dbname);
							$news 					= explode(".+/",$news);
							$bus["news"] 			= $news[0];
							$bus["add_news"]		= $news[1];
							$slider 				= $parser->generate_slider($host,$user,$pass,$dbname);
							$slider 				= explode("|+*+|",$slider);
							$bus["slider"] 			= $slider[0];
}
if($page=="news"){			$news					= $parser->generate_insert_news($rool,$host,$user,$pass,$dbname,$_GET["id"]);
							$news 					= explode(".+/",$news);
							$bus["category_news"] 	= $news[0];
							$bus["logo_news"]		= $news[1];
							$bus["date"] 			= $news[2];
							$bus["news"]			= $news[3];
							$bus["id_news"] 		= $news[4];
							$bus["id_category"]		= $news[5];
							$bus["edit"]			= $news[6];
							$bus["img_n"] 			= $news[7];
							if(!empty($news[8]))	$bus["en_nws"] = $news[8];
							else $bus["en_nws"] = "";
							if(!empty($news[9]))	$bus["en_pht"] = $news[9];
							else $bus["en_pht"] = "";
}
if($page=="add_news")		$bus["add_news"]		= $parser->insert_news($rool,$host,$user,$pass,$dbname,$bus["id_user"]);
if($page=="edit_news"){		$edit					= $parser->edit_content($rool,$page,$host,$user,$pass,$dbname,$bus["id_user"]);
							$edit 					= explode(".+/",$edit);
							$bus["edit_news"]		= $edit[0];
							$bus["logo_news"] 		= $edit[1];
							$bus["mini_news"] 		= $edit[2];
							$bus["news"] 			= $edit[3];
							$bus["id_category"] 	= $edit[4];
							$bus["category"] 		= $edit[5];
							$bus["mini_img"]		= $edit[6];
							$bus["id_news"]			= $edit[7];
							$bus["status"] 			= $edit[8];
							$bus["img_n1"] 			= $edit[9];
							$bus["img_n2"] 			= $edit[10];
							$bus["img_n3"] 			= $edit[11];
							$bus["img_n4"] 			= $edit[12];
							$bus["img_n5"] 			= $edit[13];
}
if($page=="cat_news"){		$c_news					= $parser->generate_cat_news($rool,$host,$user,$pass,$dbname,$_GET["category"]);
							$c_news 				= explode(".+/",$c_news);							
							$bus["news"] 			= $c_news[0];
							$bus["cat_name"] 		= $c_news[1];
}
if($page=="all_news"){		$news					= $parser->generate_all_news($rool,$host,$user,$pass,$dbname);
							$news 					= explode(".+/",$news);							
							$bus["news"] 			= $news[0];
}
if($page=="edit_slider"){
							$edit_slider = $parser->edit_slider($host,$user,$pass,$dbname,$rool);
							if(!empty($edit_slider)) echo $edit_slider;
							$slider = $parser->generate_slider($host,$user,$pass,$dbname);
							$slider = explode("|+*+|",$slider);
							$bus["slider_nav"] 	= $slider[0];
							$bus["nc_link1"] 	= $slider[1];
							$bus["nc_link2"]	= $slider[2];
							$bus["nc_link3"] 	= $slider[3];
							$bus["nc_link4"] 	= $slider[4];
							$bus["nc_link5"] 	= $slider[5];
							$bus["nc_lnk1"] 	= $slider[6];
							$bus["nc_lnk2"]		= $slider[7];
							$bus["nc_lnk3"] 	= $slider[8];
							$bus["nc_lnk4"] 	= $slider[9];
							$bus["nc_lnk5"] 	= $slider[10];
							$bus["nc_src1"] 	= $slider[11];
							$bus["nc_src2"] 	= $slider[12];
							$bus["nc_src3"] 	= $slider[13];
							$bus["nc_src4"] 	= $slider[14];
							$bus["nc_src5"] 	= $slider[15];
							$bus["nc_alt_txt1"] = $slider[16];
							$bus["nc_alt_txt2"] = $slider[17];
							$bus["nc_alt_txt3"] = $slider[18];
							$bus["nc_alt_txt4"] = $slider[19];
							$bus["nc_alt_txt5"] = $slider[20];
							$bus["sp_src1"] 	= $slider[21];
							$bus["sp_src2"] 	= $slider[22];
							$bus["sp_src3"] 	= $slider[23];
							$bus["sp_src4"] 	= $slider[24];
							$bus["sp_src5"] 	= $slider[25];
							$bus["sp_alt_txt1"]	= $slider[26];
							$bus["sp_alt_txt2"]	= $slider[27];
							$bus["sp_alt_txt3"]	= $slider[28];
							$bus["sp_alt_txt4"]	= $slider[29];
							$bus["sp_alt_txt5"]	= $slider[30];
							$bus["pt_name1"]	= $slider[31];
							$bus["pt_name2"]	= $slider[32];
							$bus["pt_name3"]	= $slider[33];
							$bus["pt_name4"]	= $slider[34];
							$bus["pt_name5"]	= $slider[35];
							$bus["pt_text1"]	= $slider[36];
							$bus["pt_text2"]	= $slider[37];
							$bus["pt_text3"]	= $slider[38];
							$bus["pt_text4"]	= $slider[39];
							$bus["pt_text5"]	= $slider[40];
}
if($page=="gallery"){
	$gallery  	= new gallery;
	if(!isset($_GET['view']))					$gallery = $gallery->all_albom_cat($rool,$host,$user,$pass,$dbname);
		elseif($_GET['view']=="alboms")			$gallery = $gallery->all_alboms($rool,$host,$user,$pass,$dbname,$_GET['category']);
		elseif($_GET['view']=="watch_albom") 	$gallery = $gallery->insert_albom($rool,$host,$user,$pass,$dbname,$_GET['albom']);
		elseif($_GET['view']=="add_albom") 		$gallery = $gallery->add_albom($rool,$host,$user,$pass,$dbname,$_GET['category']);
		elseif($_GET['view']=="add_img") 		$gallery = $gallery->add_img($rool,$host,$user,$pass,$dbname,$_GET['albom']);
		elseif($_GET['view']=="dell_albom")		$gallery = $gallery->del_albom($rool,$host,$user,$pass,$dbname,$_GET['albom']);
		elseif($_GET['view']=="del_img")		$gallery = $gallery->del_img($rool,$host,$user,$pass,$dbname,$_GET['img']);
		
	
	$gallery = explode(".+/",$gallery);
	$bus["gallery"] 		= $gallery[0];
	$bus["edit_gallery"]	= "";
	if(!empty($gallery[1]))$bus["edit_gallery"] 	= $gallery[1];
	if(!empty($gallery[2]))$bus["list"] 			= $gallery[2];
	else $bus["list"] = "";
}
if($page=="add_section"){
	$bus["add_sect"] = $parser->add_section($rool,$page,$host,$user,$pass,$dbname,$bus["id_user"]);
}
if($page=="section_weav"){
	
	$news					= $parser->generate_insert_section($rool,$host,$user,$pass,$dbname,$_GET["id"]);
	$news 					= explode(".+/",$news);
	$bus["category_news"] 	= $news[0];
	$bus["logo_news"]		= $news[1];
	$bus["date"] 			= $news[2];
	$bus["news"]			= $news[3];
	$bus["id_news"] 		= $news[4];
	$bus["id_category"]		= $news[5];
	$bus["edit"]			= $news[6];
	$bus["anthr_news"]		= $news[7];
	$bus["anthr_photo"]		= $news[8];
}
if($page=="all_section"){
	$bus["news"] = $parser->all_section($rool,$page,$host,$user,$pass,$dbname);
}
if($page=="edit_section"){
	$news = $parser->edit_section($rool,$page,$host,$user,$pass,$dbname,$bus["id_user"]);
	$news = explode(".+/",$news);
	//$result.".+/".$logo_news.".+/".$news.".+/".$id_category.".+/".$category.".+/".$id_news;
	$bus["res"]		= $news[0];
	$bus["logo"] 	= $news[1];
	$bus["news"] 	= $news[2];
	$bus["id_cat"] 	= $news[3];
	$bus["cat"] 	= $news[4];
	$bus["id_news"] = $news[5];
}
if($page=="klub/index"){
	$news = $parser->generate_klb_news($rool,$host,$user,$pass,$dbname);
	$news = explode(".+/",$news);
	$bus["news"] = $news[0];
	$bus["edit"] = $news[1];
}
$header	= $parser->head_item($page);
$header	= explode("+",$header);
$bus['h_index'] 	= $header[0];
$bus['h_alln'] 		= $header[1];
$bus['h_sect'] 		= $header[2];
$bus['h_photo'] 	= $header[3];
$bus['h_klb'] 		= $header[4];
// right column info
$bus["klb"]			= $parser->generate_klb($page);
$bus["pop_news"]	= $parser->generate_pop_news($host,$user,$pass,$dbname);
//$bus["result"]		= $parser->generate_result($host,$user,$pass,$dbname);
$temp 				= $parser->head($bus["name"],$bus['confirmed']);
$temp 				= explode("+",$temp);
$bus['user_li1']	= $temp[0];
$bus['user_li2']	= $temp[1];
$bus['user_li3']	= $temp[2];
include_once("tamplate/".$page.".html");
?>