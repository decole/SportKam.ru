<?php
class gallery{
	public function all_albom_cat($rool,$host,$user,$pass,$dbname){
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8"); 			
			$sql="SELECT * FROM gallery_category ORDER BY `num` ASC";
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$cat_albom="";
			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
				$id_cat      	= $row['id_cat'];
				$name   		= $row['name'];
				$mini_img   	= $row['mini_img'];
				$coll = $this->coll_albom($host,$user,$pass,$dbname,$id_cat);				
				$cat_albom .= "<div class=\"roll1\"><a href=\"index.php?page=gallery&view=alboms&category=".$id_cat."\">
				<img src=\"".$mini_img."\" alt=\"der\" /><br>".$name."<br>".$coll."</a></div>";				
				// http://localhost/test.php?view=alboms&category=1
                }
			}
			if(!$rool['write'])$edit = "";
			else $edit = ""; //<a href=\"index.php?page=gallery&view=edit_category\">Редактировать категории</a>";
		return $cat_albom.".+/".$edit;
	}	
	
	public function all_alboms($rool,$host,$user,$pass,$dbname,$category){
			$category = preg_replace("([^0-9])", "", $category);
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8"); 			
			$sql="SELECT * FROM `gallery_album`, `gallery_category` WHERE `gallery_category`.id_cat = `gallery_album`.id_cat and `gallery_category`.id_cat = $category ";
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$all_albom="";
			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
				$id_alb      	= $row['id_alb'];
				$id_cat   		= $row['id_cat'];
				$name_albom   	= $row['name_albom'];
				$name   		= $row['name'];
				$mini_img   	= $row['mini_img'];
				$logo_img		= $row['logo_img'];
				//  logo_img 	id_cat 	name 	mini_img  
				//$_date1 = new DateTime($_date);
				//$_date = $_date1->format('d.m.Y H:i');
				//$logo_news = htmlspecialchars_decode($logo_news);
				//$mini_news = htmlspecialchars_decode($mini_news);
				//$mini_news = htmlspecialchars_decode($mini_news);
				//$all_albom .= "<a href=\"/test.php?view=watch_albom&albom=".$id_alb."\">".$name_albom."</a><br/>";
				
				if($rool['write']==1)$del = "_<a href=\"/?page=gallery&view=dell_albom&albom=".$id_alb."\">[Dell]</a>";
				else $del = "";				
				$all_albom .= "<div class=\"roll2\"><a href=\"/?page=gallery&view=watch_albom&albom=".$id_alb."\">
				<img src=\"".$logo_img."\" alt=\"der\" /><br>".$name_albom."</a>".$del."</div>";				
                }
			}
			if(!$rool['write'])$edit = "";
			else $edit = "<br><form method=\"post\" action=\"index.php?page=gallery&view=add_albom&category=".$category."\">
<input id=\"c1\" name=\"new_albom\" /><input type=\"submit\" value=\"Создать фотоальбом\"/>
</form><br/>";
		return $all_albom.".+/".$edit."<br/><a href=\"index.php?page=gallery\"><img src=\"img/strelko.png\"> вернуться к выбору категорий</a>";
		}
		
	public function insert_albom($rool,$host,$user,$pass,$dbname,$albom){
			$albom = htmlspecialchars(stripslashes((string)$albom));
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8"); 			
			$albom = preg_replace("([^0-9])", "", $albom);
			//pagination
			
			$num = 20;
			if(!empty($_GET['list']))$page = $_GET['list'];
			else $page = "";
			$result00 = mysql_query("SELECT COUNT(*) FROM `gallery_img` WHERE `id_alb` = $albom");
			$temp = mysql_fetch_array($result00);
			$posts = $temp[0];
			$total = (($posts - 1) / $num) + 1;
			$total =  intval($total);
			$page = intval($page);
			if(empty($page) or $page < 0) $page = 1;
			if($page > $total) $page = $total;
			$start = $page * $num - $num;		
					
			//$result = mysql_query("SELECT * FROM table ORDER BY id LIMIT $start, $num");
			$sql="SELECT * FROM `gallery_img`, `gallery_album` WHERE `gallery_img`.`id_alb` = $albom and `gallery_img`.`id_alb` = `gallery_album`.`id_alb` LIMIT $start, $num";
			
			$res=mysql_query($sql);
			$count = mysql_num_rows($res);
			$pictures="";
			$id_cat="1";
			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res)){
				//   id_alb 	id_cat 	name_albom 	position 	id_cat 	name 	mini_img 	id_img 	id_alb 	title 	mini_pic 	pic 	date 
				// id_img 	id_alb 	title 	mini_pic 	pic 	date 
				$id_alb      	= $row['id_alb'];
				$id_cat   		= $row['id_cat'];
				$id_img			= $row['id_img'];
				$name_albom   	= $row['name_albom'];
				//$position   	= $row['position'];
				//$name   		= $row['name'];
				$title			= $row['title'];
				$mini_pic   	= $row['mini_pic']; 
				$pic			= $row['pic'];
				$date			= $row['date'];
				$date1 = new DateTime($date);
				$date = $date1->format('d.m.Y');
				//$logo_news = htmlspecialchars_decode($logo_news);
				//$mini_news = htmlspecialchars_decode($mini_news);
				//$mini_news = htmlspecialchars_decode($mini_news);
				//$pictures .= $name." - ".$name_albom." ".$mini_pic." ".$pic." ".$date."<br/>";	
				if($rool['write']==1) $del = "<a href=\"index.php?page=gallery&view=del_img&img=".$id_img."\">[Dell]</a>";
				else $del = "";		
				$pictures .= "<div class=\"roll3\">
				<a rel=\"group\" href=\"".$pic." \">
				<img src=\"".$mini_pic."\" alt=\"der\" /><br>".$title."</a>".$del."</div>"; // <br>Добавлено:".$date."
				//rel="group" href="http://img-fotki.yandex.ru/get/9742/229953285.29/0_e4b17_242bb42e_XL.jpg" title="КТИ-1 и Авангард догнали КТИ-2"
				//			
                }				
			}
			if(!$rool['write'])$edit = "";
			else $edit = "<a href=\"index.php?page=gallery&view=add_img&albom=".$albom."\">Добавить фотографии</a> ___ ";
			$pictures = "<hr/><H3>".$name_albom."</H3><hr/>".$pictures;
			
			//pagination list index.php?page=gallery&view=watch_albom&albom=14
			// Проверяем нужны ли стрелки назад
			if ($page != 1) $pervpage = '<a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list=1>Первая</a> | <a href=<a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page - 1) .'>Предыдущая</a> | ';
			else $pervpage = "";
			// Проверяем нужны ли стрелки вперед
			if ($page != $total) $nextpage = ' | <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page + 1) .'>Следующая</a> | <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list=' .$total. '>Последняя</a>';
			else $nextpage = "";
			
			// Находим две ближайшие станицы с обоих краев, если они есть
			if($page - 5 > 0) $page5left = ' <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page - 5) .'>'. ($page - 5) .'</a> | ';
			else $page5left = "";
			if($page - 4 > 0) $page4left = ' <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page - 4) .'>'. ($page - 4) .'</a> | ';
			else $page4left = "";
			if($page - 3 > 0) $page3left = ' <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page - 3) .'>'. ($page - 3) .'</a> | ';
			else $page3left = "";
			if($page - 2 > 0) $page2left = ' <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
			else $page2left = "";
			if($page - 1 > 0) $page1left = ' <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page - 1) .'>'. ($page - 1) .'</a> | ';
			else $page1left = "";
			
			if($page + 5 <= $total) $page5right = ' | <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page + 5) .'>'. ($page + 5) .'</a>';
			else $page5right = "";
			if($page + 4 <= $total) $page4right = ' | <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page + 4) .'>'. ($page + 4) .'</a>';
			else $page4right = "";
			if($page + 3 <= $total) $page3right = ' | <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page + 3) .'>'. ($page + 3) .'</a>';
			else $page3right = "";
			if($page + 2 <= $total) $page2right = ' | <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page + 2) .'>'. ($page + 2) .'</a>';
			else $page2right = "";
			if($page + 1 <= $total) $page1right = ' | <a href=index.php?page=gallery&view=watch_albom&albom='.$albom.'&list='. ($page + 1) .'>'. ($page + 1) .'</a>';
			else $page1right = "";
			
			// Вывод меню если страниц больше одной
			
			if ($total > 1)
			{
			$list = $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
			}
			else {
				$list = "";
			}
			
			return $pictures.".+/".$edit."<br/><a href=\"index.php?page=gallery&view=alboms&category=".$id_cat."\"><img src=\"img/strelko.png\"> вернуться в фотоальбом=-</a>.+/".$list;
		}
		
		public function add_albom($rool,$host,$user,$pass,$dbname,$category){
			$category = preg_replace("([^0-9])", "", $category);
			if(!$rool['write'])$edit = "";
			else{
				if(!empty($_POST['new_albom'])){
				  $new_alb = $_POST['new_albom'];
				  $new_alb = htmlspecialchars(stripslashes((string)$new_alb));
				  $conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
				  $db = mysql_select_db($dbname, $conn);
				  $res = mysql_query("INSERT INTO `gallery_album`(`id_alb`, `id_cat`, `name_albom`) VALUES ('','$category','$new_alb')");
				  if($res == 1)$edit = "edited categoty".$category." - ok";
				  else $edit = "проблема при добавлении альбома!";
				  
				  $edit_albom = "<a href=\"index.php?page=gallery&view=alboms&category=".$category." \">B альбомы</a>";
				}
			}
			
		return $edit_albom.".+/".$edit;
		}
		
		public function add_img($rool,$host,$user,$pass,$dbname,$albom){
		//		 Полные тексты 	id_img 	id_alb 	title 	mini_pic 	pic 	date 	
			
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
			
			if(!$rool['write'])$edit = "";
			else {
					$edit = "";
					$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
					$db = mysql_select_db($dbname, $conn);
					mysql_query("SET NAMES utf8");						
					if(!empty($_GET['albom'])){
						if(!empty($_POST['new_1'])){
							$pic1 = $_POST['new_1']; 
							$mini_pic1 = miniature($pic1);
							$txt1 = $_POST['text_1'];
							$res1=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt1','$mini_pic1','$pic1', now() );");													
						}
						if(!empty($_POST['new_2'])){
							$pic2 = $_POST['new_2'];  
							$txt2 = $_POST['text_2'];
							$res2=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt2','$mini_pic2','$pic2', now() );");
						}
						if(!empty($_POST['new_3'])){
							$pic3 = $_POST['new_3'];  
							$txt3 = $_POST['text_3'];
							$res3=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt3','$mini_pic3','$pic3', now() );");
						}
						if(!empty($_POST['new_4'])){
							$pic4 = $_POST['new_4'];  
							$txt4 = $_POST['text_4'];
							$res4=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt4','$mini_pic4','$pic4', now() );");
						}
						if(!empty($_POST['new_5'])){
							$pic5 = $_POST['new_5'];  
							$txt5 = $_POST['text_5'];
							$res5=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt5','$mini_pic5','$pic5', now() );");
						}
						if(!empty($_POST['new_6'])){
							$pic6 = $_POST['new_6'];  
							$txt6 = $_POST['text_6'];
							$res6=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt6','$mini_pic6','$pic6', now() );");
						}
						if(!empty($_POST['new_7'])){
							$pic7 = $_POST['new_7'];  
							$txt7 = $_POST['text_7'];
							$res7=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt7','$mini_pic7','$pic7', now() );");						
						}
						if(!empty($_POST['new_8'])){
							$pic8 = $_POST['new_8'];  
							$txt8 = $_POST['text_8'];
							$res8=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt8','$mini_pic8','$pic8', now() );");
						}
						if(!empty($_POST['new_9'])){
							$pic9 = $_POST['new_9'];  
							$txt9 = $_POST['text_9'];
							$res9=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt9','$mini_pic9','$pic9', now() );");
						}
						if(!empty($_POST['new_10'])){
							$pic10 = $_POST['new_10'];  
							$txt10 = $_POST['text_10'];
							$res10=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt10','$mini_pic10','$pic10', now() );");
						}
						if(!empty($_POST['new_11'])){
							$pic11 = $_POST['new_11'];  
							$txt11 = $_POST['text_11'];
							$res11=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt11','$mini_pic11','$pic11', now() );");
						}
						if(!empty($_POST['new_12'])){
							$pic12 = $_POST['new_12'];  
							$txt12 = $_POST['text_12'];
							$res12=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt12','$mini_pic12','$pic12', now() );");
						}
						if(!empty($_POST['new_13'])){
							$pic13 = $_POST['new_13'];  
							$txt13 = $_POST['text_13'];
							$res13=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt13','$mini_pic13','$pic13', now() );");
						}
						if(!empty($_POST['new_14'])){
							$pic14 = $_POST['new_14'];  
							$txt14 = $_POST['text_14'];
							$res14=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt14','$mini_pic14','$pic14', now() );");
						}
						if(!empty($_POST['new_15'])){
							$pic15 = $_POST['new_15'];  
							$txt15 = $_POST['text_15'];
							$res15=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt15','$mini_pic15','$pic15', now() );");
						}
						if(!empty($_POST['new_16'])){
							$pic16 = $_POST['new_16'];  
							$txt16 = $_POST['text_16'];
							$res16=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt16','$mini_pic16','$pic16', now() );");
						}
						if(!empty($_POST['new_17'])){
							$pic17 = $_POST['new_17'];  
							$txt17 = $_POST['text_17'];
							$res17=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt17','$mini_pic17','$pic17', now() );");
						}
						if(!empty($_POST['new_18'])){
							$pic18 = $_POST['new_18'];  
							$txt18 = $_POST['text_18'];
							$res18=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt18','$mini_pic18','$pic18', now() );");
						}
						if(!empty($_POST['new_19'])){
							$pic19 = $_POST['new_19'];  
							$txt19 = $_POST['text_19'];
							$res19=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt19','$mini_pic19','$pic19', now() );");
						}
						if(!empty($_POST['new_20'])){
							$pic20 = $_POST['new_20'];  
							$txt20 = $_POST['text_20'];
							$res20=mysql_query("INSERT INTO `gallery_img`(`id_img`, `id_alb`, `title`, `mini_pic`, `pic`, `date`) VALUES ('','$albom','$txt20','$mini_pic20','$pic20', now() );");
						}
						if(!empty($_POST['logo_img'])){
							$logo = $_POST['logo_img'];
							$res = mysql_query("UPDATE `sportkam`.`gallery_album` SET `logo_img` = '$logo' WHERE `gallery_album`.`id_alb` = $albom;");
						}
						if(!empty($_POST['edit_title'])){
							$edi = $_POST['edit_title'];
							
							mysql_query("UPDATE `sportkam`.`gallery_album` SET `name_albom` = '$edi' WHERE `gallery_album`.`id_alb` = $albom;");
						}
						$edit = "<a href=\"index.php?page=gallery&view=watch_albom&albom=".$albom."\">назад в фотоальбом</a>";
					}
					$add_img = "<br><a>
					<form method=\"post\" action=\"index.php?page=gallery&view=add_img&albom=".$albom."\">
					Обложка<input name=\"logo_img\"  /><br><br>
					Изменить название<input name=\"edit_title\"  /><br><br>
					№_1 <input name=\"new_1\" /> Назвать:<input name=\"text_1\" /><br><br>
					№_2 <input name=\"new_2\" /> Назвать:<input name=\"text_2\" /><br><br>
					№_3 <input name=\"new_3\" /> Назвать:<input name=\"text_3\" /><br><br>
					№_4 <input name=\"new_4\" /> Назвать:<input name=\"text_4\" /><br><br>
					№_5 <input name=\"new_5\" /> Назвать:<input name=\"text_5\" /><br><br>
					№_6 <input name=\"new_6\" /> Назвать:<input name=\"text_6\" /><br><br>
					№_7 <input name=\"new_7\" /> Назвать:<input name=\"text_7\" /><br><br>
					№_8 <input name=\"new_8\" /> Назвать:<input name=\"text_8\" /><br><br>
					№_9 <input name=\"new_9\" /> Назвать:<input name=\"text_9\" /><br><br>
					№10 <input name=\"new_10\" /> Назвать:<input name=\"text_10\" /><br><br>
					№11 <input name=\"new_11\" /> Назвать:<input name=\"text_11\" /><br><br>
					№12 <input name=\"new_12\" /> Назвать:<input name=\"text_12\" /><br><br>
					№13 <input name=\"new_13\" /> Назвать:<input name=\"text_13\" /><br><br>
					№14 <input name=\"new_14\" /> Назвать:<input name=\"text_14\" /><br><br>
					№15 <input name=\"new_15\" /> Назвать:<input name=\"text_15\" /><br><br>
					№16 <input name=\"new_16\" /> Назвать:<input name=\"text_16\" /><br><br>
					№17 <input name=\"new_17\" /> Назвать:<input name=\"text_17\" /><br><br>
					№18 <input name=\"new_18\" /> Назвать:<input name=\"text_18\" /><br><br>
					№19 <input name=\"new_19\" /> Назвать:<input name=\"text_19\" /><br><br>
					№20 <input name=\"new_20\" /> Назвать:<input name=\"text_20\" /><br><br>
					<input type=\"submit\" value=\"Сотворить\"/></form></a>";
					
			}
			return $add_img.".+/".$edit;
		}
		
		public function del_albom($rool,$host,$user,$pass,$dbname,$albom){
			$edit = " - у вас нет прав на удаление!";
			if(!$rool['write'])$edit = "";
			else {
					$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
					$db = mysql_select_db($dbname, $conn);
					
			$sql1="SELECT * FROM `gallery_img`, `gallery_album` WHERE `gallery_img`.`id_alb` = $albom and `gallery_img`.`id_alb` = `gallery_album`.`id_alb`;";
			$res1=mysql_query($sql1);
			$count = mysql_num_rows($res1);
			for($i=1; $i<=$count; $i++){
				while($row = mysql_fetch_array($res1)){
				//   id_alb 	id_cat 	name_albom 	position 	id_cat 	name 	mini_img 	id_img 	id_alb 	title 	mini_pic 	pic 	date 
				// id_img 	id_alb 	title 	mini_pic 	pic 	date 
				$id_alb      	= $row['id_alb'];
				$id_cat   		= $row['id_cat'];
				$id_img			= $row['id_img'];
				$del = "";
				if($rool['write']==1){
					$res=mysql_query("DELETE FROM `sportkam`.`gallery_img` WHERE `gallery_img`.`id_img` = $id_img;");
					if($res == 1)$del.="del img from albom ".$id_img;
					else $del="not del img!";
				}
                }				
			}					
					if(!empty($albom)){
							$res=mysql_query("DELETE FROM `sportkam`.`gallery_album` WHERE `gallery_album`.`id_alb` = $albom;");
							if($res == 1) $edit	= " - <a>Dellete ok</a> ".$del;
						}
			}
			return $albom.".+/".$edit;
		}
		
		public function del_img($rool,$host,$user,$pass,$dbname,$id_img){
			$edit = " - у вас нет прав на удаление!";
			if(!$rool['write'])$edit = "";
			else {
					$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
					$db = mysql_select_db($dbname, $conn);
					if(!empty($id_img)){
							$res=mysql_query("DELETE FROM `sportkam`.`gallery_img` WHERE `gallery_img`.`id_img` = $id_img;");
							if($res == 1) $edit	= " - <a>Dellete ok</a>";
						}
			}
			
			return $id_img.".+/".$edit;
		}
		
		public function coll_albom($host,$user,$pass,$dbname,$id_cat){
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
			$db = mysql_select_db($dbname, $conn);
			$sql3="SELECT count(*)FROM `gallery_album` WHERE `id_cat` = '$id_cat'"; // SELECT * FROM `gallery_album` WHERE `id_cat` = 1
			$res3=mysql_query($sql3);
			$row3 = mysql_fetch_array($res3);
			$num  = $row3['count(*)'];
			$coll = $num;
			//if(strlen($num)>1) $num = substr($num, -1);		
			if($num == 1) $coll .= " фотоальбом";
			elseif($num <= 4 and $num > 1) $coll .= " фотоальбома";
			elseif($num >= 5 or $num == 0) $coll .= " фотоальбомов";
			return $coll;
		}
		
}
?>