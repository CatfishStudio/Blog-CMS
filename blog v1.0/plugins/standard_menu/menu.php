<?php

/*Подключаем таблицу стилей*/
echo "<style type='text/css'>";
	echo "@import url('plugins/standard_menu/menu.css');";
echo "</style>";
/*-----------------------------------------------*/
/*---Описание меню -----------------*/
echo "<ul id='menu'>";
	echo "<li><a href='#'>Пункт 1</a></li>";
	echo "<li><a href='#'>Пункт 2</a>";
		echo "<ul>";
			echo "<li><a href='#'>Подпункт 1</a></li>";
			echo "<li><a href='#'>Подпункт 2</a></li>";
			echo "<li><a href='#'>Подпункт 3</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='#'>Пункт 3</a>";
		echo "<ul>";
			echo "<li><a href='#'>Подпункт 1</a></li>";
			echo "<li><a href='#'>Подпункт 2</a></li>";
			echo "<li><a href='#'>Подпункт 3</a></li>";
			echo "<li><a href='#'>Подпункт 4</a></li>";
			echo "<li><a href='#'>Подпункт 5</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='#'>Пункт 4</a>";
		echo "<ul>";
			echo "<li><a href='#'>Подпункт 1</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='#'>Пункт 5</a>";
		echo "<ul>";
			echo "<li><a href='#'>Подпункт 1</a></li>";
			echo "<li><a href='#'>Подпункт 2</a></li>";
			echo "<li><a href='#'>Подпункт 3</a></li>";
			echo "<li><a href='#'>Подпункт 4</a></li>";
			echo "<li><a href='#'>Подпункт 5</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";

?>