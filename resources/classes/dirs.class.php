<?php

/**
 * Class dirs
 */
class dirs
{
    /**
     * @param $file
     */
    public static function delete_file($file)
    {
        unlink($file);
    }

    /**
     * @param $source
     * @param $destination
     */
    public static function copy($source, $destination)
    {
        copy($source, $destination);
    }

    /**
     * @param $folder
     * @param string $mode
     */
    public static function create_folder($folder, $mode = '0777')
    {
        mkdir($folder, $mode);
    }

    /**
     * @param $folder
     */
    public static function delete_folder($folder)
    {
        rmdir($folder);
    }

    /**
     * @param $path
     * @return array
     */
    public static function get_folder($path)
    {
        $ignore = array('cgi-bin', '.', '..');
        $struct = array();
        if (is_dir($path)) {
            $dh = opendir($path);
            while (FALSE !== ($file = readdir($dh))) {
                if (!in_array($file, $ignore)) {
                    if (!is_dir("$path/$file")) {
                        $struct[] = $file;
                    } else {
                        self::get_folder($path . '/' . $file);
                    }
                }
            }
            closedir($dh);
        }

        return $struct;
    }
}