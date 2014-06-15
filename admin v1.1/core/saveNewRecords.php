<?php

$cf_table_name = $_GET['cf_table_name']; /*имя таблицы*/
$cf_base = $_GET['cf_base']; 	/*имя базы*/
$cf_login = $_GET['cf_login'];  	/*логин*/
$cf_pass = $_GET['cf_pass']; 	/*пароль*/
$cf_server = $_GET['cf_server'];	/*сервер*/
$cf_save_value_array = $_GET['cf_save_value'];	/*массив данных для сохранения в базу*/
$cf_all_table_column = ""; 		/*имёна колонок*/
$cf_all_table_column_count = 0;		/*количество элементов в массиве*/
$cf_set_value = "";			/*поля = значения для запроса обновления*/

/*-- Выводим имена колонок таблицы --*/
$cf_db = mysql_connect($cf_server, $cf_login, $cf_pass);
if(!$cf_db){exit;}
mysql_select_db($cf_base, $cf_db);
$cf_show_column = "SHOW COLUMNS FROM ".$cf_table_name;
$cf_result = mysql_query($cf_show_column);
if(!$cf_result){exit;}
if(mysql_num_rows($cf_result) > 0){
	while($cf_rows = mysql_fetch_assoc($cf_result)){
		if($cf_all_table_column == ""){
			$cf_all_table_column = $cf_rows[Field];	/*имена колонок*/
		}else{
			$cf_all_table_column = $cf_all_table_column.", ".$cf_rows[Field];	/*имена колонок*/
		}
	}
}

$cf_all_table_column_count = count($cf_save_value_array);
/*----------------------------------------------------------*/

for($cf_i=0; $cf_i < $cf_all_table_column_count; $cf_i++){
	if($cf_set_value == ""){
		$cf_set_value = "'".$cf_save_value_array[$cf_i]."'";
	}else{
		$cf_set_value = $cf_set_value.", '".$cf_save_value_array[$cf_i]."'";
	}
}

/*-- Сохраняем в базу данных НОВЫЕ ДАННЫЕ --*/
mysql_select_db($cf_base, $cf_db);
$cf_sql_query = "INSERT INTO $cf_base.$cf_table_name  ($cf_all_table_column) VALUE ($cf_set_value)";
$cf_result = mysql_query($cf_sql_query);
if(!$cf_result){
	echo "ОШИБКА: Произошла ошибка сохранения!!!";
	exit;
}else{
	echo "Сохранение прошло успешно!<br>";
	echo "<br><input type='submit' value='Обновить.' id='button_update_table_records'><br>";
}
/*----------------------------------------------------------------------------*/
unset($cf_table_name);
unset($cf_base);
unset($cf_login);
unset($cf_pass);
unset($cf_server);
unset($cf_save_value_array);
unset($cf_all_table_column);
unset($cf_all_table_column_count);
unset($cf_set_value);

unset($cf_db);
unset($cf_show_column);
unset($cf_sql_query);
unset($cf_result);
?>
