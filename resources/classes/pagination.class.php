<?php

/**
 * Class pagination
 */
class pagination
{
    /**
     * @var int
     */
    public $page = 1;
    /**
     * @var int
     */
    public $per_page = 6;
    /**
     * @var int
     */
    public $total_entries = 0;
    /**
     * @var string
     */
    private $sql;
    /**
     * @var string
     */
    public $separator = '...';
    /**
     * @var array
     */
    public $controls = array('&lsaquo;', '&rsaquo;');

    /**
     * @param $sql
     */
    public function sql($sql)
    {
        global $database;
        $this->sql = $sql;
        $return = $database->execute($sql);
        $result = array();
        while ($c = $return->fetch_object()) {
            $result[] = $c;
        }
        $this->total_entries = count($result);
        $this->validate_page();
        $this->sql .= " LIMIT " . $this->start_page() . ", " . $this->per_page;
    }

    /**
     * @return int
     */
    private function start_page()
    {
        return ($this->page - 1) * $this->per_page;
    }

    /**
     * @return float
     */
    public function get_total_pages()
    {
        return ceil($this->total_entries / $this->per_page);
    }

    /**
     *
     */
    private function validate_page()
    {
        if ((int)$this->page < 1) {
            $this->page = 1;
        }
        $pages = (int)$this->get_total_pages();
        if ((int)$this->page > $pages && $pages != 0) {
            $this->page = $this->get_total_pages();
        }
    }

    /**
     * @return array
     */
    public function getResults()
    {
        global $database;
        $return = $database->execute($this->sql);
        $result = array();
        while ($c = $return->fetch_object()) {
            $result[] = $c;
        }
        return $result;
    }

    /**
     * @param $format
     * @return string
     */
    public function paginate($format)
    {
        $output = '';
        $extra_pages = 2;
        if ($this->get_total_pages() >1 ) {
            $output = '<ul class="pagination">';
            $total_pages = $this->get_total_pages();
            $start = ($this->page - $extra_pages) < 1 ? 1 : $this->page - $extra_pages;
            $end = ($this->page + $extra_pages) > $total_pages ? $total_pages : $this->page + $extra_pages;
            if ($start < 1) {
                $diff = 5 - $end;
                $end += $diff;
                $start += $diff;
            }
            if ($end > $total_pages) {
                $diff = $end - $total_pages;
                $end -= $diff;
                $start -= $diff;
            }
            if ($this->page >1) {
                $previous = $this->page - 1;
                $output .= '<li><a class="pagination_unselected" href="' . str_replace('[%PAGE%]', $previous, $format) . '">' . $this->controls[0] . '</a></li>';
            }
            if ($start <= 2 && $this->page > 3) {
                $output .= '<li><a class="pagination_unselected" href="' . str_replace('[%PAGE%]', 1, $format) . '">1</a></li>';
            } elseif ($start > 2) {
                $output .= '<li><a class="pagination_unselected" href="' . str_replace('[%PAGE%]', 1, $format) . '">1</a></li><li>' . $this->separator . '</li>';
            }
            for ($i = $start; $i <= $end; $i++) {
                $output .= '<li>' . ($i == $this->page ?
                        '<span class="pagination_selected">' . $i . '</span>' :
                        '<a class="pagination_unselected" href="' . str_replace('[%PAGE%]', $i, $format) . '">' . $i . '</a>') . '
                    </li>';
            }
            if ($total_pages - $end > 1) {
                $output .= '<li>' . $this->separator . '</li><li><a class="pagination_unselected" href="' . str_replace('[%PAGE%]', $total_pages, $format) . '">' . $total_pages . '</a></li>';
            } elseif ($this->page < $total_pages - 2) {
                $output .= '<li><a class="pagination_unselected" href="' . str_replace('[%PAGE%]', $total_pages, $format) . '">' . $total_pages . '</a></li>';
            }
            if ($this->page < $total_pages) {
                $next = $this->page + 1;
                $output .= '<li><a class="pagination_unselected" href="' . str_replace('[%PAGE%]', $next, $format) . '">' . $this->controls[1] . '</a></li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }

    /**
     * @param $format
     * @return string
     */
    public function paginate_ajax($format)
    {
        $output = '';
        $extra_pages = 2;
        if ($this->get_total_pages() >1 ) {
            $output = '<ul class="pagination">';
            $total_pages = $this->get_total_pages();
            $start = ($this->page - $extra_pages) < 1 ? 1 : $this->page - $extra_pages;
            $end = ($this->page + $extra_pages) > $total_pages ? $total_pages : $this->page + $extra_pages;
            if ($start < 1) {
                $diff = 5 - $end;
                $end += $diff;
                $start += $diff;
            }
            if ($end > $total_pages) {
                $diff = $end - $total_pages;
                $end -= $diff;
                $start -= $diff;
            }
            if ($this->page >1) {
                $previous = $this->page - 1;
                $output .= '<li><a class="pagination_unselected" href="javascript: void(0);" onclick="' . str_replace('[%PAGE%]', $previous, $format) . '">' . $this->controls[0] . '</a></li>';
            }
            if ($start <= 2 && $this->page > 3) {
                $output .= '<li><a class="pagination_unselected" href="javascript: void(0);" onclick="' . str_replace('[%PAGE%]', 1, $format) . '">1</a></li>';
            } elseif ($start > 2) {
                $output .= '<li><a class="pagination_unselected" href="javascript: void(0);" onclick="' . str_replace('[%PAGE%]', 1, $format) . '">1</a></li><li>' . $this->separator . '</li>';
            }
            for ($i = $start; $i <= $end; $i++) {
                $output .= '<li>' . ($i == $this->page ?
                        '<span class="pagination_selected">' . $i . '</span>' :
                        '<a class="pagination_unselected" href="javascript: void(0);" onclick="' . str_replace('[%PAGE%]', $i, $format) . '">' . $i . '</a>') . '
                    </li>';
            }
            if ($total_pages - $end >1) {
                $output .= '<li>' . $this->separator . '</li><li><a class="pagination_unselected" href="javascript: void(0);" onclick="' . str_replace('[%PAGE%]', $total_pages, $format) . '">' . $total_pages . '</a></li>';
            } elseif ($this->page < $total_pages - 2) {
                $output .= '<li><a class="pagination_unselected" href="javascript: void(0);" onclick="' . str_replace('[%PAGE%]', $total_pages, $format) . '">' . $total_pages . '</a></li>';
            }
            if ($this->page < $total_pages) {
                $next = $this->page + 1;
                $output .= '<li><a class="pagination_unselected" href="javascript: void(0);" onclick="' . str_replace('[%PAGE%]', $next, $format) . '">' . $this->controls[1] . '</a></li>';
            }
            $output .= '</ul>';
        }
        return $output;
    }

    /**
     * @return mixed
     */
    public function getSQL()
    {
        return $this->sql;
    }
}