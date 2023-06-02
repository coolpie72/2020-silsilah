<?php 

declare(strict_types=1);

require_once("coolpie-lib.php");

use PHPUnit\Framework\TestCase;
use coolpie\str\StringUtil;

class StringUtilTest extends TestCase {
	
	public function setUp(): void {

	}

	public function testChop1() {
		$res = StringUtil::chopEnd("/var/www/html/foo/", 1);
		$this->assertEquals($res, "/var/www/html/foo");
	}

	public function testChop2() {
		$res = StringUtil::chopEnd("foo", 3);
		$this->assertEquals($res, "");
	}

	public function testChop3() {
		$res = StringUtil::chopEnd("foobar", 10);
		$this->assertEquals($res, "");
	}
	
	public function testStartsWith_Normal(): void {
		$res = StringUtil::startsWith("foo bar", "foo");
		$this->assertTrue($res);
	}
	
	public function testStartsWith_NormalFalse(): void {
		$res = StringUtil::startsWith("foo bar", "bar");
		$this->assertFalse($res);
	}

    public function testStartsWith_Equal(): void {
    	$res = StringUtil::startsWith("foo bar", "foo bar");
    	$this->assertTrue($res);
    }
    
    public function testStartsWith_EmptyString(): void {
    	$res = StringUtil::startsWith("foo bar", "");
    	$this->assertTrue($res);
    }
    
    public function testStartsWith_Middle1(): void {
    	$res = StringUtil::startsWith("foo bar", " ba");
    	$this->assertFalse($res);
    }
     

    //split first char
    
    public function testSplitFirstChar_Normal(): void {
    	$res = StringUtil::splitByFirstChar("foo=bar", "=");
    	$this->assertEquals($res, ["foo", "bar"]);
    }
    
    public function testSplitFirstChar_MultipleChar1(): void {
    	$res = StringUtil::splitByFirstChar("foo=bar=baz", "=");
    	$this->assertEquals($res, ["foo", "bar=baz"]);
    }
    
    public function testSplitFirstChar_MultipleChar2(): void {
    	$res = StringUtil::splitByFirstChar("foo=====baz==", "=");
    	$this->assertEquals($res, ["foo", "====baz=="]);
    }
    
    public function testSplitFirstChar_NoValPart(): void {
    	$res = StringUtil::splitByFirstChar("foo=", "=");
    	$this->assertEquals($res, ["foo", ""]);
    }
    
    public function testSplitFirstChar_NoSep(): void {
    	$res = StringUtil::splitByFirstChar("foo", "=");
    	$this->assertEquals($res, ["foo"]);
    }
    
   
}
