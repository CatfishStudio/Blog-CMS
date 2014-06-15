$(document).ready(function(){

	var CF_WINDOW_TABLE_RECORDS = $('#window_show_table_records');
	var CF_WINDOW_FORM_RECORDS = $('#window_works_form_records');
	
	var CF_BASE = $('#ActionBase').attr("value");
	var CF_LOGIN = $('#ActionLogin').attr("value");
	var CF_PASS = $('#ActionPass').attr("value");
	var CF_SERVER = $('#ActionServer').attr("value");
	var CF_TABLE_NAME = "";

	var cf_array_checked_column = []; /*Массив выбраных колонок таблицы*/
	var cf_checked_column_key = ""; /*Имя ключевого поля*/
	var cf_key_column_value = ""; /*значение ключевого поля*/

	var cf_save_edit_records = []; /*массив отредактированных значений*/

	var cf_save_editOrNew = ""; /*отметка типа сохранения изменения или новые*/

	/*-- Выводим список колонок выбранной таблицы --*/
	$('#tableList').click(function(e){
		var cf_tableClick = e.target;
		CF_TABLE_NAME = cf_tableClick.title;
		$.get("core/showColumn.php", {cf_table_name: cf_tableClick.title, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER}, function(data){
			$('#sidebarR').html("<div class='LIST_COLUMN'>Список полей:"+ data + "<br>из таблицы <p id='ActionTable'>" + cf_tableClick.title + "</p></div>");
		});
		cf_array_checked_column = []; /*очистка массива выбранных полей*/
		cf_checked_column_key = ""; /*очистка имени ключевого поля*/
		cf_key_column_value = ""; /*очищаем значение ключевого поля*/
		cf_save_edit_records = []; /*очистка массива отредактированных значений*/
		cf_save_editOrNew = ""; /*очистка отметки типа сохранения редактирование или новый*/
		CF_WINDOW_TABLE_RECORDS.html("<br>"); /*очистка окна*/
		CF_WINDOW_FORM_RECORDS.html("<br>"); /*очистка окна*/
		setEqualHeight($("#sidebarL,#sidebarR,#content,#wrapper"));
	});
	/*--------------------------------------------------------------------*/
	
	/*Выбор значения ключевого поля*/
	$('#window_show_select').live("change", function(e){
		cf_key_column_value = e.target.value;
	});
	/*--------------------------------------------------------------------*/

	/*-- Выбрать все колонки ------------------------------*/
	$('#auto_select_all').live("change", function(e){
		if(e.target.checked == true){
			/*Просматриваем все значения во всех полях*/
			$('#sidebarR .LINE_SELECT').each(function(e){
				cf_array_checked_column.push($(this).attr("id"));
			});
		}else{
			cf_array_checked_column = []; /*очистка массива выбранных полей*/
		}
	});
	/*--------------------------------------------------------------------*/

	/*-- МЕНЮ Кнопка Сохранение ----------------------*/
	$('#save_record').click(function(e){ /*ПУНКТ МЕНЮ*/
		if(cf_save_editOrNew == "NEW"){
			/*Просматриваем все значения во всех полях*/
			$('#window_works_form_records #cf_field').each(function(){
				cf_save_edit_records.push($(this).attr("value"));
			});
			/*Сохранить новые данные в базу данных*/
			$.get("core/saveNewRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_save_value: cf_save_edit_records}, function(data){
				CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
			});
			/*Обновим таблицу просмотра всех значений*/
			$.get("core/showRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key}, function(data){
				CF_WINDOW_TABLE_RECORDS.html("<div class='SHOW_RECORD'><table border = '0'>"+ data + "</table></div>")
			});
			cf_save_edit_records = []; /*очистка массива отредактированных значений*/
			/*очистка отметки типа сохранения редактирование или новый*/
			cf_save_editOrNew = ""; 
		}
		/*-------------------------------------------------------*/
		if(cf_save_editOrNew == "EDIT"){
			/*Просматриваем все значения во всех полях*/
			$('#window_works_form_records #cf_field').each(function(){
				cf_save_edit_records.push($(this).attr("value"));
			});
			/*Сохранение изменений в базу данных*/
			if(cf_key_column_value == "" || cf_checked_column_key == ""){
				alert("Вы не выбрали ключевое поле или значение ключевого поля!!!");
			}else{
				$.get("core/saveEditRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_key_column: cf_checked_column_key, cf_key_value: cf_key_column_value, cf_save_value: cf_save_edit_records}, function(data){
					CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
				});
			}
			cf_save_edit_records = []; /*очистка массива отредактированных значений*/
			 /*Обновим таблицу просмотра всех значений*/
			$.get("core/showRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key}, function(data){
				CF_WINDOW_TABLE_RECORDS.html("<div class='SHOW_RECORD'><table border = '0'>"+ data + "</table></div>")
			});
			/*очистка отметки типа сохранения редактирование или новый*/
			cf_save_editOrNew = ""; 
		}
	});
	/*--------------------------------------------------------------------*/

	/*-- Создаём новую запись --------------------------*/
	$('#create_record').click(function(e){
		if(CF_TABLE_NAME == ""){
			alert("Вы не выбрали таблицу!!!");
		}else{

			$.get("core/newRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER}, function(data){
				CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
			});
			cf_save_editOrNew = "NEW"; /*отметка НОВЫЙ*/
		}
	});
	/*-- Кнопка СОХРАНИТЬ НОВОЕ на форме редактировать*/
	$('#button_save_new_form').live("click", function(e){
		/*Просматриваем все значения во всех полях*/
		$('#window_works_form_records #cf_field').each(function(){
			cf_save_edit_records.push($(this).attr("value"));
		});
		/*Сохранить новые данные в базу данных*/
		$.get("core/saveNewRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_save_value: cf_save_edit_records}, function(data){
			CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
		});
		/*Обновим таблицу просмотра всех значений*/
		$.get("core/showRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key}, function(data){
			CF_WINDOW_TABLE_RECORDS.html("<div class='SHOW_RECORD'><table border = '0'>"+ data + "</table></div>")
		});
		cf_save_edit_records = []; /*очистка массива отредактированных значений*/
		/*очистка отметки типа сохранения редактирование или новый*/
		cf_save_editOrNew = ""; 
	});
	/*-- Кнопка ОТМЕНА НОВОГО на форме редактирования --*/
	$('#button_cancel_new_form').live("click", function(e){
		CF_WINDOW_FORM_RECORDS.html("<br>");
		cf_save_edit_records = []; /*очистка массива отредактированных значений*/
		/*очистка отметки типа сохранения редактирование или новый*/
		cf_save_editOrNew = ""; 
	});
	/*--------------------------------------------------------------------*/

	/*-- Редактировать запись --*/
	$('#edit_record').click(function(e){ /*ПУНКТ МЕНЮ*/
		if(cf_key_column_value == ""){
			alert("Вы не выбрали значение ключевого поля!!!");
		}else{
			$.get("core/editRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key, cf_key_value: cf_key_column_value}, function(data){
				CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
			});
			cf_save_editOrNew = "EDIT"; /*отметка РЕДАКТИРОВАНИЕ*/
		}
	});
	$('#button_edit_form').live("click", function(e){
		if(cf_key_column_value == ""){
			alert("Вы не выбрали значение ключевого поля!!!");
		}else{
			$.get("core/editRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key, cf_key_value: cf_key_column_value}, function(data){
				CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
			});
			cf_save_editOrNew = "EDIT"; /*отметка РЕДАКТИРОВАНИЕ*/
		}
	});
	/*-- Кнопка СОХРАНИТЬ на форме редактировать*/
	$('#button_save_edit_form').live("click", function(e){
		/*Просматриваем все значения во всех полях*/
		$('#window_works_form_records #cf_field').each(function(){
			cf_save_edit_records.push($(this).attr("value"));
		});
		/*Сохранение изменений в базу данных*/
		if(cf_key_column_value == "" || cf_checked_column_key == ""){
			alert("Вы не выбрали ключевое поле или значение ключевого поля!!!");
		}else{
			$.get("core/saveEditRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_key_column: cf_checked_column_key, cf_key_value: cf_key_column_value, cf_save_value: cf_save_edit_records}, function(data){
				CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
			});
		}
		cf_save_edit_records = []; /*очистка массива отредактированных значений*/
		 /*Обновим таблицу просмотра всех значений*/
		$.get("core/showRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key}, function(data){
			CF_WINDOW_TABLE_RECORDS.html("<div class='SHOW_RECORD'><table border = '0'>"+ data + "</table></div>")
		});
		/*очистка отметки типа сохранения редактирование или новый*/
		cf_save_editOrNew = ""; 
	});

	/*-- Кнопка ОТМЕНА на форме редактирования --*/
	$('#button_cancel_edit_form').live("click", function(e){
		CF_WINDOW_FORM_RECORDS.html("<br>");
		cf_save_edit_records = []; /*очистка массива отредактированных значений*/
		/*очистка отметки типа сохранения редактирование или новый*/
		cf_save_editOrNew = ""; 
	});
	/*--------------------------------------------------------------------*/

	/*-- Удалить запись --------------------------------------*/
	$('#delete_record').click(function(e){ /*ПУНКТ МЕНЮ*/
		if(confirm("Удалить выбранную запись?")){
			if(cf_key_column_value == "" || cf_checked_column_key == ""){
				alert("Вы не выбрали ключевое поле или значение ключевого поля!!!");
			}else{
				$.get("core/deleteRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_key_column: cf_checked_column_key, cf_key_value: cf_key_column_value}, function(data){
					CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
				});
			}
		}
	});
	$('#button_delete_form').live("click", function(e){
		if(confirm("Удалить выбранную запись?")){
			if(cf_key_column_value == "" || cf_checked_column_key == ""){
				alert("Вы не выбрали ключевое поле или значение ключевого поля!!!");
			}else{
				$.get("core/deleteRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_key_column: cf_checked_column_key, cf_key_value: cf_key_column_value}, function(data){
					CF_WINDOW_FORM_RECORDS.html("<div>"+ data + "</div>")
				});
			}
		}
	});
	/*--------------------------------------------------------------------*/

	/*-- Очистка формы ---------------------------------------*/
	$('#clear_form').click(function(e){ /*ПУНКТ МЕНЮ*/
		/*Просматриваем все значения во всех полях и стираем их*/
		$('#window_works_form_records #cf_field').each(function(){
			$(this).attr("value","");
		});
	});
	/*--------------------------------------------------------------------*/

	/* 
	    Обращение к списку в котором отображаются колонки выбранной таблицы 
	    Выводим содержимое выбранных колонок таблицы.
	*/
	$('.LINE_SELECT').live("click", function(e){
		var cf_select_column = e.target
		
		/*-- Определяем отмеченую колонку и заносим в массив --*/
		if(cf_select_column.checked == true){
			cf_array_checked_column.push(cf_select_column.id); /*идентификатор выбраной колонки*/
		}
		/*-- При снятии отметки удаляем из массива --*/
		if(cf_select_column.checked == false){
			var cf_i = 0;
			while (cf_i <= cf_array_checked_column.length){
				if(cf_array_checked_column[cf_i] == cf_select_column.id){
					cf_array_checked_column.splice(cf_i, 1);
				}
				cf_i++;
			}
		}
	});
	/*Выбранное ключевое поле*/
	$('#select_key_in_table_records').live("change", function(e){
		cf_checked_column_key = e.target.value;
	});
	/*-- Показываем содержимое таблицы --*/
	$('#button_show_table_records').live("click", function(e){
		 /*Проверка выбора ключевого поля*/
		if(cf_checked_column_key == ""){
			alert("Вы не выбрали ключевое коле!!!");
		}else{
			$.get("core/showRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key}, function(data){
				CF_WINDOW_TABLE_RECORDS.html("<div class='SHOW_RECORD'><table border = '0'>"+ data + "</table></div>")
			});
		}
	});
	/*-- Обновить  содержимое таблицы --*/
	$('#button_update_table_records').live("click", function(e){
		 /*Проверка выбора ключевого поля*/
		if(cf_checked_column_key == ""){
			alert("Вы не выбрали ключевое коле!!!");
		}else{
			$.get("core/showRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key}, function(data){
				CF_WINDOW_TABLE_RECORDS.html("<div class='SHOW_RECORD'><table border = '0'>"+ data + "</table></div>")
			});
			CF_WINDOW_FORM_RECORDS.html("<br>");
		}
	});

	$('#show_table_content').live("click", function(e){ /*ПУНКТ МЕНЮ*/
		 /*Проверка выбора ключевого поля*/
		if(cf_checked_column_key == ""){
			alert("Вы не выбрали ключевое коле!!!");
		}else{
			$.get("core/showRecords.php", {cf_table_name: CF_TABLE_NAME, cf_base: CF_BASE, cf_login: CF_LOGIN, cf_pass: CF_PASS, cf_server: CF_SERVER, cf_checked_columns: cf_array_checked_column, cf_key_column: cf_checked_column_key}, function(data){
				CF_WINDOW_TABLE_RECORDS.html("<div class='SHOW_RECORD'><table border = '0'>"+ data + "</table></div>")
			});
		}
	});
	/*--------------------------------------------------------------------*/
	


	/*-- Выравниваем столбцы страницы. ------------*/
	function setEqualHeight(columns)
 	{
 		var tallestcolumn = 0;
 		columns.each(function() {
 			currentHeight = $(this).height();
			if(currentHeight > tallestcolumn)
			{
				tallestcolumn  = currentHeight;
			}
		});
 		columns.height(tallestcolumn);
	}

	setEqualHeight($("#sidebarL,#sidebarR,#content, #wrapper"));
	

	//$.getScript("core/equalHeight.js");
});//конец ready
