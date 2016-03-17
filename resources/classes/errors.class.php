<?php

/**
 * Class errors
 */
class errors
{
    /**
     * @var bool
     */
    private $result = true;
    /**
     * @var array
     */
    private $errors = array();

    /**
     * @param $name
     * @param $variable
     * @param $message
     */
    public function check_null($name, $variable, $message)
    {
        $variable = str_replace(' ', '', $variable);
        if ($variable == '') {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $variable
     * @param $min
     * @param $message
     */
    public function check_min_string($name, $variable, $min, $message)
    {
        if (strlen($variable) < $min) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $variable
     * @param $max
     * @param $message
     */
    public function check_max_string($name, $variable, $max, $message)
    {
        if (strlen($variable) > $max) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $email
     * @param $message
     */
    public function check_email($name, $email, $message)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $value1
     * @param $value2
     * @param $message
     */
    public function check_match($name, $value1, $value2, $message)
    {
        if ($value1 != $value2) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $variable
     * @param $min
     * @param $message
     */
    public function check_min_number($name, $variable, $min, $message)
    {
        if ((float)$variable < (float)$min) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $variable
     * @param $min
     * @param $message
     */
    public function check_max_number($name, $variable, $min, $message)
    {
        if ((float)$variable > (float)$min) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $value
     * @param $message
     */
    public function checkNumeric($name, $value, $message)
    {
        if (!is_numeric($value)) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $day
     * @param $month
     * @param $year
     * @param $message
     */
    public function checkDate($name, $day, $month, $year, $message)
    {
        if (!checkdate($month, $day, $year)) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $message
     */
    public function add_error($name, $message)
    {
        $this->result = false;
        $this->errors[$name] = $message;
    }

    /**
     * @param $name
     * @param $value
     * @param $message
     */
    public function checkUrl($name, $value, $message)
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->result;
    }

    /**
     * @param $name
     * @param $value
     * @param $message
     */
    public function checkUsername($name, $value, $message)
    {
        if (!preg_match('/^[A-Za-z0-9_]+$/', $value)) {
            $this->add_error($name, $message);
        }
    }

    /**
     * @param $name
     * @param $value
     * @param $message
     */
    public function checkBirthday($name, $value, $message)
    {
        if (!preg_match('/^[12]\d{3}-\d{2}-\d{2}$/', $value)) {
            $this->add_error($name, $message);
        } else {
            $data = explode('-', $value);
            if ((int)$data[0] >= date('Y') - 9) {
                $this->add_error($name, $message);
            } else {
                $this->checkDate($name, $data[2], $data[1], $data[0], $message);
            }
        }
    }
}
