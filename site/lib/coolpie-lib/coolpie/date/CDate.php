<?php
namespace coolpie\date;

use DateTime;
use DateTimeZone;
use DateInterval;
use Exception;

class CDate {
    private static $FMT_STD_LITERAL = "Y-m-d H:i:s";
    private static $FMT_STD_LITERAL_DATE_ONLY = "Y-m-d";
    
    public static $TZ_UTC = "+00:00";
    public static $TZ_WIB = "+07:00";

    private $stamp;
    private $date;
    
    //constructor method
    //$dt = CDate::create()
    public static function create() {
        $dt = new CDate();
        return $dt;
    }
    
    //compare sebuah date dgn date lain, apakah sama
    public function compare(CDate $other) {
        return $this->diff($other);
    }
    
    //mengembalikan string literal dalam wib dan utc
    public function toStringUtcWib() {
        $dt = self::create()->fromCopy($this);
        $utc = $dt->toLiteral();
        $wib = $dt->toWib()->toLiteral();
        return "$wib WIB - $utc UTC";
    }

    //modifier method
    //parse date string to date
    //$dt = CDate::create()->fromParse(fmt, date string)
    public function fromParse($fmt, $stampStr) {
        $res = DateTime::createFromFormat($fmt, $stampStr, new DateTimeZone(self::$TZ_UTC));
        //handle jika gagal parse
        if ($res === false) {
            return null;
        }
        $this->date = $res;
        return $this;
        // $this->setTimezone(self::$TZ_UTC);
    }

    //modifier method
    //$dt = CDate::create()->fromNowWib()
    //khusus utk tz WIB
    public function fromNowWib() {
        return $this->fromNow(self::$TZ_WIB);
    }
    
    public function fromStamp($stamp, $tz) {
        $this->fromNow($tz);
//         $this->setTimezone($tz);
        $this->date->setTimestamp($stamp);
        return $this;
    }

    //modifier method
    //$dt = CDate::create()->fromNow()
    //assume default tz = UTC
    public function fromNow($tzString = null) {
        // $str = date(self::$FMT_STD_LITERAL);
        // echo "date-str: $str\n";
        // $this->fromLiteral($str);
        // $this->date->setTimezone(self::$TZ_UTC);
        //$this->date = new DateTime("now");
        $tzParam = $tzString == null ? self::$TZ_UTC : $tzString;

        $this->date = new DateTime("now", new DateTimeZone($tzParam));
        // $this->date->setTimestamp(time());
        return $this;
    }

    //modifier method
    //ubah timezone (misal dari utc ke wib)
    //dapat gunakan konstanta TZ_UTC atau TZ_WIB
    public function setTimezone(string $tzString) {
        $this->date->setTimezone(new DateTimeZone($tzString));
        return $this;
    }

    //modifier method
    //shortcut utk from parse tp utk std stamp format
    public function fromLiteral(string $stampStr) {
        $this->fromParse(self::$FMT_STD_LITERAL, $stampStr);
        return $this;
    }

    //modifier method
    //copy this date from other date
    public function fromCopy(CDate $other) {
        $this->fromLiteral($other->toLiteral());
        return $this;
    }

    //to string method
    //std literal output
    public function toLiteral() {
        return $this->format(self::$FMT_STD_LITERAL);
    }

    //custom to string format
    public function format($fmt) {
        return $this->date->format($fmt);
    }

    //add interval string ke date ini
    //spesifikasi interval string: https://www.php.net/manual/en/datetime.formats.relative.php
    //contoh interval:
    //7 day atau 7 days
    //2 hour atau 2 hours
    //1 hour 30 minute 55 second
    //-1 hour -30 minute -55 second
    public function addInterval($intervalString) {
        $intv = DateInterval::createFromDateString($intervalString);
        $this->date->add($intv);
        return $this;
    }

    //add hour to this date
    //hour bisa positif atau negatif (maju atau mundur)
    public function addHour($hour) {
        $absHour = abs($hour);
        $intv = new DateInterval("PT{$absHour}H");
        if ($hour >= 0) {
            $this->date->add($intv);
        } else {
            $this->date->sub($intv);
        }
        
        return $this;
    }

    //ISO 8601 (PnYnMnDTnHnMnS)
    public function addMinute($minute) {
        $absMinute = abs($minute);
        $intv = new DateInterval("PT{$absMinute}M");
        if ($minute >= 0) {
            $this->date->add($intv);
        } else {
            $this->date->sub($intv);
        }
        
        return $this;
    }

    public function addSecond($second) {
        $absSecond = abs($second);
        $intv = new DateInterval("PT{$absSecond}S");
        if ($second >= 0) {
            $this->date->add($intv);
        } else {
            $this->date->sub($intv);
        }
        
        return $this;
    }


    public function diff($other) {
        $res = $this->date->getTimestamp() - $other->date->getTimestamp();
        return $res;
    }

    public static function convertFormat($fmtFrom, $fmtTo, $stamp) {
        $dt = new self();
        $dt->fromParse($fmtFrom, $stamp);
        return $dt->format($fmtTo);
    }

    public function debug() {
        var_dump($this->date);
    }

    public function getStamp() {
        return $this->date->getTimestamp();
    }

    public function toUtc() {
        return $this->setTimezone(self::$TZ_UTC);
    }

    public function toWib() {
        return $this->setTimezone(self::$TZ_WIB);
    }

    public function addUnit($num, $unit) {
        if ($unit == "hr" || $unit == "hour" || $unit == "h" || $unit == "H") {
            return $this->addHour($num);
        } else if ($unit == "min" || $unit == "m" || $unit == "M") {
            return $this->addMinute($num);
        } else if ($unit == "sec" || $unit == "s" || $unit == "S") {
            return $this->addSecond($num);
        }

        throw new Exception("Invalid date unit: $unit");
    }

}

?>