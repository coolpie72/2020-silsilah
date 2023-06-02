<?php 

declare(strict_types=1);

require_once("coolpie-lib.php");


use PHPUnit\Framework\TestCase;

use coolpie\config\AppConfig;

class AppConfigTest extends TestCase {
	
	public function setUp(): void {
	}
	
	public function test1() {
	    AppConfig::setParam(__DIR__, "config.php");
	    $val = AppConfig::getInstance()->get("foo.alpha");
        
        $this->assertEquals("alpha", $val);     
	}
	
	public function test2() {
	    AppConfig::setParam(__DIR__, "config.php");
	    $val = AppConfig::getInstance()->getInt("erp.maxCount");
	    
	    $this->assertIsInt($val);
		$this->assertEquals(123, $val);
	}
	

    
}
