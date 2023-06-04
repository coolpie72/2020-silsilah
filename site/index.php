<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


//bootstrap utk coolpie lib
require_once "lib/coolpie-lib/coolpie-lib.php";
require_once "lib/coolpie-lib/coolpie-loader.php";
require_once "lib/silsilah-lib/silsilah-loader.php";

include "site_data.php";
include "menu.php";

use silsilahApp\AppData;
use silsilahApp\Content;

AppData::get()->data['title'] = 'Aplikasi Silsilah';


//page default: home
//sementara arahkan ke person-list
$page = "person-list";

//override page dari query parameter "page"
if (isset($_GET['page'])){
	$page = $_GET['page'];
}

//default: hello
$file = "pages/default.php";
if (file_exists("pages/$page.php")){
	$file = "pages/$page.php";
}
Content::start();
require_once $file; 
Content::end();


//render template
include "template.html";

?>