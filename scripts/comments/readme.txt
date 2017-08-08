/*
 *
 *    Скрипт комментариев.
 *    Версия: 1.0 (beta)
 *    Дата: 10.02.2012
 *    Автор: Чернышов Роман
 *    Сайт: http://rche.ru
 *    Эл.почта: houseprog@ya.ru
 *
 */


Установка:

1. Создайте таблицы в БД, импортировав в неё install.sql
2. Настройте подключение к БД в файле config.php
3. Вставте на страницу где требуется выводить комментарии след. код:


	<?php
	// в самом начале php скрипта
	include("config.php");
	?>

	<?php
	// где требуется выводить комментарии
	$comments->outComments();
	?>


Для администрирования коммантариев добавте в URL адрес, переменную pass=12345 (пароль задается в config.php)
Примеры: 
	http://example.com/comments.php?pass=12345
	http://example.com/components/articles/?pass=12345
	http://example.com/?pass=12345