<?php
class auth{
    public function signup($conf, $ObjFncs){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])){

        $errors = array();

        $fullname = $_SESSION['fullname'] = ucwords(strtolower($_POST['fullname']));
        $email = $_SESSION['email'] = strtolower($_POST['email']);
        $password = $_SESSION['password'] = $_POST['password'];

            if(empty($fullname) || !preg_match("/^[a-zA-Z ]*$/", $fullname)) {
                $errors['fullname_error'] = "Only letters and white space allowed in fullname";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['mailFormat_error'] = "Invalid email format";
            }

            $email_domain = substr(strrchr($email, "@"), 1);
            if (!in_array($email_domain, $conf['valid_email_domain'])) {
                $errors['mailDomain_error'] = "Email domain must be one of the following: " . implode(", ", $conf['valid_email_domain']);
            }

            if(strlen($password) < $conf['min_password_length']) {
                $errors['password_error'] = "Password must be at least " . $conf['min_password_length'] . " characters long";
            }

            if(!count($errors)){
                $ObjFncs->setMsg('msg', 'Signup successful! You can now log in.', 'success');
                unset($_SESSION['fullname']);
                unset($_SESSION['email']);
                unset($_SESSION['password']);
            } else {
                $ObjFncs->setMsg('errors', $errors, 'danger');
                $ObjFncs->setMsg('msg', 'Please fix the errors below and try again.', 'danger');
            }
    }
    }
}
