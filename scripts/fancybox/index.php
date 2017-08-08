<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Возможности FancyBox</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<!-- Подключаем Fancybox -->
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<link rel="stylesheet" href="style.css" />
<script type="text/javascript">
$(document).ready(function() {
    $(".example1").fancybox();
    
    $(".example2").fancybox({
        'overlayShow'	: false,
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'elastic'
    });
    
    $(".example3").fancybox({
        'transitionIn'	: 'none',
        'transitionOut'	: 'none'	
    });
    
    $(".example4").fancybox({
        'opacity'		: true,
        'overlayShow'	: false,
        'transitionIn'	: 'elastic',
        'transitionOut'	: 'none'
    });

    $(".example5").fancybox();
    $(".example6").fancybox({
        'titlePosition'		: 'outside',
        'overlayColor'		: '#000',
        'overlayOpacity'	: 0.9
    });

    $(".example7").fancybox({
        'titlePosition'	: 'inside'
    });

    $(".example8").fancybox({
        'titlePosition'	: 'over'
    });
    
    $("a[rel=group], a[rel=gr_2]").fancybox({
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'titlePosition' 	: 'over',
        'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
        }
    });
    
    $("#various1").fancybox({
        'titlePosition'		: 'inside',
        'transitionIn'		: 'none',
        'transitionOut'		: 'none'
    });
    
    $("#various2").fancybox();
    
    $("#various3").fancybox({
        'width'				: '75%',
        'height'			: '75%',
        'autoScale'			: false,
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'type'				: 'iframe'
    });
    
    $("#various4").fancybox({
        'padding'			: 0,
        'autoScale'			: false,
        'transitionIn'		: 'none',
        'transitionOut'		: 'none'
    });
});
</script>
<!-- //Подключаем Fancybox -->
</head>
<body>
    <h1>Одиночная картинка</h1>
    <div>
        <h2>Различные варианты Появления/Исчезания</h2>
        <a class="example1" href="images/i_g_1_full.jpg"><img src="images/i_g_1.jpg" height="100" /></a>
        <a class="example2" href="images/i_g_2_full.jpg"><img src="images/i_g_2.jpg" height="100" /></a>
        <a class="example3" href="images/i_g_3_full.jpg"><img src="images/i_g_3.jpg" height="100" /></a>
        <a class="example4" href="images/i_g_4_full.jpg"><img src="images/i_g_4.jpg" height="100" /></a>
    </div>
    <br />
    <div>
        <h2>Различное положение Названия картинки</h2>
        <a class="example5" href="images/i_g_1_full.jpg" title="Картинка (Default)"><img src="images/i_g_1.jpg" height="100" /></a>
        <a class="example6" href="images/i_g_2_full.jpg" title="Картинка (titlePosition: outside)"><img src="images/i_g_2.jpg" height="100" /></a>
        <a class="example7" href="images/i_g_3_full.jpg" title="Картинка (titlePosition: inside)"><img src="images/i_g_3.jpg" height="100" /></a>
        <a class="example8" href="images/i_g_4_full.jpg" title="Картинка (titlePosition: over)"><img src="images/i_g_4.jpg" height="100" /></a>
    </div>
    <hr />
    <h1>Группа картинок (Галерея)</h1>
    <div>
        <h2>Вариант 1. Показаны все картинки. (покрутите колесико мыши)</h2>
        <a rel="group" href="images/i_g_1_full.jpg" title="Lorem ipsum dolor sit amet"><img src="images/i_g_1.jpg" height="100" /></a>
        <a rel="group" href="images/i_g_2_full.jpg"><img src="images/i_g_2.jpg" height="100" /></a>
        <a rel="group" href="images/i_g_3_full.jpg"><img src="images/i_g_3.jpg" height="100" /></a>
        <a rel="group" href="images/i_g_4_full.jpg"><img src="images/i_g_4.jpg" height="100" /></a>
    </div>
    <br />
    <div>
        <h2>Вариант 2. Показана только одна картинка.</h2>
        <a rel="gr_2" href="images/i_g_1_full.jpg"><img src="images/i_g_1.jpg" height="100" /></a>
        <div style="display: none;">
            <a rel="gr_2" href="images/i_g_2_full.jpg"><img src="images/i_g_2.jpg" height="100" /></a>
            <a rel="gr_2" href="images/i_g_3_full.jpg"><img src="images/i_g_3.jpg" height="100" /></a>
            <a rel="gr_2" href="images/i_g_4_full.jpg"><img src="images/i_g_4.jpg" height="100" /></a>
        </div>
    </div>
    <hr />
    <h1>Другие возможности</h1>
    <div class="various">
		<a id="various1" href="#inline1" title="Lorem ipsum dolor sit amet">Вывод контента</a>
		<a id="various2" href="ajax.php">Результат запроса Ajax</a>
		<a id="various3" href="http://pishemsite.ru">Открываем сайт во Фрейме</a>
		<a id="various4" href="http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf">Флеш-Анимашка</a>
	</div>
	<div style="display: none;">
		<div id="inline1" style="width:400px;height:100px;overflow:auto;">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis mi eu elit tempor facilisis id et neque. Nulla sit amet sem sapien. Vestibulum imperdiet porta ante ac ornare. Nulla et lorem eu nibh adipiscing ultricies nec at lacus. Cras laoreet ultricies sem, at blandit mi eleifend aliquam. Nunc enim ipsum, vehicula non pretium varius, cursus ac tortor. Vivamus fringilla congue laoreet. Quisque ultrices sodales orci, quis rhoncus justo auctor in. Phasellus dui eros, bibendum eu feugiat ornare, faucibus eu mi. Nunc aliquet tempus sem, id aliquam diam varius ac. Maecenas nisl nunc, molestie vitae eleifend vel, iaculis sed magna. Aenean tempus lacus vitae orci posuere porttitor eget non felis. Donec lectus elit, aliquam nec eleifend sit amet, vestibulum sed nunc.
		</div>
	</div>
</body>
</html>