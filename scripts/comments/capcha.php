<?php
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

error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once('class.captcha.php');
session_start();
//session_name('captcha');
$captcha = new Image(); 
$captcha->AddHendler( 'imagetype', array( 'jpeg', 100 ) );
$captcha->addImage( '120', '50' );
$captcha->addText( 1, rand( 17, 18 ) );
//$captcha->addBorder();
$captcha->AddFilter( 'smooth', 20  );
//$captcha->AddFilter( 'meanremoval' );
//$captcha->AddFilter( 'edgedetect'  );
//$captcha->AddFilter( 'brightness', rand( 0, 100 ) );
//$captcha->AddNoise( '200' );
$captcha->draw();
$_SESSION['captha_text'] = $captcha->getCaptchaText();
?>