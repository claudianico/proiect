<?php

/**
 * @param $url
 */
function relocate($url)
{
    header("Location: " . $url);
    die();
}

/**
 * @param $variable
 */
function debug($variable)
{
    echo '<pre>';
    print_r($variable);
    echo '</pre>';
}

/**
 * @param $text
 * @param $nr
 * @return string
 */
function custom_substr($text, $nr)
{
    if (strlen($text) > $nr) {
        $text = substr($text, 0, $nr - 3) . '...';
    }

    return $text;
}

/**
 * @param $file
 * @return mixed
 */
function getExtension($file)
{
    $ext = explode('.', $file);
    $last = count($ext) - 1;

    return $ext[$last];
}

/**
 * @param $text
 * @param string $char
 * @return mixed|string
 */
function parse_link($text, $char = '-')
{
    $text = strtolower($text);
    $not_allowed = " /[]-{}\'\\|\"?><,.~`!@#$%^&*()_+=-";
    for ($i = 0; $i < strlen($not_allowed); $i++) {
        $text = str_replace($not_allowed[$i], $char, $text);
    }

    return $text;
}

/**
 * @return bool
 */
function is_logged()
{
    global $variables;
    if (isset($variables->session->user)) {
        return true;
    } else {
        return false;
    }
}

/**
 * @return bool
 */
function admin_is_logged()
{
    global $variables;
    if (isset($variables->session->admin)) {
        return true;
    } else {
        return false;
    }
}