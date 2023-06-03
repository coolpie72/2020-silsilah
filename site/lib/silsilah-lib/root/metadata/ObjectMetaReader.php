<?php
namespace silsilahApp\metadata;

use coolpie\file\FileLineReader;
use coolpie\str\StringUtil;

class ObjectMetaReader {
    
    public function __construct() {

    }

    public function read($filePath) {
        $this->objectMeta = new ObjectMeta();

        FileLineReader::processFile($filePath, $this, "processLine");

        return $this->objectMeta;
    }

    public function processLine($no, $line) {
        if ($line === "") return;
        if (StringUtil::startsWith($line, "#")) return;

        if (StringUtil::startsWith($line, "hdr:")) {
            $this->readHeader($line);
            return;
        }

        if (StringUtil::startsWith($line, "field:")) {
            $this->readField($line);
            return;
        }

    }

    public function readHeader($line) {
        // hdr:<db-table>:<class>:
        list(, $dbTable, $cls) = explode(":", $line);
        $this->objectMeta->dbTable = $dbTable;
        $this->objectMeta->name = $cls;

    }

    public function readField($line) {
        // field:<prop>:<type>:<db-field>:<nullable>:<pk>:
        list(, $prop, $type, $dbField, $strNullable, $strPk) = explode(":", $line);

        $pk = $strPk === "pk";
        $nullable = $strNullable === "y";

        if ($pk) {
            $this->objectMeta->addFieldPrimary($prop, $type, $dbField);
        } else {
            $this->objectMeta->addField($prop, $type, $nullable, $dbField);
        }

    }


}

