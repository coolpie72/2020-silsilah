<?php 

namespace coolpie\cmd;

use coolpie\param\CommandParam;
// coolpieRequire("coolpie.param.CommandParam");

abstract class BaseCliApp {

    protected $param;
    protected $verbose;

    public function __construct() {
        $this->param = new CommandParam();
        $this->param->fromStd();

        $this->verbose = $this->param->haveParam("verbose");
        
        $optFile = $this->param->getParam("opt-file");
        if ($optFile != null) {
//         	echo "parse opt file: $optFile\n"; die();
        	$this->param->parseOptionFile("opt-file");
        }
    }
    
    public function echoStdErr($msg) {
    	fwrite(STDERR, $msg);
    }
    
    public function checkRequiredParam($name) {
    	$ok = $this->param->haveParam($name);
    	
    	if (!$ok) {
    		$this->echoStdErr("ERROR: parameter $name not set\n");
    		exit();
    	}
    }

    protected function executeMethod($method) {
        if (!method_exists($this, $method)) return ;
        call_user_func([$this, $method]);
    }

    protected function displayVerbose($str) {
        if (!$this->verbose) return;
        echo $str . PHP_EOL;
    }

    public function setPropertyByParam($prop, $paramKey, $default) {
        $propName = $prop;
        $this->$propName = $default;
        if ($this->param->haveParam($paramKey)) {
            $this->$propName = $this->param->getParam($paramKey);
        } 
    }

    abstract public function run();

}


?>