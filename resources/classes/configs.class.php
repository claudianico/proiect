<?php

/**
 * Class configs
 */
class configs extends table
{
    /**
     * @var string
     */
    protected static $table = 'configs';

    /**
     * @var array
     */
    protected static $fields = array('id', 'variable', 'value', 'description');

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $variable;

    /**
     * @var string
     */
    public $value;

    /**
     * @var string
     */
    public $description;
}