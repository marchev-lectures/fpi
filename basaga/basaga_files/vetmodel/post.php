<?php
	/*
		2 функции для взаимодействия с API Text.ru посредством POST-запросов.
		Ответы с сервера приходят в формате JSON. 
	*/

	//-----------------------------------------------------------------------
	
	/**
	 * Добавление текста на проверку
	 *
	 * @param string $text - проверяемый текст
	 * @param string $user_key - пользовательский ключ
	 * @param string $exceptdomain - исключаемые домены
	 *
	 * @return string $text_uid - uid добавленного текста 
	 * @return int $error_code - код ошибки
	 * @return string $error_desc - описание ошибки
	 */
	function addPost()
	{
		$postQuery = array();
		$postQuery['text'] = "Введите свой текст";
		$postQuery['userkey'] = "2c7e34d4ae46d53291646488dbfae201";
		// домены разделяются пробелами либо запятыми. Данный параметр является необязательным.
		//$postQuery['exceptdomain'] = "site1.ru, site2.ru, site3.ru";
		// Раскомментируйте следующую строку, если вы хотите, чтобы результаты проверки текста были по-умолчанию доступны всем пользователям
		//$postQuery['visible'] = "vis_on";
		// Раскомментируйте следующую строку, если вы не хотите сохранять результаты проверки текста в своём архиве проверок
		//$postQuery['copying'] = "noadd";
		// Указывать параметр callback необязательно
		//$postQuery['callback'] = "Введите ваш URL-адрес, который примет наш запрос";

		$postQuery = http_build_query($postQuery, '', '&');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://api.text.ru/post');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postQuery);
		$json = curl_exec($ch);
		$errno = curl_errno($ch);

		// если произошла ошибка
		if (!$errno)
		{
			$resAdd = json_decode($json);
			if (isset($resAdd->text_uid))
			{
				$text_uid = $resAdd->text_uid;
			}
			else
			{
				$error_code = $resAdd->error_code;
				$error_desc = $resAdd->error_desc;
			}
		}
		else
		{
			$errmsg = curl_error($ch);
		}

		curl_close($ch);
	}
?>