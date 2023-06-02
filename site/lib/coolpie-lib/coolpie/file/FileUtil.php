<?php 
namespace coolpie\file;
// coolpieRequire("coolpie.data.ByteLib");

use coolpie\data\ByteLib;

class FileUtil {

    public static function stripExtension($filename) {
        $arr = explode(".", $filename);
        array_pop($arr); //pop the extension
        return implode(".", $arr);
    }

    public static function getExtension($filename) {
        $arr = explode(".", $filename);
        $ext = array_pop($arr); //pop the extension
        return $ext;
    }    

    public static function joinPath(... $params) {
        return implode(DIRECTORY_SEPARATOR, $params);
    }

    public static function isExist($file) {
        return file_exists($file);
    }

    public static function getFileStats($file) {
        return stat($file);
    }

    public static function getFileSizeHuman($file) {
        $stat = self::getFileStats($file);
        return ByteLib::humanFormat($stat["size"]);
    }

    
    public static function getFileSize($file) {
        $stat = self::getFileStats($file);
        return $stat["size"];
    }

    public static function getBaseName($file) {
        return basename($file);
    }

    //folder: full path folder yg akan dibaca
    //append folder path: jika ingin filename nya full path atau tidak (name only)
    public static function getFolderFiles($folder, $appendFolderPath = false) {
        $arr = scandir($folder);
        $res = [];
        foreach ($arr as $file) {
            if ($file === ".") continue;
            if ($file === "..") continue;
            if (is_dir(FileUtil::joinPath($folder, $file))) continue;

            $path = $file;
            if ($appendFolderPath) {
                $path = self::joinPath($folder, $file);
            }
            $res[] = $path;
        }

        return $res;
    }

    //filename: full path filename
    //return: boolean: sukses/gagal
    public static function createEmptyFile($filename) {
        $bytes = file_put_contents($filename,"");
        //jika sukses bytes: jumlah bytes tertulis
        //jika gagal: false 
        return $bytes != false;
    }

    //filename: full path filename
    //return: boolean: sukses/gagal
    public static function removeFile($filename) {
        return unlink($filename);
    }

    //filepath: src file full path
    //dest folder: dest folder path
    public static function moveToFolder($filePath, $destFolder) {
        $basename = self::getBaseName($filePath);
        $destFile = FileUtil::joinPath($destFolder, $basename);
        return rename($filePath, $destFile);
    }

    //generate file name yg path nya sama dengan filePath
    //hanya pola <ext> di orig file di rename ke <new-ext>
    //misal: /var/data/foo.txt dapat menghasilkan /var/data/foo-r1.txt
    public static function filePathChangeExt($filePath, $ext, $newExt) {
        $basename = FileUtil::getBaseName($filePath);
        $folder = dirname($filePath);
        //TODO: pastikan ext pattern berada di belakang string
        $newName = str_replace($ext, $newExt, $basename);
        return self::joinPath($folder, $newName);
    }

}

?>