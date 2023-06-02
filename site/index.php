<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


//bootstrap utk coolpie lib
require_once "lib/coolpie-lib/coolpie-lib.php";

include "site_data.php";
include "menu.php";

include_once "lib/class.Util.php";
include_once "lib/class.DBManager.php";

include_once "lib/class.Metadata.php";

include_once "lib/class.SqlUtil.php";

include_once "lib/class.Person.php";
include_once "lib/class.PersonService.php";

include_once "lib/class.Marriage.php";
include_once "lib/class.MarriageService.php";

include_once "lib/class.MarriageChild.php";
include_once "lib/class.MarriageChildService.php";

include_once "lib/root-test.php";

require_once "lib/content.php";

require_once "lib/app-data.php";

AppData::get()->data['title'] = 'Aplikasi Silsilah';


//page default: home
//sementara arahkan ke person-list
$page = "person-list";

//override page dari query parameter "page"
if (isset($_GET['page'])){
	$page = $_GET['page'];
}

//default: hello
$file = "pages/profil.html";
if (file_exists("pages/$page.php")){
	$file = "pages/$page.php";
}
Content::start();
require_once $file; 
Content::end();


//render template
include "template.html";

?>