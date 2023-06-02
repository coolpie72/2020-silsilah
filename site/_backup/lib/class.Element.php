<?php
    class Element{
        private $attrs;
        private $tag;
        private $text;
        private $contents;

        function __construct($tag) {
            $this->attrs = array();
            $this->tag = $tag;
            $this->text = null;
            $this->contents = array();
        }

        public static function create($tag) {
            $obj = new self($tag);
            return $obj;
        }

        public function att($key, $val) {
            $this->attrs[$key] = $val;
            return $this;
        }

        //attribute for point x,y
        public function attPoint($kx, $ky, $pt) {
            return $this->att($kx, $pt->x)->att($ky, $pt->y);
        }

        public function attPointTransform($kx, $ky, $pt, &$transformer) {
            $px = $transformer->transform($pt);
            return $this->att($kx, $px->x)->att($ky, $px->y);
        }

        //add child node, can be text, or element
        public function child($val) {
            $this->contents[] = $val;
            return $this;
        }

        public function hasAttribute() {
            return count($this->attrs) > 0;
        }

        public function hasContents() {
            return count($this->contents) > 0;
        }

        public function renderAttributes() {
            $parts = array();
            foreach($this->attrs as $key => $val) {
                $parts[] = "$key=\"$val\"";
            }
            return implode(" ", $parts);
        }

        public function renderContents() {
            $str = "";
            foreach($this->contents as $c) {
                if ($c instanceof Element) {
                    //asumsi adalah object element
                    $str .= $c->get() . "\n"; //recursive
                }
                else {
                    //assume its text
                    $str .= $c;
                }
            }

            return $str;
        }

        public function get() {
            $str = "<{$this->tag}";
            if ($this->hasAttribute()) {
                $str .= " ";
                $str .= $this->renderAttributes();
            }

            if ($this->hasContents()) {
                $str .= ">";
                $str .= $this->renderContents();
                $str .= "</{$this->tag}>";
            }
            else {
                $str .= "/>";
            }

            return $str;

        }

    }



?>