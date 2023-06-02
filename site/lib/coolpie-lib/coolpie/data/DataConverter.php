<?php 
namespace coolpie\data;

class DataConverter {
    private $data;

    private function __construct($data) {
        $this->data = $data;
    }

    public static function create($data) {
        return new self($data);
    }

    public static function fromJson($data) {
        $obj = json_decode($data);
        return new self($obj);
    }

    public function toJson($pretty = false) {
        if ($pretty) {
            $this->data = json_encode($this->data, JSON_PRETTY_PRINT);
        } else {
            $this->data = json_encode($this->data);
        }
        
        return $this;
    }

    public function toGzip() {
        // $zip = gzcompress($this->data);
        $zip = gzencode($this->data);
        $this->data = $zip;
        return $this;
    }

    public function get() {
        return $this->data;
    }

    // if type(self.data) != str:
    //     raise Exception("gzip input must be string")

    // zip = gzip.compress(bytes(self.data,'utf-8'))
    // self.data = zip
    // return self

    



}

?>