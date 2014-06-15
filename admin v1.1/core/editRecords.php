<?php

$cf_table_name = $_GET['cf_table_name']; /*имя таблицы*/
$cf_base = $_GET['cf_base']; 	/*имя базы*/
$cf_login = $_GET['cf_login'];  	/*логин*/
$cf_pass = $_GET['cf_pass']; 	/*пароль*/
$cf_server = $_GET['cf_server'];	/*сервер*/
$cf_key_column = $_GET['cf_key_column'];	/*имя ключевого поля*/
$cf_key_value = $_GET['cf_key_value'];		/*значение ключевого поля*/
$cf_checked_columns = $_GET['cf_checked_columns']; /*выбранные поля*/

$cf_all_table_column ="";	/*всех колонок*/
$cf_all_table_column_array = array(); 	/*массив имён колонок*/
$cf_all_table_column_type_array = array();	/*массив типов колонок*/
$cf_all_table_column_count = 0;		/*количество элементов в массиве*/

/*-- Выводим имена колонок таблицы --*/
$cf_db = mysql_connect($cf_server, $cf_login, $cf_pass);

if(!$cf_db){exit;}

mysql_select_db($cf_base, $cf_db);
$cf_show_column = "SHOW COLUMNS FROM $cf_base.$cf_table_name";
$cf_result = mysql_query($cf_show_column);

if(!$cf_result){exit;}

if(mysql_num_rows($cf_result) > 0){
	while($cf_rows = mysql_fetch_assoc($cf_result)){
		if($cf_all_table_column == ""){
			$cf_all_table_column = $cf_rows[Field];
		}else{
			$cf_all_table_column = $cf_all_table_column.", ".$cf_rows[Field];
		}
		$cf_all_table_column_array[] = $cf_rows[Field];	/*имена полей*/
		$cf_all_table_column_type_array[] = $cf_rows[Type]; /*типы полей*/
	}
}
$cf_all_table_column_count = count($cf_all_table_column_array);
/*----------------------------------------------------------*/



/*-- Выводим содержимое таблицы --*/
$cf_db = mysql_connect($cf_server, $cf_login, $cf_pass);
if(!$cf_db){exit;}

mysql_select_db($cf_base, $cf_db);
$cf_sql_query = "SELECT $cf_all_table_column FROM $cf_base.$cf_table_name WHERE ($cf_key_column = $cf_key_value)";
$cf_result = mysql_query($cf_sql_query, $cf_db);
if(!$cf_result){exit;}

$cf_rows = mysql_fetch_array($cf_result);
do{
	for($cf_i = 0; $cf_i < $cf_all_table_column_count; $cf_i++){
		$cf_action_column = $cf_all_table_column_array[$cf_i];
		echo "&nbsp;(имя поля): $cf_action_column <br>";
		
		$cf_regular_find = preg_replace("/(text)/","text",$cf_all_table_column_type_array[$cf_i]);
		
		if($cf_regular_find == "text"){
			echo "&nbsp;<textarea rows='3' cols='20' class='FORM_RECORDS_TEXTAREA' id='cf_field' name='$cf_action_column'>$cf_rows[$cf_action_column]</textarea><br><br>";
		}else{
			echo "&nbsp;<input type='text' class='FORM_RECORDS_TEXT' id='cf_field' name='$cf_action_column' value='$cf_rows[$cf_action_column]'><br><br>";
		}
	}

} while($cf_rows = mysql_fetch_array($cf_result));

/*Кнопки сохранение и отмена*/
echo "&nbsp;<input type='submit' value='Сохранить.' id='button_save_edit_form'>&nbsp;<input type='submit' value='Отмена.' id='button_cancel_edit_form'><br><br>";

/*-- Очистка ---------------------------------------*/
mysql_free_result($cf_result);
unset($cf_table_name);
unset($cf_base);
unset($cf_login);
unset($cf_pass);
unset($cf_server);
unset($cf_key_column);
unset($cf_key_value);
unset($cf_checked_columns);
unset($cf_all_table_column);
unset($cf_all_table_column_array);
unset($cf_all_table_column_type_array);
unset($cf_all_table_column_count);

unset($cf_db);
unset($cf_show_column);
unset($cf_sql_query);
unset($cf_result);

/*----------------------------------------------------------*/

?>
