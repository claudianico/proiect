<?php
/**
 * Class admini
 */
class admini extends table
{
    /**]
     * @var string
     */
    protected static $table = 'admini';

    /**
     * @var array
     */
    protected static $files = array('id', 'username', 'password');

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @param $username
     * @param $password
     * @return admini|bool
     */
    public static function loginUser($username, $password)
    {
        global $database;
        $sql = "SELECT * FROM " . static::$table . " WHERE username = '" . $database->escape($username) . "' AND password = '" . $database->escape($password) . "'";

        $result = static::get_custom($sql);
        if ($result) {
            return $result[0];
        } else {
            return FALSE;
        }
    }
}