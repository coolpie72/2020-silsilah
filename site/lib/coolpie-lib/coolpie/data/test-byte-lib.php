<?php

require_once "ByteLib.php";

echo ByteLib::humanFormat(1) . "\n";
echo ByteLib::humanFormat(200) . "\n";
echo ByteLib::humanFormat(1023) . "\n";
echo ByteLib::humanFormat(1024) . "\n";
echo ByteLib::humanFormat(1030) . "\n";
echo ByteLib::humanFormat(10140400, "k") . "\n";
echo ByteLib::humanFormat(198831, "k") . "\n";


echo ByteLib::humanFormatConvert(8, "G", "k") . "\n";
echo ByteLib::humanFormatConvert(8, "G", "k", true) . "\n";

echo ByteLib::humanFormatConvert(16260944, "k", "G") . "\n";
echo ByteLib::humanFormatConvert(16260944, "k", "G", true) . "\n";

echo ByteLib::humanFormatConvertString("8G", "k", true);

?>