<?php
//setcookie("TestCookie", $value, time()+3600);  // срок действия 1 час //
class autorisation{
	
	public function who_user($host,$user,$pass,$dbname){
		$user1 = 'Гость/1/1/0'; // переработать на новое интерпретирование прав пользователей		
		
		if(isset($_COOKIE['login']) & isset($_COOKIE['password'])){
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error()); // соединение с сервером БД с данными
			$db = mysql_select_db($dbname, $conn);
			mysql_query("SET NAMES utf8"); 
			$sql="SELECT * FROM users WHERE login='".$_COOKIE['login']."' and password='".$_COOKIE['password']."'";
			$res=mysql_query($sql);
				if(mysql_num_rows($res) == 1){
				while($row = mysql_fetch_array($res)){
					$id      = $row['id']; 
					$login   = $row['login'];
					$pass    = $row['password'];
					$name    = $row['firstname'];
					$surname = $row['surname'];
					$confirm = $row['is_confirmed'];
					$group	 = $row['group'];
				
					
				}
				$user = $login."/".$group."/".$confirm."/".$id;
				
				setcookie("login",$login,time()+86400);
				setcookie("password",$pass,time()+86400);
				return $user;
				}	
				else {
				setcookie('login', '', 0, "/");
				setcookie('password', '', 0, "/");
				//setcookie("group", '',0, "/");
				header('Location: .'); 
				return $user1;
				}
		}
		else return $user1;						
	}
	
	public function logout(){
		setcookie('login', '', 0, "/");
		setcookie('password', '', 0, "/");
		header('Location: .'); // перезагружаем файл
		$user1 = 'Гость';
		return $user1;		
	}
	
	public function registration($host,$user,$pass,$dbname){
			if(isset($_POST['submit'])) {
			if(empty($_POST['login']))  {
			$text = '<br><font color="red"> Введите логин!</font>';
			return $text;
			} 
				if (!preg_match("/^\w{3,}$/", $_POST['login'])) {
			$text = '<br><font color="red">В поле "Логин" введены недопустимые символы! Только буквы, цифры и подчеркивание!</font>';
			return $text;
			}
			elseif(empty($_POST['name'])) {
			$text = '<br><font color="red">Введите имя!</font>';
			return $text;
			}
			elseif(empty($_POST['surname'])) {
			$text = '<br><font color="red">Введите отчество!</font>';
			return $text;
			}
			elseif(empty($_POST['lastname'])) {
			$text = '<br><font color="red">Введите фамилию!</font>';
			return $text;
			}
			elseif(empty($_POST['pass1'])) {
			$text = '<br><font color="red">Введите пароль!</font>';
			return $text;
			}
			elseif (!preg_match("/\A(\w){6,20}\Z/", $_POST['pass1'])) {
			$text = '<br><font color="red">Пароль слишком короткий! Пароль должен быть не менее 6 символов! </font>';
			return $text;
			}
			elseif(empty($_POST['pass2'])) {
			$text = '<br><font color="red">Введите подтверждение пароля!</font>';
			return $text;
			}
			elseif($_POST['pass1'] != $_POST['pass2']) {
			$text = '<br><font color="red">Введенные пароли не совпадают!</font>';
			return $text;
			}
			elseif(empty($_POST['email'])) {
			$text = '<br><font color="red">Введите E-mail! </font>';
			return $text;
			}
			elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $_POST['email'])) {
			$text = '<br><font color="red">E-mail имеет недопустимий формат! Например, name@gmail.com! </font>';
			return $text;
			}
			else{
			$login = $_POST['login'];
			$password = $_POST['pass1'];
			$mdPassword = md5($password);
			$password2 = $_POST['pass2'];
			$email = $_POST['email'];
			$rdate = date("d-m-Y в H:i");
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$lastname = $_POST['lastname']; 
			$conn = mysql_connect($host,$user,$pass)  or die (mysql_error()); 
			$db = mysql_select_db($dbname, $conn);
			
			$query = ("SELECT id FROM users WHERE login='$login'");
			$sql = mysql_query($query) or die(mysql_error());
			
			if (mysql_num_rows($sql) > 0) {
			$text = '<font color="red">Пользователь с таким логином зарегистрирован!</font>';
			return $text;
			}
			else {
				$query2 = ("SELECT id FROM users WHERE email='$email'");
				$sql = mysql_query($query2) or die(mysql_error());
				if (mysql_num_rows($sql) > 0){
				$text = '<font color="red">Пользователь с таким e-mail уже зарегистрирован!</font>';
				return $text;
				}
				else{
					$supersecret_hash_padding = 'О сколько нам открытий чудных...';
					$hash = md5($email.$supersecret_hash_padding);
					
				mysql_query("SET NAMES utf8");
				$query = "INSERT INTO users (login, password, email, reg_date, firstname, surname, lastname, confirm_hash, is_confirmed, group )
				VALUES ('$login', '$mdPassword', '$email', '$rdate', '$name', '$surname', '$lastname', '$hash', 0, '5')";
				$result = mysql_query($query) or die(mysql_error());
				//iscin start
				//echo $query; // !!!!!!!!!!!!!!!!!!!!
				//$iscin = new iscin;
				//$page = $do = "registation";
				//$iscin->log_sql($login,$do,$page,$query);
				
				$encoded_email = urlencode($email);
			  $mail_body = "Спасибо за регистрацию на SPORTKAM.ORG. Щелкните по этой ссылке для подтверждения регистрации:
			  
				http:/localhost/index.php?page=confirm&hash=$hash&email=$encoded_email
				
				Как только вы увидите подтверждающее сообщение, вы будете зарегистрированы на KAMSPORT.ORG";
			  mail ($email, 'Подтверждение регистрации на kamsport.org', $mail_body, 'From: iscin@kamsport.org');
			  
				$text = '<font color="green">Вы успешно зарегистрировались!</font><br><a href="index.php?page=home">На главную</a>';
				return $text;
				}
			}
			}				
		}
		
	}
	
	public function autoriz($host,$user,$pass,$dbname){
		if(isset($_POST['submit'])) {
			if (!$_POST['login'] || !$_POST['pass1']) {
				$feedback = 'ОШИБКА - Отсутствует имя пользователя или пароль';
				return $feedback;
			  } else {
				$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
				$db = mysql_select_db($dbname, $conn);
				mysql_query("SET NAMES utf8"); // ****
				
				$login = strtolower($_POST['login']);
				$password = $_POST['pass1'];
			
				$crypt_pwd = md5($password);
				$query = "SELECT  login FROM users WHERE login = '$login' AND password = '$crypt_pwd'";
				$result = mysql_query($query);
				//iscin
				//$iscin = new iscin;
				//$iscin->log_sql($query);
				//				
				if (!$result || mysql_num_rows($result) < 1){
				  $feedback = 'ОШИБКА - Пользователь не найден или пароль неверный';
				  return $feedback;
				} else {
				  if (mysql_num_rows($result) == '1') {
					   setcookie("login",$login,time()+86400);
					   setcookie("password",$crypt_pwd,time()+86400);
					   $feedback = "Вход произведен";
					   return $feedback;
					   
				   
				  }
				}
			  }
		}
	}
	
	function user_confirm($host,$user,$pass,$dbname) {
	  // Эта функция будет работать только с суперглобальными массивами
	  $supersecret_hash_padding = 'О сколько нам открытий чудных...';	  
	     if(isset($_GET['email']) and isset($_GET['hash']))	{		  		  
		  // Проверка на соответствие указанного адреса при регистрации и подтверждение этого адреса
		  $new_hash = md5($_GET['email'].$supersecret_hash_padding);
		  if ($new_hash && ($new_hash == $_GET['hash'])) {
			  $conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
					$db = mysql_select_db($dbname, $conn);
					mysql_query("SET NAMES utf8"); // ****
					
			$query = "SELECT login
					  FROM users
					  WHERE confirm_hash = '$new_hash'";
			$result = mysql_query($query);
			if (!$result || mysql_num_rows($result) < 1) {
			  $feedback = 'ОШИБКА - Hash не найден';
			  return $feedback;
			} else {
			  // Подтверждение регистрации через email указанный пользователем при регистрации
			  // Обновление поля is_confirmed, т.е. зарегистрирован и проверен.
			  $email = $_GET['email'];
			  $hash = $_GET['hash'];
			  $query = "UPDATE users SET email='$email', is_confirmed=1 WHERE confirm_hash='$hash'";
			  $result = mysql_query($query);
			  $feedback = "Вы успешно подтвердили регистрацию!";
			  return $feedback;
			}
		  } else {
			$feedback = 'ОШИБКА - Значения не совпадают';
			return $feedback;
		  }
	   }
	if(isset($_POST['submit']) and isset($_POST['email'])){
		$email = $_POST['email'];
		$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
		$db = mysql_select_db($dbname, $conn);
		$query = "SELECT email FROM users WHERE email = '$email'";
		$result = mysql_query($query);
		if (!$result || mysql_num_rows($result) < 1) {
			$feedback = 'почтовый ящик - '.$email.' несуществует в нашей базе <br><a href="index.php?page=confirm">Попробовать еще</a> /';
			return $feedback;
		}		
		else{			
		$encoded_email = urlencode($email);
		$supersecret_hash_padding = 'О сколько нам открытий чудных...';
		$hash = md5($email.$supersecret_hash_padding);		
		$mail_body = "Спасибо за регистрацию на SPORTKAM.ORG. Щелкните по этой ссылке для подтверждения регистрации:
		
		  http:/localhost/index.php?page=confirm&hash=$hash&email=$encoded_email
		  
		  Как только вы увидите подтверждающее сообщение, вы будете зарегистрированы на KAMSPORT.ORG";
		mail ($email, 'Подтверждение регистрации на kamsport.org', $mail_body, 'From: iscin@kamsport.org');
		
		$text = '<font color="green">Письмо выслано на указанный вами адресс!</font>';
		return $text;	
			}			
	}
	}
	
	public function confirm_user($host,$user,$pass,$dbname,$login){
		$conn = mysql_connect($host,$user,$pass)  or die (mysql_error());
		$db = mysql_select_db($dbname, $conn);
		$query = "SELECT login FROM users WHERE login = '$login' and is_confirmed = '1'";
		$result = mysql_query($query);
		if (!$result || mysql_num_rows($result) < 1) {
			$text = "false";
			return $text;
		}	
		$text = "true";
		return $text;	
	}
}


?>