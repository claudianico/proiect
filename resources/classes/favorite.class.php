<?php

/**
 * Class favorite
 */
class favorite extends table
{
    /**
     * @var string
     */
    protected static $table = 'favorite';

    /**
     * @var array
     */
    protected static $fields = array('id', 'user_id', 'product_id', 'created', 'modified');

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var string
     */
    public $product_id;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $modified;

    /**
     * @param $userId
     * @param $produsId
     * @return favorite|bool
     */
    public static function verificaFavorit($userId, $produsId)
    {
        global $database;
        $sql = "SELECT * FROM " . static::$table . " WHERE user_id = '" . $database->escape($userId) . "' AND product_id = '" . $database->escape($produsId) . "'";

        $result = static::get_custom($sql);
        if ($result) {
            return $result[0];
        } else {
            return FALSE;
        }
    }

    /**
     * @param $userId
     * @return array|bool
     */
    public static function getFavorites($userId)
    {
        global $database;
        $sql = "SELECT * FROM " . static::$table . " WHERE user_id = '" . $database->escape($userId) . "'";

        $result = static::get_custom($sql);
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }
}