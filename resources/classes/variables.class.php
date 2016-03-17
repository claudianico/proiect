<?php

/**
 * Class variables
 */
class variables
{
    /**
     * @var stdClass
     */
    public $get;
    /**
     * @var stdClass
     */
    public $post;
    /**
     * @var stdClass
     */
    public $session;
    /**
     * @var stdClass
     */
    public $cookie;
    /**
     * @var stdClass
     */
    public $server;
    /**
     * @var stdClass
     */
    public $files;

    /**
     * @var string
     */
    public $path = '/';
    /**
     * @var string
     */
    public $domain;
    /**
     * @var bool
     */
    public $secure = FALSE;
    /**
     * @var bool
     */
    public $httponly = FALSE;

    /**
     * variables constructor.
     */
    function __construct()
    {
        $this->add_get_var();
        $this->add_post_var();
        $this->add_session_var();
        $this->add_cookie_var();
        $this->add_server_var();
        $this->add_files_var();
    }

    /**
     *
     */
    private function add_get_var()
    {
        $this->get = new stdClass();
        $get = filter_input_array(INPUT_GET);
        if (count($get) > 0) {
            foreach ($get as $key => $value) {
                $this->get->$key = $value;
            }
        }
    }

    /**
     *
     */
    private function add_post_var()
    {
        $this->post = new stdClass();
        $post = filter_input_array(INPUT_POST);
        if (count($post) > 0) {
            foreach ($post as $key => $value) {
                $this->post->$key = $value;
            }
        }
    }

    /**
     *
     */
    private function add_session_var()
    {
        $this->session = new stdClass();
        if (count($_SESSION) > 0) {
            foreach ($_SESSION as $key => $value) {
                $this->session->$key = $value;
            }
        }
    }

    /**
     *
     */
    private function add_cookie_var()
    {
        $this->cookie = new stdClass();
        $cookie = filter_input_array(INPUT_COOKIE);
        if (count($cookie) > 0) {
            foreach ($cookie as $key => $value) {
                $this->cookie->$key = $value;
            }
        }
    }

    /**
     *
     */
    private function add_server_var()
    {
        $this->server = new stdClass();
        $server = filter_input_array(INPUT_SERVER);
        foreach ($server as $key => $value) {
            $this->server->$key = $value;
        }
    }

    /**
     *
     */
    private function add_files_var()
    {
        $this->files = new stdClass();
        if (count($_FILES) > 0) {
            foreach ($_FILES as $key => $value) {
                $this->files->$key = $value;
            }
        }
    }

    /**
     * @param $name
     * @param $value
     * @param $days
     */
    public function add_cookie($name, $value, $days)
    {
        setcookie($name, $value, $days * 86400, $this->path, $this->domain, $this->secure, $this->httponly);
        $this->cookie->$name = $value;
    }

    /**
     * @param $name
     */
    public function remove_cookie($name)
    {
        setcookie($name, '', time() - 3600, $this->path, $this->domain, $this->secure, $this->httponly);
        unset($this->cookie->$name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function add_session($name, $value)
    {
        $_SESSION[$name] = $value;
        $this->session->$name = $value;
    }

    /**
     * @param $name
     */
    public function unset_session($name)
    {
        unset($_SESSION[$name]);
        unset($this->session->$name);
    }

    /**
     *
     */
    public function remove_all()
    {
        foreach ($this->cookie as $name => $value) {
            $value = '';
            setcookie($name, '', time() - 3600, $this->path, $this->domain, $this->secure, $this->httponly);
        }
        session_destroy();
        $this->cookie = new stdClass();
        $this->session = new stdClass();
    }
}

$variables = new variables();