<?php
	echo "<form action='admin.php' method='post'>";
	echo "<label for='server'>Сервер:</label><br><input type='text' name='server' id='server' value='localhost'><br>";
	echo "<label for='base'>База данных:</label><br><input type='text' name='base' id='base'><br>";
	echo "<br><label for='login'>Логин:</label><br><input type='text' name='login' id='login'><br>";
	echo "<label for='pass'>Пароль:</label><br><input type='password' name='pass' id='pass'><br>";
	echo "<br><input type='submit' value='Войти' id='bottonGo'>";
	echo "</form>";
?>
