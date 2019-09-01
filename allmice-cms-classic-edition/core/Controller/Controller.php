<?php
/*
 * Allmice(TM) PHP Framework
 * Version 1.5.4 (2019-05-06)
 * Copyright 2016-2019 by Any Outline LTD
 * www.allmice.com/framework
 * Allmice PHP Framework code is released under the "New BSD License".
 * See README.TXT file in the "root" directory.

 * Extendable parent class Controller

 */

class Controller
{
	public $dbConfig;
	public $sessionConfig;
	public $modConfig;
	public $modLang;

	function redirect($url, $permanent = false)
	{
	    header('Location:' . $url, true, $permanent ? 301 : 302);

	    exit();
	}

}
