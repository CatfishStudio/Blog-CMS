<?php

/*Подключаем таблицу стилей*/
echo "<style type='text/css'>";
	echo "@import url('plugins/standard_menu/menu.css');";
echo "</style>";
/*-----------------------------------------------*/
/*---Описание меню -----------------*/
echo "<ul id='menu'>";
	echo "<li><a href='#'>Управление таблицей</a>";
		echo "<ul>";
			echo "<li id='create_record'><a href='#'>Создать запись</a></li>";
			echo "<li id='delete_record'><a href='#'>Удалить запись</a></li>";
			echo "<li id='edit_record'><a href='#'>Редактировать запись</a></li>";
			
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='#'>Действия</a>";
		echo "<ul>";
			echo "<li id='show_table_content'><a href='#'>Показать содержимое</a></li>";
			echo "<li id='clear_form'><a href='#'>Очистить форму</a></li>";
			echo "<li id='save_record'><a href='#'>Сохранить запись</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";

?>
