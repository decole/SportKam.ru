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

defined('_RCHE') or die('Restricted access');

abstract class Controller_Base {

        protected $registry;

        final function __construct($registry) {
                $this->registry = $registry;
        }

	function getDate ($arg='d m Y H i') {
	$line=explode(' ',$arg);
	$date=array();
	foreach($line as $l):
		$date[$l]=date($l);
	endforeach;
	return $date;
	}
        abstract function index();
}
?>