<?php
namespace silsilahApp;

use coolpie\cache\SimpleCacheClosure;

class PersonCache {
    
    private $cache;
    private $personService;

    public function __construct($personService) {
        $this->personService = $personService;
        
        $me = $this;
        $providerFunc = function ($key) use ($me) {
            return $me->personService->load($key);
        };
        
        $this->cache = new SimpleCacheClosure($providerFunc);
    }

    public function get($id) {
        return $this->cache->get($id);
    }
}