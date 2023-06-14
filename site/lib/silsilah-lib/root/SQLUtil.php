<?php
namespace silsilahApp;

use silsilahApp\metadata\Metadata;

class SqlUtil {
    
    function __construct() {
        
    }   

    private static function getStrIdsCondition($objMeta, $idObject) {
        
        $idFields = $objMeta->getIdFields();

        // var_dump($idFields);die;
        // var_dump($idObject);

        $partIds = [];
        foreach ($idFields as $idField) {
            $fieldMeta = $objMeta->fields[$idField];
            // var_dump($fieldMeta);
            $val = self::getSqlValue($fieldMeta, $idObject->{$fieldMeta->name});
            $partIds[] = "{$fieldMeta->dbField} = {$val}";
        }
        $strIds = implode(" and ", $partIds);

        return $strIds;
    }

    public static function getLoad($metaName, $idObject) {

        $objMeta = Metadata::get()->getObject($metaName);

        $strIds = self::getStrIdsCondition($objMeta, $idObject);

        $sql = "select * from {$objMeta->dbTable} where {$strIds}";

        // var_dump($sql);die;

        return $sql;

    }

    public static function getDelete($metaName, $idObject) {

        $objMeta = Metadata::get()->getObject($metaName);

        $strIds = self::getStrIdsCondition($objMeta, $idObject);

        $sql = "delete from {$objMeta->dbTable} where {$strIds}";

        // var_dump($sql);die;

        return $sql;

    }

    public static function getInsert($obj, $data) {
        //insert into table (c1, c2, c3) values(v1, v2, v3)

        $partFields = array();
        $partVals = array();
        //iterate object fields

        $objMeta = Metadata::get()->getObject($obj);
        foreach($objMeta->fields as $f) {
            $partFields[] = $f->dbField;
            $partVals[] = self::getSqlValue($f, $data->{$f->name});
        }

        $strFields = implode(",", $partFields);
        $strVals = implode(",", $partVals);


        $sql = "insert into {$objMeta->dbTable} ($strFields) values ($strVals)";

        //var_dump($sql);
        return $sql;
    }

    public static function getUpdate($obj, $data) {
        //update table set c1=v1, c2=v2 where id1=v1 and id2=v2

        $partFields = array();
        $partIds = array();
        //iterate object fields

        $objMeta = Metadata::get()->getObject($obj);
        foreach ($objMeta->fields as $f) {

            $val = self::getSqlValue($f, $data->{$f->name});
            if ($f->isPrimary) {
                $partIds[] = "{$f->dbField} = $val";
            }
            else {
                $partFields[] = "{$f->dbField} = $val";
            }

        }

        $strFields = implode(", ", $partFields);
        $strIds = implode(" and ", $partIds);


        $sql = "update {$objMeta->dbTable} set $strFields where $strIds";

        // var_dump($sql);
        return $sql;
    }

    public static function getSqlValue($f, $val) {
        if ($f->type = "string") {
            $trim = trim($val);

            //kalau nullable dan string kosong, paksa ke null
            if ($f->nullable && $trim == "") {
                return "null";
            }
            return "'$trim'";
        }

        //date string
        if ($f->type = "date") {
            $trim = trim($val);

            //kalau nullable dan string kosong, paksa ke null
            if ($f->nullable && $trim == "") {
                return "null";
            }
            return "'$trim'";
        }       

        //integer
        if ($f->type = "int") {

            // //kalau nullable dan string kosong, paksa ke null
            // if ($f->nullable && $trim == "") {
            //     return "null"
            // }

            //as is
            return $val;
        }       

        //default pakai single quoted
        return "'$val'";
    }

    public static function createObject($name, $row) {
        $objMeta = Metadata::get()->getObject($name);
        $className = $objMeta->name;

        $obj = new $className();

        foreach ($objMeta->fields as $f) {
            $field = $f->name;
            $obj->$field = $row[$f->dbField];
        }

        return $obj;

    }

}