<?php
class fncs {
    private $messages = [];

    public function setMsg($key, $msg, $class = '') {
        $this->messages[$key] = ['msg' => $msg, 'class' => $class];
        $_SESSION[$key] = $this->messages[$key];
    }

    public function getMsg($key) {
        if(isset($_SESSION[$key])) {
            $data = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $data;
        }
        return null;
    }
}
