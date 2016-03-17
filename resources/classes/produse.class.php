<?php

/**
 * Class produse
 */
class produse extends table
{
    /**
     * @var string
     */
    protected static $table = 'produse';

    /**
     * @var array
     */
    protected static $fields = array('id', 'nume', 'descriere', 'imagine', 'pret', 'created', 'modified');

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
    public $descriere;

    /**
     * @var string
     */
    public $imagine;

    /**
     * @var string
     */
    public $pret;

    /**
     * @var string
     */
    public $created;

    /**
     * @var string
     */
    public $modified;

    public  function update()
    {
        global $database;
        $sql = "UPDATE " . static::$table . " SET ";
        $attributes = $this->attributes();
        foreach ($attributes as $key => $value) {
            $sql .= "`" . $key . "` = '" . $database->escape($value) . "',";
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        $sql .= " WHERE id = '" . $this->id . "'";
        if ($database->execute($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}