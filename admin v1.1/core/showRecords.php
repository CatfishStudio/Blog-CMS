<?php

$cf_table_name = $_GET['cf_table_name'];
$cf_base = $_GET['cf_base'];
$cf_login = $_GET['cf_login'];
$cf_pass = $_GET['cf_pass'];
$cf_server = $_GET['cf_server'];
$cf_checked_columns = $_GET['cf_checked_columns'];
$cf_key_column = $_GET['cf_key_column'];
$cf_column = "";

$cf_count = count($cf_checked_columns);
for($cf_i = 0; $cf_i < $cf_count; $cf_i++){
	if($cf_column == ""){
		$cf_column = $cf_checked_columns[$cf_i];
	}else{
		$cf_column = $cf_column.", ".$cf_checked_columns[$cf_i];
	}
}

/*-- Выводим имена колонок таблицы --*/

$cf_db = mysql_connect($cf_server, $cf_login, $cf_pass);
if(!$cf_db){
	echo "Ошибка соединения с базой!!!";
	exit;
}

mysql_select_db($cf_base, $cf_db);

$cf_sql_query = "SELECT $cf_column FROM $cf_base.$cf_table_name";
$cf_result = mysql_query($cf_sql_query, $cf_db);
if(!$cf_result){
	exit;
}

/*-- содержимое ключевого поля --*/
$cf_rows = mysql_fetch_array($cf_result);
echo "$cf_key_column (Ключевое поле) &nbsp;<select id='window_show_select'><option></option>";
do{
	echo "<option>$cf_rows[$cf_key_column]</option>";
} while($cf_rows = mysql_fetch_array($cf_result));
echo "</select>&nbsp;<input type='submit' value='Редактировать.' id='button_edit_form'>&nbsp;<input type='submit' value='Удалить.' id='button_delete_form'><br>";
/*-----------------------------------------------------*/

/*-- Шапка таблицы --*/
echo "<tr class='SHOW_RECORD_HEADER'>";
	for($cf_i = 0; $cf_i < $cf_count; $cf_i++){
		echo "<th>$cf_checked_columns[$cf_i]</th>";
	}
echo "</tr>";
/*-- Выводим содержимое таблицы --*/
$cf_result = mysql_query($cf_sql_query, $cf_db);
$cf_rows = mysql_fetch_array($cf_result);
do{
	echo "<tr class='SHOW_RECORD_LINES'>";
	for($cf_i = 0; $cf_i < $cf_count; $cf_i++){
		$cf_name_column = $cf_checked_columns[$cf_i];
		echo "<th>$cf_rows[$cf_name_column]</th>";
	}
	echo "</tr>";
} while($cf_rows = mysql_fetch_array($cf_result));
/*-----------------------------------------------------*/

/*-- Очистка ---------------------------------------*/
mysql_free_result($cf_result);
unset($cf_table_name);
unset($cf_base);
unset($cf_login);
unset($cf_pass);
unset($cf_server);
unset($cf_checked_columns);
unset($cf_key_column);
unset($cf_column);

unset($cf_result);
unset($cf_db);
unset($cf_sql_query);

/*----------------------------------------------------------*/

?>
