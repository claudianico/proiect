<?php

/**
 * Class table
 */
class table
{
    /**
     * @var string
     */
    protected static $table;

    /**
     * @param $id
     * @return bool
     */
    public static function get_by_id($id)
    {
        global $database;
        $sql = "SELECT * FROM " . static::$table . " WHERE id = '" . $database->escape($id) . "'";
        $result = $database->execute($sql);
        $c = $result->fetch_object();
        if ($c) {
            $class_name = get_called_class();
            $object = new $class_name;
            foreach ($c as $attribute => $value) {
                if ($object->has_attribute($attribute)) {
                    $object->$attribute = $value;
                }
            }
            return $object;
        } else {
            return FALSE;
        }
    }

    /**
     * @return array|bool
     */
    public static function get_all()
    {
        global $database;
        $sql = "SELECT * FROM " . static::$table;
        $result = $database->execute($sql);
        $return = array();
        while ($c = $result->fetch_object()) {
            $return[] = $c;
        }
        if (count($return) > 0) {
            return $return;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $sql
     * @return array|bool
     */
    public static function get_custom($sql)
    {
        global $database;
        $result = $database->execute($sql);
        $return = array();
        while ($c = $result->fetch_object()) {
            $return[] = $c;
        }
        if (count($return) > 0) {
            return $return;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $attribute
     * @return bool
     */
    private function has_attribute($attribute)
    {
        return array_key_exists($attribute, $this->attributes());
    }

    /**
     * @return array
     */
    protected function attributes()
    {
        $attributes = array();
        foreach (static::$fields as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public static function check_if_exists($key, $value)
    {
        global $database;
        $sql = "SELECT * FROM " . static::$table . " WHERE '" . $database->escape($key) . "' = '" . $database->escape($value) . "'";
        $result = $database->execute($sql);
        $c = $result->fetch_object();
        if ($c) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return bool
     */
    public function create()
    {
        global $database;
        $sql = "INSERT INTO " . static::$table . " SET ";
        $attributes = $this->attributes();
        foreach ($attributes as $key => $value) {
            $sql .= "`" . $key . "` = '" . $database->escape($value) . "',";
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        if ($database->execute($sql)) {
            $this->id = $database->get_insert_id();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @return bool
     */
    public function update()
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

    /**
     * @return bool
     */
    public function delete()
    {
        global $database;
        $sql = "DELETE FROM " . static::$table . " WHERE id = '" . $this->id . "'";

        if ($database->execute($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}