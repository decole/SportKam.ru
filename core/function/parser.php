<?php
class template {

	public function page($page){
		switch ($page) {			
			case "home": 			$page = "index"; break;
			case "autorisation": 	$page = "autorisation"; break;			
			case "registration": 	$page = "registr"; break;
			case "confirm":			$page = "confirm"; break;
			case "profile":			$page = "profile"; break;
			case "logout": 			$page = "logout"; break;
			case "add_news": 		$page = "add_news";	break;
            case "news": 			$page = "news";	break;
			case "edit_news": 		$page = "edit_news"; break;			
			case "cat_news": 		$page = "cat_news";	break;
			case "all_news": 		$page = "all_news";	break;
			case "adp": 			$page = "admin/adp"; break;
            case "edit_slider": 	$page = "edit_slider"; break;
			case "gallery": 		$page = "gallery"; break;
			case "section": 		$page = "section/glav_section"; break;
			case "dush1": 			$page = "section/dush1"; break;
			case "dush1_t": 		$page = "section/dush1_t"; break;
			case "dush1_v": 		$page = "section/dush1_v"; break;
			case "dush2": 			$page = "section/dush2"; break;
			case "dush2_t": 		$page = "section/dush2_t"; break;
			case "dush2_v": 		$page = "section/dush2_v"; break;
			case "dush3": 			$page = "section/dush3"; break;
			case "dush3_t": 		$page = "section/dush3_t"; break;
			case "dush3_v": 		$page = "section/dush3_v"; break;
			case "dush4": 			$page = "section/dush4"; break;
			case "dush4_t": 		$page = "section/dush4_t"; break;
			case "dush4_v": 		$page = "section/dush4_v"; break;
			case "antey": 			$page = "section/antey"; break;
			case "antey_t": 		$page = "section/antey_t"; break;
			case "gimnastik": 		$page = "section/gimnastik"; break;
			case "gimnastik_t": 	$page = "section/gimnastik_t"; break;
			case "ducz": 			$page = "section/ducz"; break;
			case "ducz_t": 			$page = "section/ducz_t"; break;
			case "thekvondo": 		$page = "section/thekvondo"; break;
			case "thekvondo_t":		$page = "section/thekvondo_t"; break;
			case "orientir_t": 		$page = "section/orientir_t"; break;
			case "add_section": 	$page = "add_section"; break;
			case "section_weav": 	$page = "section_weav"; break;
			case "all_section": 	$page = "all_section"; break;
			case "edit_section": 	$page = "edit_section"; break;
			case "klb": 			$page = "klub/index"; break;
			default: 				$page = "index";
		}
		return $page;
	}
	
	public function head_item($page){
		$item = "";
		$index="";
		$all_news="";
		$section="";
		$gallery="";
		$klb="";
		/*
		if(empty($_GET['page'])) $index="class=\"current_page_item\"";
		elseif(!empty($_GET['page'])){
			if($_GET['page']=="all_news") $all_news = "class=\"current_page_item\"";
			elseif($_GET['page']=="section")$section = "class=\"current_page_item\"";
			elseif($_GET['page']=="gallery")$gallery = "class=\"current_page_item\"";
			elseif($_GET['page']=="klb")$klb = "class=\"current_page_item\"";
		}
		*/
		$sect = substr($page, 0, 5);
		if(empty($page) or $page=="index") $index="class=\"current_page_item\"";
		elseif(!empty($page)){
			if($page=="all_news") $all_news = "class=\"current_page_item\"";
			elseif($sect=="secti")$section = "class=\"current_page_item\"";
			elseif($page=="gallery")$gallery = "class=\"current_page_item\"";
			elseif($page=="klub/index")$klb = "class=\"current_page_item\"";
		}
		$item = $index."+".$all_news."+".$section."+".$gallery."+".$klb;
		return $item;
	}
	
	public function head($name,$confirmed){
		$bus="";
		if(date('H') >= "19" or date('H') >= "00") $time = "Доброй ночи, ";
		if(date('H') >= "04") $time = "Доброе утро, ";
		if(date('H') >= "10") $time = "Добрый день, ";
		if(date('H') >= "16") $time = "Добрый вечер, ";
		if($name == "Гость"){
			//$bus .= "<a href=''>".$time."Гость</a>+";
			$bus .= "+";
			//$bus .= "<a href='/index.php?page=autorisation'>Вход</a>+";
			$bus .= "<a href='#'></a>+"; //beta test prod
			$bus .= "";
		}
		if($name != "Гость"){
			//$bus .= "<a href='/index.php?page=profile'>".$time.$name."</a>+";
			//$bus .= "<a href='#'>".$time.$name."</a>+";
			$bus .= "+";
	 		//$bus .= "<a href='/index.php?page=logout'>Выход</a>+";
			$bus .= "+";
			if($confirmed == "1")  $bus .= "";
			if($confirmed == "0") $bus .= "<a href='/index.php?page=confirm'>(!)</a>";
		}
			return $bus;
	}

	public function generate_content($rool,$host,$user,$pass,$dbname){
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8"); 	
			
			if(empty($_GET['list'])){
				$list  = 0;
				$start = 0;
			}
			else {
				$list = $_GET['list'];
				if($list == 1) $start = 0;
				else $start = 10;
			}
			
			if(!$rool['write']){
				$rool_edit = "0";
				$sql="SELECT * FROM news, category WHERE news.category = category.id_category and `status` = '1' and `type` = '1' ORDER BY `news`.`date` DESC LIMIT $start , 10";
			}
			else{
				$rool_edit = "1";
				$sql="SELECT * FROM news, category WHERE news.category = category.id_category and `type` = '1' ORDER BY `news`.`date` DESC LIMIT $start , 10";
			}
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$news_text="";
			$news="";
			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
				$id      		= $row['id'];
				$logo_news   	= $row['logo_news'];
				$mini_news   	= $row['mini_news'];
				$review   		= $row['review'];
				$_date			= $row['date'];
				$mini_img		= $row['mini_img'];
				$id_category 	= $row['category'];
				$category		= $row['category_name'];
				$_date1 = new DateTime($_date);
				$_date = $_date1->format('d.m.Y H:i');
				$logo_news = htmlspecialchars_decode($logo_news);
				$mini_news = htmlspecialchars_decode($mini_news);
				$mini_news = htmlspecialchars_decode($mini_news);
                $sql3="SELECT count(*)FROM `rche_comments` WHERE `id_news` = '$id'";
                $res3=mysql_query($sql3);
                $row3 = mysql_fetch_array($res3);
                $comments       = $row3['count(*)'];
				if($rool_edit == 1){
					$edit = "<a  href=\"/index.php?page=edit_news&id_news=".$id ."\">[Редактировать]</a>";
					$edit1 = "<a href=\"/index.php?page=add_news\">[Добавить новость]</a> <a  href=\"/index.php?page=edit_slider\">[Редактировать слайдер]</a> <a  href=\"/index.php?page=add_section\">[Добавить секции]</a> <a  href=\"/index.php?page=all_section\">[Все секции]</a>";
				}
				else{
					$edit = "";
					$edit1 = "";
				}
                    $news_text = "<div class=\"news\">
								<img src=\"".$mini_img."\" width=\"129\" height=\"96\" align=\"left\" >
								<div class=\"news_text\">
								<a href='/index.php?page=news&id=".$id."'><h3>".$logo_news."</h3></a>
								".$mini_news."<br/>
								<div class=\"bottom_text\">
								<!--<img src=\"img/icon_comment.gif\" width=\"18\" height=\"14\"/> ".$comments."--> | <a href=\"index.php?page=cat_news&category=".$id_category."\">".$category."</a> | ".$edit."
								</div>
								</div>
								</div> <hr/>";
                    $news=$news.$news_text;
				}
			}
		return $news.".+/".$edit1;
	}

	public function generate_insert_news($rool,$host,$user,$pass,$dbname,$id_news){
			if(!$rool['read']){
				//echo "Нет прав для просмотра!";
				if($rool['block']==1){
					include_once('tamplate/block.html');
				}
			die(""); // Выходит из скрипта, если нет прав
			}
			if(!$rool['write']) $rool_edit = "0";
			else $rool_edit = "1";
			
		$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
		$db = mysql_select_db($dbname, $conn);
		mysql_query("SET NAMES utf8");
		if(!$rool['write']){
				$rool_edit = "0";
				$sql="SELECT * FROM news, category WHERE news.id = '$id_news' and news.category = category.id_category and news.status = '1' and news.type = '1'";
		}
			else{
				$rool_edit = "1";
				$sql="SELECT * FROM news, category WHERE news.id = '$id_news' and news.category = category.id_category and news.type = '1'";
			}
		
		$res=mysql_query($sql);
		while($row = mysql_fetch_array($res)){
                $id      		= $row['id'];
			   	$review			= $row['review'];				
                $logo_news   	= $row['logo_news'];
				$news			= $row['news'];
				$category_name	= $row["category_name"];
				$id_category	= $row["category"];
				$date			= $row["date"];
				$news = htmlspecialchars_decode($news);
				$img_n1			= $row["img_n1"];
				$img_n2			= $row["img_n2"];
				$img_n3			= $row["img_n3"];
				$img_n4			= $row["img_n4"];
				$img_n5			= $row["img_n5"];
				$img_b1			= $row["img_b1"];
				$img_b2			= $row["img_b2"];
				$img_b3			= $row["img_b3"];
				$img_b4			= $row["img_b4"];
				$img_b5			= $row["img_b5"];
				
				$review = $review + 1;
			   	mysql_query("UPDATE `sportkam`.`news` SET `review` = '$review' WHERE `news`.`id` = '$id';");
				
				$date1 = new DateTime($date);
				$date = $date1->format('d.m.Y H:i');
				$logo_news = htmlspecialchars_decode($logo_news);
				$news = htmlspecialchars_decode($news);
				// authoriz editor
				if($rool_edit==1) $edit1 = "<a href=\"/index.php?page=edit_news&id_news=".$id."\">[Редактировать]</a>";
				else $edit1 = "";
				// gen photo
				$img_n="";
				if(empty($img_n1)) $img_n="";
				if(!empty($img_n1)){
				if(!empty($img_n1))	$img_n = $img_n."<div><a rel=\"group\" href=\"".$img_b1."\" title=\"".$logo_news."\"><img src=\"".$img_n1."\" height=\"100\"></a>";
				if(!empty($img_n2))	$img_n = $img_n." <a rel=\"group\" href=\"".$img_b2."\"><img src=\"".$img_n2."\" height=\"100\"></a>";
				if(!empty($img_n3))	$img_n = $img_n." <a rel=\"group\" href=\"".$img_b3."\"><img src=\"".$img_n3."\" height=\"100\"></a>";
				if(!empty($img_n4))	$img_n = $img_n." <a rel=\"group\" href=\"".$img_b4."\"><img src=\"".$img_n4."\" height=\"100\"></a>";
				if(!empty($img_n5))	$img_n = $img_n." <a rel=\"group\" href=\"".$img_b5."\"><img src=\"".$img_n5."\" height=\"100\"></a>";
				$img_n = $img_n."</div>";
				}
				// generate news and photo
				$an_news = $this->gen_another_news($id_category);
				$an_photo = $this->gen_another_photo($id_category);
				$news_text = $category_name.".+/".$logo_news.".+/".$date.".+/".$news.".+/".$id.".+/".$id_category.".+/".$edit1.".+/".$img_n.".+/".$an_news.".+/".$an_photo;  
							
		}
		
		
		return $news_text;
	}

	public function insert_news($rool,$host,$user,$pass,$dbname,$creator){
		if(!$rool['write']) $result = "Вы не имеете прав на изменение/удаление контента";
		else {
		if (!empty($_POST)){
			$a = array();
			foreach ($_POST as $key => $value){
				if ((!is_string($value)&&!is_numeric($value)) || !is_string($key))	continue;
				if (get_magic_quotes_gpc())	$value = htmlspecialchars(stripslashes((string)$value));
				else
				$value = htmlspecialchars((string)$value);
				$a[$key]=$value;
		}
		$mini_img		= $a['mini_img'];
		include_once("filesystem.php");// edit for linux ??
		$filesystem = new filesystem;
		$mini_img = $filesystem->resize ($mini_img, '300');
		
		$logo_news   	= $a['logo_news'];
		$mini_news   	= $a['mini_news'];
		$news   		= $a['news'];
		$category   	= $a['category'];		
		$mini_news = htmlspecialchars($mini_news, ENT_QUOTES);
		$news = htmlspecialchars($news, ENT_QUOTES);
		//$creator = $bus["id_user"];
		// защититть от скриптов и нелегальных тэгов
		$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
		$db = mysql_select_db($dbname, $conn);
		mysql_query("SET NAMES utf8");
		$query = "INSERT INTO `news`
				(`id`, `logo_news`, `news`, `date`, `category`, `review`, `mini_news`, `mini_img`, `creator`, `moderate`, `status`, `type`)
		 VALUES ('', '$logo_news', '$news',now(),'$category', '0', '$mini_news', '$mini_img', '$creator', '0' ,'0', '1')";
		$result = mysql_query($query) or die(mysql_error());
		if($result == 1) $result = "Новость успешно добавлена!";
		else $result = "Случилась проблема с добавлением новостей!";
		}
		else $result = "";
	  }
	  return $result;
	}

	public function edit_content($rool,$page,$host,$user,$pass,$dbname,$id_user){
		if(!$rool["del"]) $_del = 0;
		else $_del = 1;
		if(!$rool['write']) $result = "Вы не имеете прав на изменение/удаление контента".".+/*.+/*.+/*.+/*.+/*.+/*.+/*.+/*";
		else {
		$result="";
		if (!empty($_POST)){
			$a = array();
			foreach ($_POST as $key => $value){
				if ((!is_string($value)&&!is_numeric($value)) || !is_string($key))	continue;
				if (get_magic_quotes_gpc())	$value = htmlspecialchars(stripslashes((string)$value));
				else
				$value = htmlspecialchars((string)$value);
				$a[$key]=$value;
			}
			$id_news		= $a['id_news'];
			$logo_news   	= $a['logo_news'];
			$mini_news   	= $a['mini_news'];
			$news   		= $a['news'];
			$mini_img		= $a['mini_img'];
			include_once("filesystem.php");
			$filesystem = new filesystem;
			$mini_img = $filesystem->resize ($mini_img, '300');
			$id_category   	= $a['category'];
			$status			= $a['status'];
			$img_n1			= ""; $img_b1			= "";
			$img_n2			= ""; $img_b2			= "";
			$img_n3			= ""; $img_b3			= "";
			$img_n4			= ""; $img_b4			= "";
			$img_n5			= ""; $img_b5			= "";
			if (!empty($a['img_n1'])) {
			$img_b1			= $a['img_n1'];	
			$img_n1			= $a['img_n1'];
			$img_n1 		= $filesystem->resize_n ($img_n1, '300');
			$img_n1 = htmlspecialchars($img_n1, ENT_QUOTES);
			}
			if (!empty($a['img_n2'])) {
			$img_b2			= $a['img_n2'];			
			$img_n2			= $a['img_n2'];
			$img_n2 		= $filesystem->resize_n ($img_n2, '300');
			$img_n2 = htmlspecialchars($img_n2, ENT_QUOTES);
			}
			if (!empty($a['img_n3'])) {
			$img_b3			= $a['img_n3'];
			$img_n3			= $a['img_n3'];
			$img_n3 		= $filesystem->resize_n ($img_n3, '300');
			$img_n3 = htmlspecialchars($img_n3, ENT_QUOTES);
			}
			if (!empty($a['img_n4'])) {
			$img_b4			= $a['img_n4'];
			$img_n4			= $a['img_n4'];
			$img_n4 		= $filesystem->resize_n ($img_n4, '300');
			$img_n4 = htmlspecialchars($img_n4, ENT_QUOTES);
			}
			if (!empty($a['img_n5'])) {
			$img_b5			= $a['img_n5'];
			$img_n5			= $a['img_n5'];
			$img_n5 		= $filesystem->resize_n ($img_n5, '300');
			$img_n5 = htmlspecialchars($img_n5, ENT_QUOTES);
			}
			$mini_news = htmlspecialchars($mini_news, ENT_QUOTES);
			$news = htmlspecialchars($news, ENT_QUOTES);
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			if($_del==0){
			$query = "UPDATE `sportkam`.`news` SET `logo_news` = '$logo_news', `news` = '$news', `category` = '$id_category', `mini_news` = '$mini_news', `mini_img` = '$mini_img', `moderate` = '$id_user', `img_n1` = '$img_n1', `img_n2` = '$img_n2', `img_n3` = '$img_n3', `img_n4` = '$img_n4', `img_n5` = '$img_n5', `img_b1` = '$img_b1', `img_b2` = '$img_b2', `img_b3` = '$img_b3', `img_b4` = '$img_b4', `img_b5` = '$img_b5' WHERE `news`.`id` = '$id_news'";
			}
			elseif($_del==1){	
			$query = "UPDATE `sportkam`.`news` SET `logo_news` = '$logo_news', `news` = '$news', `category` = '$id_category', `mini_news` = '$mini_news', `mini_img` = '$mini_img', `moderate` = '$id_user', `status` = '$status', `img_n1` = '$img_n1', `img_n2` = '$img_n2', `img_n3` = '$img_n3', `img_n4` = '$img_n4', `img_n5` = '$img_n5', `img_b1` = '$img_b1', `img_b2` = '$img_b2', `img_b3` = '$img_b3', `img_b4` = '$img_b4', `img_b5` = '$img_b5' WHERE `news`.`id` = '$id_news'";
			}
			$result = mysql_query($query) or die(mysql_error());
			if($result == 1) $result = "Новость успешно отредактирована!";
			else $result = "Случилась проблема с добавлением новостей!";	
			}
			$id_news = $_GET["id_news"];
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			$sql="SELECT * FROM news, category WHERE news.id = '$id_news' and news.category = category.id_category";
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$news_text="";
			$news="";
				while($row = mysql_fetch_array($res)){
				$id_news      	= $row['id']; 
				$logo_news   	= $row['logo_news'];
				$mini_news   	= $row['mini_news'];
				$news 			= $row['news'];
				$mini_img		= $row['mini_img'];
				$id_category	= $row['id_category'];
				$category		= $row['category_name'];
				$status			= $row['status'];
				$logo_news		= htmlspecialchars_decode($logo_news);
				$mini_news 		= htmlspecialchars_decode($mini_news);
				$news		 	= htmlspecialchars_decode($news);
				$img_n1			= $row['img_b1'];
				$img_n2			= $row['img_b2'];
				$img_n3			= $row['img_b3'];
				$img_n4			= $row['img_b4'];
				$img_n5			= $row['img_b5'];
				}
			$result = $result.".+/".$logo_news.".+/".$mini_news.".+/".$news.".+/".$id_category.".+/".$category.".+/".$mini_img.".+/".$id_news.".+/".$status.".+/".$img_n1.".+/".$img_n2.".+/".$img_n3.".+/".$img_n4.".+/".$img_n5;
		  }
		return $result;
		}
		
	public function generate_cat_news($rool,$host,$user,$pass,$dbname,$_category){
		if(!$rool['read']){
		//echo "Нет прав для просмотра!";
		if($rool['block']==1){
			include_once('tamplate/block.html');
		}
		die(""); // Выходит из скрипта, если нет прав
		}
		if(!$rool['write']) $rool_edit=0;
		else $rool_edit=1;
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			$sql="SELECT * FROM news, category WHERE news.category = category.id_category and `status` = '1' and news.category = '$_category' and news.type = '1' ORDER BY `news`.`date` DESC";
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$news_text="";
			$news="";

			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
				$id      		= $row['id'];
				$logo_news   	= $row['logo_news'];
				$mini_news   	= $row['mini_news'];
				$review   		= $row['review'];
				$_date			= $row['date'];
				$mini_img		= $row['mini_img'];
				$id_category	= $row['category'];
				$category		= $row['category_name'];
				$_date1 = new DateTime($_date);
				$_date = $_date1->format('d.m.Y H:i');
				$logo_news = htmlspecialchars_decode($logo_news);
				$mini_news = htmlspecialchars_decode($mini_news);
				$mini_news = htmlspecialchars_decode($mini_news);
                $sql3="SELECT count(*)FROM `rche_comments` WHERE `id_news` = '$id'";
                $res3=mysql_query($sql3);
                $row3 = mysql_fetch_array($res3);
                $comments       = $row3['count(*)'];
				if($rool_edit == 1)	$edit = "<a href=\"/index.php?page=edit_news&id_news=".$id ."\">[Редактировать]</a>";
				else $edit = "";
                    $news_text = "<div class=\"news\">
								<img src=\"".$mini_img."\" width=\"129\" height=\"96\" align=\"left\" >
								<div class=\"news_text\">
								<a href='/index.php?page=news&id=".$id."'><h3>".$logo_news."</h3></a>
								".$mini_news."<br/>
								<div class=\"bottom_text\">
								<!--<img src=\"img/icon_comment.gif\" width=\"18\" height=\"14\"/> ".$comments."--> | <a href=\"index.php?page=cat_news&category=".$id_category."\">".$category."</a> | ".$edit."
								</div>
								</div>
								</div>";
                    $news=$news.$news_text;
				}
			}
			$news = $news.".+/".$category;
			return $news;
	}
	
	public function generate_all_news($rool,$host,$user,$pass,$dbname){
		if(!$rool['read']){
		//echo "Нет прав для просмотра!";
		if($rool['block']==1){
			include_once('tamplate/block.html');
		}
		die(""); // Выходит из скрипта, если нет прав
		}
		if(!$rool['write']) $rool_edit=0;
		else $rool_edit=1;
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			$sql="SELECT * FROM news, category WHERE news.category = category.id_category and `status` = '1' and news.type = '1' ORDER BY `news`.`date` DESC";
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$news_text="";
			$news="";

			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
				$id      		= $row['id'];
				$logo_news   	= $row['logo_news'];
				$mini_news   	= $row['mini_news'];
				$review   		= $row['review'];
				$_date			= $row['date'];
				$mini_img		= $row['mini_img'];
				$id_category	= $row['category'];
				$category		= $row['category_name'];
				$_date1 = new DateTime($_date);
				$_date = $_date1->format('d.m.Y H:i');
				$logo_news = htmlspecialchars_decode($logo_news);
				$mini_news = htmlspecialchars_decode($mini_news);
				$mini_news = htmlspecialchars_decode($mini_news);
                $sql3="SELECT count(*)FROM `rche_comments` WHERE `id_news` = '$id'";
                $res3=mysql_query($sql3);
                $row3 = mysql_fetch_array($res3);
                $comments       = $row3['count(*)'];
				if($rool_edit == 1)	$edit = "<a href=\"/index.php?page=edit_news&id_news=".$id ."\">[Редактировать]</a>";
				else $edit = "";
                    $news_text = "<hr/><div class=\"news\">
								<img src=\"".$mini_img."\" width=\"129\" height=\"96\" align=\"left\" >
								<div class=\"news_text\">
								<a href='/index.php?page=news&id=".$id."'><h3>".$logo_news."</h3></a>
								".$mini_news."<br/>
								<div class=\"bottom_text\">
								<!--<img src=\"img/icon_comment.gif\" width=\"18\" height=\"14\"/> ".$comments."--> | <a href=\"index.php?page=cat_news&category=".$id_category."\">".$category."</a> |  ".$edit."
								</div>
								</div>
								</div>";
                    $news=$news.$news_text;
				}
			}
			$news = $news."<hr/>.+/";
			return $news;
	}
	
	public function generate_result($host,$user,$pass,$dbname){
		$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
		$db = mysql_select_db($dbname, $conn);
		mysql_query("SET NAMES utf8");
		$sql="SELECT * FROM `r_turnir`, `category` WHERE category.id_category=r_turnir.category and `hiden` ='0'";
		$res=mysql_query($sql);
		$count = mysql_num_rows($res);
		$text="";
		for($i=1; $i<=$count; $i++){
		while($row = mysql_fetch_array($res)){
		$id      		= $row['id']; 
		$name   		= $row['name'];
		$category   	= $row['category_name'];
		$tour="<div class=\"sport-title\">".$category."</div>
		<div class=\"event-title\">".$name."</div>";
		mysql_query("SET NAMES utf8");
		$sql1="SELECT * FROM `r_sesion` WHERE `r_turnir` = '".$id."' ORDER BY `r_sesion`.`num` ASC ";
		$res1=mysql_query($sql1);
		$count1 = mysql_num_rows($res1);
		$sessioner="";
		$session="";
					for($s=1; $s<=$count1; $s++){
						while($row1 = mysql_fetch_array($res1)){
						//$id      	= $row1['id'];
						$name1   	= $row1['name1'];
						$name2   	= $row1['name2'];
						//$date  		= $row1['date'];
						//$num		= $row1['num'];
						$score		= $row1['score'];
						$sessioner = "<div class=\"crylnk\">
						<div class=\"teamleft\">".$name1."</div>
						<div class=\"teamscore\">".$score."</div>
						<div class=\"teamright\">".$name2."</div>
						</div>";
						$session=$session.$sessioner;
						}
						$combo = $tour.$session;
					}
		$text = $text.$combo;
		}
	}
	return $text;
	}

	public function generate_pop_news($host,$user,$pass,$dbname){
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			//
			$sql="SELECT * FROM `news` WHERE `status` = '1' and `type` = '1' and `date` >= ( CURDATE() - INTERVAL 31 DAY ) ORDER BY `news`.`review` DESC LIMIT 0 , 5";
			$res=mysql_query($sql);
			$count = 5; // кол-во отображаемых новостей
			$news="";
				for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
                $id      		= $row['id'];
                $logo_news   	= $row['logo_news'];
				$review   		= $row['review'];
                $sql3="SELECT count(*)FROM `rche_comments` WHERE `id_news` = '$id'";
                $res3=mysql_query($sql3);
                $row3 = mysql_fetch_array($res3);
                $comments       = $row3['count(*)'];
				$mini_img		= $row['mini_img'];
				$logo_news = htmlspecialchars_decode($logo_news);
				$news_text = "
        <div class=\"r_body\">
        <img src=\"".$mini_img."\" align=\"left\" width=\"69\" height=\"47\" />
        <a href='/index.php?page=news&id=".$id."'>".$logo_news."</a>
        <!-- <div style=\"bottom: 0px;margin-top:3px;\">
            <img src=\"img/icon_comment.gif\" width=\"18\" height=\"14\"/> ".$comments."  
        </div> -->
        </div>";
                    $news=$news.$news_text;
				}
			}
				$news="
		<div class=\"r_bar\">
		<div class=\"r_title\">
			Популярные статьи
        </div>".$news."</div>";
		return $news;
	}
	
	public function generate_klb($page){
		$status = 0;
		//echo $page;
		if($page == "klub/index")$status=1;
		if($page == "cat_news"){
			if($_GET['category']=="33" or $_GET['category']=="34")$status=1;	
		}
		if($page == "gallery"){
			if(!empty($_GET['category']))if($_GET['category']=="34" or $_GET['category']=="35")$status=1;	
		}
		if($page == "news"){
			if(!empty($_GET['id']))if($_GET['id']=="317")$status=1;	
		}
	return $status;	
	}
	
	public function generate_slider($host,$user,$pass,$dbname){
		
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			$sql="SELECT * FROM `slider` ORDER BY `slider`.`date` DESC LIMIT 5"; // ORDER BY `slider`.`id` DESC LIMIT 0 , 5";
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$nc_content = "";
			$sp_content = "";
			$pt_name1 = "";
			$pt_text1 = "";

			$nc_link_name1 = "";
			$nc_link_name2 = "";
			$nc_src1 = "";
			$nc_alter_text1 = "";
			$sp_src1 = "";
			$sp_alter_text1 = "";
			$slider_u = "<div class=\"sliderkit photosgallery-vertical\">";
			  for($i=1; $i<=$count; $i++){
			  while($row = mysql_fetch_array($res)){

				//$id      		= $row['id'];
				$nc_link      	= $row['nc_link'];				
				$nc_link_name   = $row['nc_link_name'];
				$nc_src      	= $row['nc_src'];
				$nc_alter_text  = $row['nc_alter_text'];
				$sp_src    		= $row['sp_src'];
				$sp_alter_text	= $row['sp_alter_text'];
				$pt_name    	= $row['pt_name'];
				$pt_text     	= $row['pt_text'];

				$nc_link      	= htmlspecialchars_decode($nc_link);
				$nc_link_name   = htmlspecialchars_decode($nc_link_name);
				$nc_src      	= htmlspecialchars_decode($nc_src);
				$nc_alter_text  = htmlspecialchars_decode($nc_alter_text);
				$sp_src    		= htmlspecialchars_decode($sp_src);
				$sp_alter_text	= htmlspecialchars_decode($sp_alter_text);
				$pt_name    	= htmlspecialchars_decode($pt_name);
				$pt_text     	= htmlspecialchars_decode($pt_text);
			
				$nc_link_name1 = $nc_link_name1."|+*+|".$nc_link;
				$nc_link_name2 = $nc_link_name2."|+*+|".$nc_link_name;
				$nc_src1 = $nc_src1."|+*+|".$nc_src;
				$nc_alter_text1 = $nc_alter_text1."|+*+|".$nc_alter_text;
				$sp_src1 = $sp_src1."|+*+|".$sp_src;
				$sp_alter_text1 = $sp_alter_text1."|+*+|".$sp_alter_text;
				$pt_name1 = $pt_name1."|+*+|".$pt_name;
				$pt_text1 = $pt_text1."|+*+|".$pt_text;

				$nc_content = $nc_content."<li><a href=\"#\" rel=\"nofollow\" title=\"".$nc_link_name."\"><img src=\"".$nc_src."\" alt=\"".$nc_alter_text."\" /></a></li>"; 
				$sp_content = $sp_content."
				<div class=\"sliderkit-panel\">
							<a href=\"".$nc_link ."\"><img src=\"".$sp_src."\" alt=\"".$sp_alter_text."\" width=\"595\" height=\"335\" />
							<div class=\"sliderkit-panel-textbox\">
								<div class=\"sliderkit-panel-text\">
									<h5>".$pt_name."</h5>
									<p>".$pt_text."</p>
								</div>
								<div class=\"sliderkit-panel-overlay\"></div>
							</div></a>
						</div>";  
			  }
		  }
		$slider = "<div class=\"sliderkit-nav\">						
						<div class=\"sliderkit-nav-clip\">
							<ul>";
		$slider_str = "</ul>
						</div>
</div><div class=\"sliderkit-panels\">";
		$slider_d = "</div></div>";		
				$slider = $slider_u.$slider.$nc_content.$slider_str.$sp_content.$slider_d.$nc_link_name1.$nc_link_name2.$nc_src1.$nc_alter_text1.$sp_src1.$sp_alter_text1.$pt_name1.$pt_text1;
		return $slider;
	}

	public function edit_slider($host,$user,$pass,$dbname,$rool){
		if($rool['write']==0) {
			$result = "Вы не имеете прав на изменение/удаление контента";
			return $result;
			exit;
		}
		else {
				$result = "";
				if (!empty($_POST)){
					$a = array();
					foreach ($_POST as $key => $value){
						if ((!is_string($value)&&!is_numeric($value)) || !is_string($key))	continue;
						if (get_magic_quotes_gpc())	$value = htmlspecialchars(stripslashes((string)$value));
						else
						$value = htmlspecialchars((string)$value);
						$a[$key]=$value;
				}
				
				$nc_link1 		= $a['nc_link1'];
				$nc_lnk1 		= $a['nc_lnk1'];
				$nc_src1 		= $a['nc_src1'];
				$nc_alt_txt1 	= $a['nc_alt_txt1'];
				$sp_src1 		= $a['sp_src1'];
				$sp_alt_txt1 	= $a['sp_alt_txt1'];
				$pt_name1 		= $a['pt_name1'];
				$pt_text1 		= $a['pt_text1'];
		
				$nc_link2 		= $a['nc_link2'];
				$nc_lnk2 		= $a['nc_lnk2'];
				$nc_src2 		= $a['nc_src2'];
				$nc_alt_txt2 	= $a['nc_alt_txt2'];
				$sp_src2 		= $a['sp_src2'];
				$sp_alt_txt2 	= $a['sp_alt_txt2'];
				$pt_name2 		= $a['pt_name2'];
				$pt_text2 		= $a['pt_text2'];
		
				$nc_link3 		= $a['nc_link3'];
				$nc_lnk3 		= $a['nc_lnk3'];
				$nc_src3 		= $a['nc_src3'];
				$nc_alt_txt3 	= $a['nc_alt_txt3'];
				$sp_src3 		= $a['sp_src3'];
				$sp_alt_txt3 	= $a['sp_alt_txt3'];
				$pt_name3 		= $a['pt_name3'];
				$pt_text3 		= $a['pt_text3'];
		
				$nc_link4 		= $a['nc_link4'];
				$nc_lnk4 		= $a['nc_lnk4'];
				$nc_src4 		= $a['nc_src4'];
				$nc_alt_txt4 	= $a['nc_alt_txt4'];
				$sp_src4 		= $a['sp_src4'];
				$sp_alt_txt4 	= $a['sp_alt_txt4'];
				$pt_name4 		= $a['pt_name4'];
				$pt_text4 		= $a['pt_text4'];
		
				$nc_link5 		= $a['nc_link5'];
				$nc_lnk5 		= $a['nc_lnk5'];
				$nc_src5 		= $a['nc_src5'];
				$nc_alt_txt5 	= $a['nc_alt_txt5'];
				$sp_src5 		= $a['sp_src5'];
				$sp_alt_txt5 	= $a['sp_alt_txt5'];
				$pt_name5 		= $a['pt_name5'];
				$pt_text5 		= $a['pt_text5'];
				
				$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
				$db = mysql_select_db($dbname, $conn);
				mysql_query("SET NAMES utf8");
						
				$query1 = "
				UPDATE `sportkam`.`slider` SET `nc_link`='".$nc_link1."', `nc_link_name`='".$nc_lnk1."', `nc_src`='".$nc_src1."', `nc_alter_text`='".$nc_alt_txt1."', `sp_src`='".$sp_src1."', `sp_alter_text`='".$sp_alt_txt1."', `pt_name`='".$pt_name1."', `pt_text`='".$pt_text1."', `date`=now() WHERE `slider`.`id` = 1;";
				
				$query2 = "UPDATE `sportkam`.`slider` SET `nc_link`='".$nc_link2."', `nc_link_name`='".$nc_lnk2."', `nc_src`='".$nc_src2."', `nc_alter_text`='".$nc_alt_txt2."', `sp_src`='".$sp_src2."', `sp_alter_text`='".$sp_alt_txt2."', `pt_name`='".$pt_name2."', `pt_text`='".$pt_text2."', `date`=now() WHERE `slider`.`id` = 2;"; 
				
				$query3 = "UPDATE `sportkam`.`slider` SET `nc_link`='".$nc_link3."', `nc_link_name`='".$nc_lnk3."', `nc_src`='".$nc_src3."', `nc_alter_text`='".$nc_alt_txt3."', `sp_src`='".$sp_src3."', `sp_alter_text`='".$sp_alt_txt3."', `pt_name`='".$pt_name3."', `pt_text`='".$pt_text3."', `date`=now() WHERE `slider`.`id` = 3;";
				
				$query4 = "UPDATE `sportkam`.`slider` SET `nc_link`='".$nc_link4."', `nc_link_name`='".$nc_lnk4."', `nc_src`='".$nc_src4."', `nc_alter_text`='".$nc_alt_txt4."', `sp_src`='".$sp_src4."', `sp_alter_text`='".$sp_alt_txt4."', `pt_name`='".$pt_name4."', `pt_text`='".$pt_text4."', `date`=now() WHERE `slider`.`id` = 4;";
				
				$query5 = "UPDATE `sportkam`.`slider` SET `nc_link`='".$nc_link5."', `nc_link_name`='".$nc_lnk5."', `nc_src`='".$nc_src5."', `nc_alter_text`='".$nc_alt_txt5."', `sp_src`='".$sp_src5."', `sp_alter_text`='".$sp_alt_txt5."', `pt_name`='".$pt_name5."', `pt_text`='".$pt_text5."', `date`=now() WHERE `slider`.`id` = 5;";

				$r1 = mysql_query($query1) or die(mysql_error());
				$r2 = mysql_query($query2) or die(mysql_error());
				$r3 = mysql_query($query3) or die(mysql_error());
				$r4 = mysql_query($query4) or die(mysql_error());
				$r5 = mysql_query($query5) or die(mysql_error());		
				if($r1 == 1 and $r2 == 1 and $r3 == 1 and $r4 == 1 and $r5 == 1) {
					$result = "Отредактированно";//$result = "Новость успешно добавлена!"
				}
				else $result = "Не возможно отредактировать, есть ошибки в запросе!";
				
			  }	
		}
		return $result;
	}
	
	public function add_section($rool,$page,$host,$user,$pass,$dbname,$creator){		
		$result = "";
		if(!$rool['write']) $result = "Вы не имеете прав на изменение/удаление контента";
		else {
		if (!empty($_POST)){
			$a = array();
			foreach ($_POST as $key => $value){
				if ((!is_string($value)&&!is_numeric($value)) || !is_string($key))	continue;
				if (get_magic_quotes_gpc())	$value = htmlspecialchars(stripslashes((string)$value));
				else
				$value = htmlspecialchars((string)$value);
				$a[$key]=$value;
			}
		
		$logo_news   	= $a['logo_news'];
		$category   	= $a['category'];
		$news   		= $a['news'];
				
		$news = htmlspecialchars($news, ENT_QUOTES);
		$type = ""; // inc type
		
		//$creator = $bus["id_user"];
		// защититть от скриптов и нелегальных тэгов
		$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
		$db = mysql_select_db($dbname, $conn);
		mysql_query("SET NAMES utf8");
		$query = "INSERT INTO `news`
				(`id`, `logo_news`, `news`, `date`, `category`, `review`, `mini_news`, `mini_img`, `creator`, `moderate`, `status`, `type`)
		 VALUES ('', '$logo_news', '$news',now(),'$category', '0', '', '', '$creator', '0' ,'1' , '2')";
		$result = mysql_query($query) or die(mysql_error());
		if($result == 1) $result = "Новость успешно добавлена! <a href=\"/index.php?page=all_section\">Все секции</a>";
		else $result = "Случилась проблема с добавлением новостей!";
		}
		else $result = "";
	  }
	  return $result;
	}
	/////////////////////////////////////////////////////////////////////////
	public function all_section($rool,$page,$host,$user,$pass,$dbname){
		if(!$rool['write']) $rool_edit=0;
		else $rool_edit=1;
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			$sql="SELECT * FROM news WHERE `type` = 2 ORDER BY `news`.`date` DESC";
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$news_text="";
			$news="";

			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
				$id      		= $row['id'];
				$logo_news   	= $row['logo_news'];
				$mini_news   	= "";//$row['mini_news'];
				//$review   		= $row['review'];
				$_date			= $row['date'];
				$mini_img		= "";//$row['mini_img'];
				$id_category	= $row['category'];
				//$category		= $row['category_name'];
				$_date1 = new DateTime($_date);
				$_date = $_date1->format('d.m.Y H:i');
				$logo_news = htmlspecialchars_decode($logo_news);
				//$mini_news = htmlspecialchars_decode($mini_news);
				//$mini_news = htmlspecialchars_decode($mini_news);
                /*
				$sql3="SELECT count(*)FROM `rche_comments` WHERE `id_news` = '$id'";
                $res3=mysql_query($sql3);
                $row3 = mysql_fetch_array($res3);
				*/
                //$comments       = $row3['count(*)'];
				if($id_category == 1) $id_category = "Тренер";
				if($id_category == 2) $id_category = "Лучший выпускник";
				if($id_category == 3) $id_category = "Расписание";
				if($id_category == 4) $id_category = "Контакты";
				if($id_category == 5) $id_category = "Отделение";
				if($id_category == 6) $id_category = "КЛБ";
				if($id_category == 7) $id_category = "Полы";
				if($rool_edit == 1)	$edit = "<a href=\"/index.php?page=edit_news&id_news=".$id ."\">[Редактировать]</a>";
				else $edit = "";
                    $news_text = "<div class=\"news\">
								<img src=\"/img/logo.png\" width=\"129\" height=\"96\" align=\"left\" >
								<div class=\"news_text\">
								<a href='/index.php?page=section_weav&id=".$id."'><h3>".$logo_news."</h3></a>
								".$mini_news."<br/>	".$id_category." <a href=\"/index.php?page=edit_section&id_news=".$id."\">[Редактировать]</a>
								</div>
								</div>";
                    $news=$news.$news_text;
				}
			}
			return $news;
	}
	
	public function edit_section($rool,$page,$host,$user,$pass,$dbname,$id_user){
		if(!$rool["del"]) $_del = 0;
		else $_del = 1;
		if(!$rool['write']) $result = "Вы не имеете прав на изменение/удаление контента".".+/*.+/*.+/*.+/*.+/*.+/*.+/*.+/*";
		else {
		$result="";
		
		if (!empty($_POST)){
			$a = array();
			foreach ($_POST as $key => $value){
				if ((!is_string($value)&&!is_numeric($value)) || !is_string($key))	continue;
				if (get_magic_quotes_gpc())	$value = htmlspecialchars(stripslashes((string)$value));
				else
				$value = htmlspecialchars((string)$value);
				$a[$key]=$value;
			}
			$id_news		= $a['id_news'];
			$logo_news   	= $a['logo_news'];
			$mini_news   	= "";
			$news   		= $a['news'];
			//$mini_img		= $a['mini_img'];
			$id_category   	= $a['category'];
			//$status			= $a['status'];

			//$mini_news = htmlspecialchars($mini_news, ENT_QUOTES);
			$news = htmlspecialchars($news, ENT_QUOTES);
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			if($_del==0){
			//$query = "UPDATE `sportkam`.`news` SET `logo_news` = '$logo_news', `moderate` = '$id_user'";
			}
			elseif($_del==1){	
			$query = "UPDATE `sportkam`.`news` SET `logo_news` = '$logo_news', `news` = '$news', `category` = '$id_category', `status` = '1', `mini_img` = '' WHERE `news`.`id` = '$id_news';";
			//UPDATE `sportkam`.`news` SET `logo_news` = 'тест1', `news` = '&amp;lt;p&amp;gt;апваварвар&amp;lt;/p&amp;gt; 1', `category` = '2', `status` = '1' WHERE `news`.`id` = 148;   UPDATE `sportkam`.`news` SET `logo_news` = '$logo_news', `moderate` = '$id_user'
			}
			$result = mysql_query($query) or die(mysql_error());
			if($result == 1) $result = "Новость успешно отредактирована!";
			else $result = "Случилась проблема с добавлением новостей!";	
			}
			
		if(!empty($_GET['del'])){
			if($_GET['del'] == 1){
				$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
				$db = mysql_select_db($dbname, $conn);
				$id_del = $_GET['id_news'];
				mysql_query("DELETE FROM `sportkam`.`news` WHERE `news`.`id` = $id_del");
				$result="Новость удалена!";	
			}
		}			
			if(isset($id_del)){
				$result .=".+/*.+/*.+/*.+/*.+/";
			}
			else{
				
			$id_news = $_GET["id_news"];
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8");
			$sql="SELECT * FROM news WHERE news.id = '$id_news' and news.type = 2;";
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$news_text="";
			$news="";
				while($row = mysql_fetch_array($res)){
				$id_news      	= $row['id']; 
				$logo_news   	= $row['logo_news'];
				$news 			= $row['news'];
				$id_category	= $row['category'];
				$logo_news		= htmlspecialchars_decode($logo_news);
				$news		 	= htmlspecialchars_decode($news);
				if($id_category == 1) $category = "Тренер";
				if($id_category == 2) $category = "Лучший выпускник";
				if($id_category == 3) $category = "Расписание";
				if($id_category == 4) $category = "Контакты";
				if($id_category == 5) $category = "Отделение";
				}
			$result = $result.".+/".$logo_news.".+/".$news.".+/".$id_category.".+/".$category.".+/".$id_news;
		  }
		}
		return $result;
	}
	
	public function generate_insert_section($rool,$host,$user,$pass,$dbname,$id_news){
		if(!$rool['write']) $rool_edit = "0";
		else $rool_edit = "1";
		$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
		$db = mysql_select_db($dbname, $conn);
		mysql_query("SET NAMES utf8");
		$sql="SELECT * FROM news WHERE id = '$id_news' and `type` = 2";
		$res=mysql_query($sql);
		while($row = mysql_fetch_array($res)){
                $id      		= $row['id'];
			   	//$review			= $row['review'];				
                $logo_news   	= $row['logo_news'];
				$news			= $row['news'];
				$category_name	= "";//$row["category_name"];
				$id_category	= $row["category"];
				//$date			= $row["date"];
				$news = htmlspecialchars_decode($news);
				//$date1 = new DateTime($date);
				//$date = $date1->format('d.m.Y H:i');
				$date="";
				$logo_news = htmlspecialchars_decode($logo_news);
				$news = htmlspecialchars_decode($news);
				// authoriz editor
				if($rool_edit==1) $edit1 = "<a href=\"/index.php?page=edit_section&id_news=".$id."\">[Редактировать]</a>";
				else $edit1 = "";
				
				function gen_another_news(){
				  $sql1="SELECT * FROM `news` WHERE  `status` = '1' and `type` = '1' ORDER BY `date` DESC LIMIT 25;";
				  $res1=mysql_query($sql1);
				  $count1 = mysql_num_rows($res1);
				  //print_r($count1);
				  for($i=1; $i<=$count1; $i++){
					  $row1 = mysql_fetch_array($res1);
					  $id[$i]      		= $row1['id'];
					  $logo_news[$i]   	= $row1['logo_news'];
				  }
				  $new = "";
				  for($i=1; $i<=5; $i++){
				  $in = rand(1, $count1);
				  $new .= "<a href=\"/index.php?page=news&id=".$id[$in]."\">".$logo_news[$in]."</a><br/>"; 
				  }
				  return $new;
				}
				
				function gen_photo($id_category){
					$sql="SELECT `id_img` FROM `gallery_category`, `gallery_album`, `gallery_img` WHERE gallery_category.id_cat = gallery_album.id_cat and gallery_album.id_alb = gallery_img.id_alb ORDER BY `gallery_img`.`date` DESC LIMIT 0, 120;";
					if($id_category == 6){
						$sql="SELECT `id_img` FROM `gallery_category`, `gallery_album`, `gallery_img` WHERE gallery_category.id_cat = gallery_album.id_cat and gallery_album.id_alb = gallery_img.id_alb ORDER BY `gallery_img`.`date` DESC LIMIT 0, 120;";
					}
					$res=mysql_query($sql);
					$count= mysql_num_rows($res);
					for($i=1; $i<=$count; $i++){
						$row = mysql_fetch_array($res);
						$id_img1[$i] = $row['id_img'];
					}
					$new = "";
					for($i=1; $i<=4; $i++){
						$in = rand(1, $count);
						$id_img = $id_img1[$in];
						$sql1 = "SELECT * FROM `gallery_img` WHERE `id_img` = $id_img";
						$res1=mysql_query($sql1);
						$row1 = mysql_fetch_array($res1);
							//$id_img2 = $row1['id_img'];
							$mini_pic1 = $row1['mini_pic'];
							//echo $id_img2;
							$id_alb   = $row1['id_alb'];
						$new .= " <a href=\"/index.php?page=gallery&view=watch_albom&albom=".$id_alb."\"><img src=\"".$mini_pic1."\" height=\"100\"></a> ";
					}
					return $new;	
				}
				
				$new = gen_another_news();
				$pht = gen_photo($id_category);
				$news_text = $category_name.".+/".$logo_news.".+/".$date.".+/".$news.".+/".$id.".+/".$id_category.".+/".$edit1.".+/".$new.".+/".$pht;  
		}
		
		
		return $news_text;
	}
	
	public function gen_another_news($category){
		$news = "";
		
		$sql="SELECT* FROM `news` WHERE `category` = $category and `status` = '1' and `type` = '1';";
		$res=mysql_query($sql);
		$count = mysql_num_rows($res);
		
		for($i=1; $i<=$count; $i++){
			$row = mysql_fetch_array($res);
			$id[$i]      		= $row['id'];
			$logo_news[$i]   	= $row['logo_news'];
		}
		
		for($i=1; $i<=5; $i++){
		$in = rand(1, $count);
		$news .= "<a href=\"/index.php?page=news&id=".$id[$in]."\">".$logo_news[$in]."</a><br/>"; //;
		}
		
	return $news;	
	}
	
	public function gen_another_photo($id_category){
		
		/*
1 	Футбол
2 	Волейбол
3 	Баскетбол
4 	Плавание
5 	Фитнес
6 	Бодибилдинг
7 	Легкая атлетика
8 	Тяжелая атлетика
9 	Каратэ
10 	Дзюдо
11 	Гандбол
12 	Велоспорт
13 	Шахматы
14 	Рыбалка
15 	Настольный теннис
16 	Бильярд
17 	Боулинг
18 	Автоспорт
19 	Мотоспорт
20 	Парусный спорт
21 	Зимние виды
22 	Лыжные гонки
23 	Покер
24 	Страйкбол
25 	Спортивное ориентирование
26 	Стрельба
27 	Экстрим
28 	Ролинг
29 	Прочее - 33
30 	Бокс
31 	Единоборства
32 	Тхэквондо
		*/
		if($id_category == 1)  $ni = "1";
		if($id_category == 2)  $ni = "2";
		if($id_category == 3)  $ni = "3";
		if($id_category == 4)  $ni = "4";
		if($id_category == 5)  $ni = "5,6,8";
		if($id_category == 6)  $ni = "6,8,5";
		if($id_category == 7)  $ni = "7";
		if($id_category == 8)  $ni = "8,6,31,32,5";
		if($id_category == 9)  $ni = "30,9,10,32,31";
		if($id_category == 10) $ni = "30,9,10,32,31";
		if($id_category == 11) $ni = "11,1";
		if($id_category == 12) $ni = "12,7";
		if($id_category == 13) $ni = "13";
		if($id_category == 14) $ni = "14";
		if($id_category == 15) $ni = "15";
		if($id_category == 16) $ni = "16";
		//if($id_category == 17) $ni = ""; dead cat egor
		if($id_category == 18) $ni = "18,19";
		if($id_category == 19) $ni = "19,18";
		if($id_category == 20) $ni = "20";
		if($id_category == 21) $ni = "21";
		//if($id_category == 22) $ni = "";
		//if($id_category == 23) $ni = "";
		if($id_category == 24) $ni = "24";
		if($id_category == 25) $ni = "25";
		if($id_category == 26) $ni = "26";
		if($id_category == 27) $ni = "27";
		//if($id_category == 28) $ni = "";
		if($id_category == 29) $ni = "33"; // 33 - cat gallery
		if($id_category == 30) $ni = "30,9,10,31,32";
		if($id_category == 31) $ni = "31,30,9,10,32";
		if($id_category == 32) $ni = "32,30,9,10,31";
		if($id_category == 33) $ni = "34,35";
		if($id_category == 34) $ni = "35,34";
		if($id_category == 35) $ni = "8,6,31,32,5,35,34";
		
		$news = "";
		$new = "";
		$ni	= explode(",",$ni);
		$count_ni = count($ni) - 1;
		//print_r($ni);
		for($i=0; $i<=$count_ni; $i++){
			$sql="SELECT `id_img` FROM `gallery_category`, `gallery_album`, `gallery_img` WHERE gallery_category.id_cat = '".$ni[$i]."' and  gallery_category.id_cat = gallery_album.id_cat and gallery_album.id_alb = gallery_img.id_alb ORDER BY `gallery_img`.`date` DESC LIMIT 0, 30;";
			$res[$i]=mysql_query($sql);
			$count[$i] = mysql_num_rows($res[$i]);
			//echo $count[$i];
			if($count[$i]>0){	
			//echo $ni[$i]."-".$count[$i]."<hr>";	
				while($row = mysql_fetch_array($res[$i])){
					//print_r($row);
					$news .= $row['id_img']."/";
				}
			}
		}
		if(!empty($news)){
		//echo "<hr>";
		$ns	= explode("/",$news);
		//print_r($ns);
		//echo "<hr>";
		$count_ns = count($ns) - 2;
		//echo "<br>".$count_ns."<br>";
		$new = "";
		
		for($i=1; $i<=4; $i++){
			$in = rand(1, $count_ns);
			$id_img = $ns[$in];
			$sql1 = "SELECT * FROM `gallery_img` WHERE `id_img` =".$id_img;
			$res1=mysql_query($sql1);
			$row1 = mysql_fetch_array($res1);
				$mini_pic = $row1['mini_pic'];
				$id_alb   	  = $row1['id_alb'];
			$new .= " <a href=\"/index.php?page=gallery&view=watch_albom&albom=".$id_alb."\"><img src=\"".$mini_pic."\" height=\"100\"></a> ";
			// http://localhost/index.php?page=gallery&view=watch_albom&albom=14
		}	
		}
		return $new;
	}
	
		public function generate_klb_news($rool,$host,$user,$pass,$dbname){
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8"); 	
			
			if(empty($_GET['list'])){
				$list  = 0;
				$start = 0;
			}
			else {
				$list = $_GET['list'];
				if($list == 1) $start = 0;
				else $start = 6;
			}
			
			if(!$rool['write']){
				$rool_edit = "0";
				$sql="SELECT * FROM news, category WHERE news.category = category.id_category and `status` = '1' and `type` = '1' and news.category = 33 ORDER BY `news`.`date` DESC LIMIT $start , 6";
			}
			else{
				$rool_edit = "1";
				$sql="SELECT * FROM news, category WHERE news.category = category.id_category and `type` = '1' and news.category = 33 ORDER BY `news`.`date` DESC LIMIT $start , 6";
			}
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$news_text="";
			$news="";
			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
				$id      		= $row['id'];
				$logo_news   	= $row['logo_news'];
				$mini_news   	= $row['mini_news'];
				$review   		= $row['review'];
				$_date			= $row['date'];
				$mini_img		= $row['mini_img'];
				$id_category 	= $row['category'];
				$category		= $row['category_name'];
				$_date1 = new DateTime($_date);
				$_date = $_date1->format('d.m.Y H:i');
				$logo_news = htmlspecialchars_decode($logo_news);
				$mini_news = htmlspecialchars_decode($mini_news);
				$mini_news = htmlspecialchars_decode($mini_news);
                $sql3="SELECT count(*)FROM `rche_comments` WHERE `id_news` = '$id'";
                $res3=mysql_query($sql3);
                $row3 = mysql_fetch_array($res3);
                $comments       = $row3['count(*)'];
				if($rool_edit == 1){
					$edit = "<a  href=\"/index.php?page=edit_news&id_news=".$id ."\">[Редактировать]</a>";
					$edit1 = "<a href=\"/index.php?page=add_news\">[Добавить новость]</a> <a  href=\"/index.php?page=edit_slider\">[Редактировать слайдер]</a> <a  href=\"/index.php?page=add_section\">[Добавить секции]</a> <a  href=\"/index.php?page=all_section\">[Все секции]</a>";
				}
				else{
					$edit = "";
					$edit1 = "";
				}
                    $news_text = "<div class=\"news\">
								<img src=\"".$mini_img."\" width=\"129\" height=\"96\" align=\"left\" >
								<div class=\"news_text\">
								<a href='/index.php?page=news&id=".$id."'><h3>".$logo_news."</h3></a>
								".$mini_news."<br/>
								<div class=\"bottom_text\">
								<!--<img src=\"img/icon_comment.gif\" width=\"18\" height=\"14\"/> ".$comments."--> | <a href=\"index.php?page=cat_news&category=".$id_category."\">".$category."</a> | ".$_date." ".$edit."
								</div>
								</div>
								</div> <hr/>";
                    $news=$news.$news_text;
				}
			}
		return $news.".+/".$edit1;
	}
}

?>