<?php

/**
 * Class mails
 */
class mails
{
    /**
     * @var array
     */
    var $headers;
    /**
     * @var string
     */
    var $text;
    /**
     * @var string
     */
    var $html;
    /**
     * @var array
     */
    var $attachments;
    /**
     * @var string
     */
    var $to;
    /**
     * @var string
     */
    var $subject;
    /**
     * @var string
     */
    var $boundary;

    /**
     * mails constructor.
     */
    function __construct()
    {
        $this->attachments = array();
        $this->boundary = '_hion_mail_boundary_';
        $this->headers = array(
            'From' => 'No Reply <noreply@hion.ro>',
            'MIME-Version' => '1.0',
            'Content-Type' => "multipart/mixed; boundary=\"$this->boundary\""
        );
    }

    /**
     * @return string
     */
    function get_header()
    {
        $return_value = "";
        foreach ($this->headers as $key => $value) {
            $return_value .= "$key: $value\n";
        }

        return $return_value;
    }

    /**
     * @param $name
     * @param $value
     */
    function set_header($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * @param $file
     * @param string $type
     * @return int
     */
    function attachfile($file, $type = "application/octetstream")
    {
        if (!($fd = fopen($file, "r"))) {
            return 0;
        }
        $_buf = fread($fd, filesize($file));
        fclose($fd);
        $fname = $file;
        for ($x = strlen($file); $x > 0; $x--) {
            if ($file[$x] == "/") {
                $fname = substr($file, $x, strlen($file) - $x);
            }
        }
        $attach = chunk_split(base64_encode($_buf));
        $this->attachments[$file] = "\n--" . $this->boundary . "\n";
        $this->attachments[$file] .= "Content-Type: $type; name=\"$fname\"\n";
        $this->attachments[$file] .= "Content-Transfer-Encoding: base64\n";
        $this->attachments[$file] .= "Content-Disposition: attachment; " .
            "filename=\"$fname\"\n\n";
        $this->attachments[$file] .= $attach;

        return 1;
    }

    /**
     * @param $text
     */
    function body_text($text)
    {
        $this->text = "\n--" . $this->boundary . "\n";
        $this->text .= "Content-Type: text/plain\n";
        $this->text .= "Content-Transfer-Encoding: 7bit\n\n";
        $this->text .= $text;
    }

    /**
     * @param $text
     */
    function html_text($text)
    {
        $this->html = "\n--" . $this->boundary . "\n";
        $this->html .= "Content-Type: text/html\n";
        $this->html .= "Content-Transfer-Encoding: 7bit\n\n";
        $this->html .= $text;
    }

    /**
     *
     */
    function send()
    {
        $_body = '';
        if ($this->text != '') {
            $_body .= $this->text;
        }
        if ($this->html != '') {
            $_body .= $this->html;
        }
        foreach ($this->attachments as $file) {
            $_body .= $file;
        }
        $_body .= "\n--$this->boundary--";

        mail($this->to, $this->subject, $_body, $this->get_header());
    }
}