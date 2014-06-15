<?php
$cf_table_name = $_GET['cf_table_name'];
$cf_base = $_GET['cf_base'];
$cf_login = $_GET['cf_login'];
$cf_pass = $_GET['cf_pass'];
$cf_server = $_GET['cf_server'];

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

for($cf_i = 0; $cf_i < $cf_all_table_column_count; $cf_i++){
	$cf_action_column = $cf_all_table_column_array[$cf_i];
	echo "&nbsp;(имя поля): $cf_action_column <br>";
		
	$cf_regular_find = preg_replace("/(text)/","text",$cf_all_table_column_type_array[$cf_i]);
		
	if($cf_regular_find == "text"){
		echo "&nbsp;<textarea rows='3' cols='20' class='FORM_RECORDS_TEXTAREA' id='cf_field' name='$cf_action_column'></textarea><br><br>";
	}else{
		echo "&nbsp;<input type='text' class='FORM_RECORDS_TEXT' id='cf_field' name='$cf_action_column' value=''><br><br>";
	}
}

/*Кнопки сохранения и отмены*/
echo "&nbsp;<input type='submit' value='Сохранить.' id='button_save_new_form'>&nbsp;<input type='submit' value='Отмена.' id='button_cancel_new_form'><br>";

/*-- Очистка ------------------------------------------*/
mysql_free_result($cf_result);
unset($cf_table_name);
unset($cf_base);
unset($cf_login);
unset($cf_pass);
unset($cf_server);

unset($cf_all_table_column);
unset($cf_all_table_column_array);
unset($cf_all_table_column_type_array);
unset($cf_all_table_column_count);

unset($cf_db);
unset($cf_show_column);
unset($cf_result);
/*----------------------------------------------------------*/

?>
