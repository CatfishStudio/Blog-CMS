<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Подключение таблиц стиля -->
<link rel="stylesheet" type="text/css" href="css/default.css" media="screen">
<!-- Подключение скриптов -->
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/equalHeight.js"></script>
<title>ТЕМА ОТ CATFISH STUDIO</title>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<?php include "header.php"; ?>
		</div>
		<div>
			<?php include "plugins/standard_menu/menu.php"; ?>
		</div>		
		<div id="sidebarL">
			<?php include "sidebarL.php"; ?>
		</div>
		<div id="sidebarR">
			<?php include "sidebarR.php"; ?>
		</div>
		<div id="content">
			<?php include "content.php"; ?>
		</div>
		<div class="clear"></div> <!-- отделим подвал -->
	</div>
	<div id="footer">
		<?php include "footer.php"; ?>
	</div>
</body>
</html>
