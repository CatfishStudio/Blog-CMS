<?php
$cf_table_name = $_GET['cf_table_name']; /*имя таблицы*/
$cf_base = $_GET['cf_base']; 	/*имя базы*/
$cf_login = $_GET['cf_login'];  	/*логин*/
$cf_pass = $_GET['cf_pass']; 	/*пароль*/
$cf_server = $_GET['cf_server'];	/*сервер*/
$cf_key_column = $_GET['cf_key_column'];	/*имя ключевого поля*/
$cf_key_value = $_GET['cf_key_value'];		/*значение ключевого поля*/

$cf_db = mysql_connect($cf_server, $cf_login, $cf_pass);
if(!$cf_db){exit;}
mysql_select_db($cf_base, $cf_db);
$cf_sql_query = "DELETE FROM $cf_table_name WHERE ($cf_key_column = '$cf_key_value')";

$cf_result = mysql_query($cf_sql_query, $cf_db);

if(!$cf_result){
	echo "ОШИБКА: Произошла ошибка во время удаления!!!";
	exit;
}else{
	echo "Удаление прошло успешно!<br>";
	echo "<br><input type='submit' value='Обновить.' id='button_update_table_records'><br>";
}

/*---------------------------------------------------------*/
unset($cf_table_name);
unset($cf_base);
unset($cf_login);
unset($cf_pass);
unset($cf_server);
unset($cf_key_column);
unset($cf_key_value);

unset($cf_db);
unset($cf_sql_query);
unset($cf_result);

?>
