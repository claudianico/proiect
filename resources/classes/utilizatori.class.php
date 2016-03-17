<?php

/**
 * Class utilizatori
 */
class utilizatori extends table
{
    /**
     * @var string
     */
    protected static $table = 'utilizatori';

    /**
     * @var array
     */
    protected static $fields = array('id', 'nume', 'username', 'parola', 'email', 'birthday', 'created', 'modified');

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $nume;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $parola;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $birthday;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $modified;

    /**
     * @param $username
     * @param $password
     * @return utilizatori|bool
     */
    public static function loginUser($username, $password)
    {
        global $database;
        $sql = "SELECT * FROM " . static::$table . " WHERE username = '" . $database->escape($username) . "' AND parola = '" . $database->escape($password) . "'";

        $result = static::get_custom($sql);
        if ($result) {
            return $result[0];
        } else {
            return FALSE;
        }
    }
}