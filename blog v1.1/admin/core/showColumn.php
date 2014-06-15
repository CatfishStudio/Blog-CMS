<?php

$cf_table_name = $_GET['cf_table_name'];
$cf_base = $_GET['cf_base'];
$cf_login = $_GET['cf_login'];
$cf_pass = $_GET['cf_pass'];
$cf_server = $_GET['cf_server'];

/*-- Выводим имена колонок таблицы --*/

$cf_db = mysql_connect($cf_server, $cf_login, $cf_pass);
if(!$cf_db){
	echo "Ошибка соединения с базой!!!";
	exit;
}
mysql_select_db($cf_base, $cf_db);
$cf_show_column = "SHOW COLUMNS FROM $cf_base.$cf_table_name";
$cf_result = mysql_query($cf_show_column);
if(!$cf_result){
	//echo "Ошибка при выполнении запроса".mysql_error();
	exit;
}
if(mysql_num_rows($cf_result) > 0){
	while($cf_rows = mysql_fetch_assoc($cf_result)){
		if($cf_rows[Extra] == "auto_increment" and $cf_rows[Key] == "PRI"){
			echo "<br><input type='checkbox' name=$cf_rows[Field] id=$cf_rows[Field] value=$cf_rows[Field] class='LINE_SELECT'> $cf_rows[Field]*";
		}else{
			echo "<br><input type='checkbox' name=$cf_rows[Field] id=$cf_rows[Field] value=$cf_rows[Field] class='LINE_SELECT'> $cf_rows[Field]";
		}
	}
}

echo "<br><input type='checkbox' name='auto_select_all' id='auto_select_all' value='все.' class='LINE_SELECT_ALL'> все.";

$cf_result = mysql_query($cf_show_column);

echo "<br>Выберите ключевое поле <select id='select_key_in_table_records'>";
if(mysql_num_rows($cf_result) > 0){
	echo "<option></option>";
	while($cf_rows = mysql_fetch_assoc($cf_result)){
		echo "<option value=$cf_rows[Field]>$cf_rows[Field]</option>";
	}
}

echo "</select><br>";

echo "<br><input type='submit' value='Показать' id='button_show_table_records'><br>";

/*----------------------------------------------------------*/
mysql_free_result($cf_result);
unset($cf_table_name);
unset($cf_base);
unset($cf_login);
unset($cf_pass);
unset($cf_server);

unset($cf_db);
unset($cf_show_column);
unset($cf_result);

?>
