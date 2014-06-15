<?php
	$BASE = $_POST['base'];
	$LOGIN = $_POST['login'];
	$PASS = $_POST['pass'];
	$SERVER = $_POST['server'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="SHORTCUT ICON" href="images/favicon.ico" type="image/x-icon">
<!-- Подключение таблиц стиля -->
<link rel="stylesheet" type="text/css" href="style/default.css" media="screen">
<!-- Подключение скриптов -->
<script src="core/jquery-1.8.3.min.js"></script>
<script src="core/core.js"></script>
<title>ADMIN [CMS CATFISH]</title>
</head>
<body>
	<div id="wrapper">
		<?php
		if(isset($BASE) and isset($LOGIN) and isset($PASS)){
			if($BASE !="" and $LOGIN !=""){
				echo "<div id='header'>";
					echo "<div id='globalBaseInfo'>Информация:";
					echo "<br><label for='ActionServer'>Сервер:</label><input type='text' name='ActionServer' id='ActionServer' class='GLOBAL_INFO' value=$SERVER>";
					echo "<br><label for='ActionBase'>База данных:</label><input type='text' name='ActionBase' id='ActionBase' class='GLOBAL_INFO' value=$BASE>";
					echo "<br><label for='ActionLogin'>Логин:</label><input type='text' name='ActionLogin' id='ActionLogin' class='GLOBAL_INFO' value=$LOGIN>";
					echo "<br><label for='ActionPass'>Пароль:</label><input type='password' name='ActionPass' id='ActionPass' class='GLOBAL_INFO' value=$PASS>";
					echo "</div>";
					echo "<div>";
						include "plugins/standard_menu/menu.php";
					echo "</div>";
				echo "</div>";
				echo "<div id='sidebarL'>";
					echo "<div class='TITLE_LIST'>Список таблиц:</div>";
					echo "<div id='tableList'>";

					/*--- ВЫВОДИМ ВСЕ ТАБЛИЦЫ БАЗЫ ДАННЫХ --*/
					if(!mysql_connect($SERVER, $LOGIN, $PASS)){
						echo "Ошибка соединения с базой!!!";
						exit;
					}
					$show_table = "SHOW TABLES FROM $BASE";
					$result = mysql_query($show_table);
					while($showTableRow = mysql_fetch_array($result))
					{
						echo "<div class='LINE_LIST' title='$showTableRow[0]'>$showTableRow[0]</div>";
					}
					mysql_free_result($result);
					/*----------------------------------------------------------*/
					echo "</div>";
					
				echo "</div>";
				echo "<div id='sidebarR'>";
				echo "</div>";
				echo "<div id='content'>";
					echo "<div id='window_show_records'>Содержимое выбранной таблицы:<dr>";
						echo "<div id='window_show_table_records'>";
						echo "</div>";
					echo "</div>";
					echo "<br><br>";
					echo "<div id='window_works_records'>Окно редактирования:<dr>";
						echo "<div id='window_works_form_records'>";
						echo "</div>";
					echo "</div>";

				echo "</div>";
			}
		}
		?>
		<div class="clear"></div> <!-- отделим подвал -->
		<div id="footer">
			<div id="footerShow"><br>Copyright 2013 © CATFISH STUDIO</div>	
		</div>
	</div>
</body>
</html>

