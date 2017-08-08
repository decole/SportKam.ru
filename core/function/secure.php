<?php

	class iscin{
		
		public function log_sql($login,$do,$page,$query){
			include("core/config.php");
			if($iscin = "on"){				
				$query = stripslashes($query);
				$query = htmlspecialchars($query);
				$conn = mysql_connect($host,$user,$pass,$dbname)  or die (mysql_error());
				$db = mysql_select_db($dbname, $conn);
				$query_i = "INSERT INTO `logger` (`id`, `ip`, `page`, `do`, `query`, `login`) 
				VALUES ('', 'ip', '$page', '$do', '$query', '$login');";
				$res=mysql_query($query_i);
			}
		}
	}
	
	class law{
		public function rool($group){
			if(!isset($group)) die("You not invite another group!");
			elseif($group == 3) $rool="7"; // админ, главред
  			elseif($group == 2) $rool="6"; // модератор
  			elseif($group == 1) $rool="4"; // пользователь
			elseif($group == 0) $rool="0"; // заблокированный
			
			// Права по умолчанию
			$priv["read"]	=0;
			$priv["write"]	=0;
			$priv["del"]	=0;	
			$priv["block"]	=0;	
			
			$priv_read 	= array(4,5,6,7); // Значения которые разрешают просмотр
			$priv_write = array(2,3,6,7); // Значения которые разрешают редактирование
			$priv_del 	= array(1,3,5,7); // Значения которые разрешают удаление
	 		$priv_block = array(0);
				      
			// Проверяем права на просмотр, редактирование, удаление
			//и если результат положительный, записываем в массив
			if(in_array($rool, $priv_read))$priv["read"]=1;
			if(in_array($rool, $priv_write))$priv["write"]=1;
			if(in_array($rool, $priv_del))$priv["del"]=1;
			if(in_array($rool, $priv_block))$priv["block"]=1;

 			return $priv; // Возвращаем массив с правами доступа
		}
		
		public function only_num($string){
			$string = preg_replace("([^0-9])", "", $string);
			return $string;
		}
		
		public function not_hack($string){
			$string = preg_replace("([^0-9])", "", $string);
			// del <script> and sql injection
			return $string;
		}
	}
?>
