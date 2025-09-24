<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load configuration
require 'conf.php';

// Load class files
require 'Forms/forms.php';
require 'Layouts/layouts.php';
require 'Global/fncs.php';

// Instantiate objects
$ObjLayout = new Layouts();
$ObjForm = new forms();
$ObjFncs = new fncs(); // Changed to match your class name

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    // Validate and process signup
    $errors = [];
    
    // Get form data
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Store form data in session for repopulation
    $_SESSION['fullname'] = $fullname;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    
    // Validate fullname
    if (empty($fullname)) {
        $errors['fullname_error'] = 'Full name is required';
    } elseif (strlen($fullname) > 50) {
        $errors['fullname_error'] = 'Full name must be less than 50 characters';
    }
    
    // Validate email
    if (empty($email)) {
        $errors['mailFormat_error'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['mailFormat_error'] = 'Invalid email format';
    }
    
    // Validate password
    if (empty($password)) {
        $errors['password_error'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password_error'] = 'Password must be at least 6 characters';
    }
    
    // If no errors, process signup
    if (empty($errors)) {
        // TODO: Add your database insertion logic here
        // For now, we'll simulate a successful signup
        
        // Clear session data
        unset($_SESSION['fullname'], $_SESSION['email'], $_SESSION['password']);
        
        // Set success message
        $ObjFncs->setMsg('msg', 'Account created successfully! You can now sign in.', 'success');
        
        // Redirect to signin page
        header('Location: signin.php');
        exit;
    } else {
        // Set error messages
        $ObjFncs->setMsg('errors', $errors, ''); // Empty class since we're storing array
        $ObjFncs->setMsg('msg', 'Please fix the errors below.', 'danger');
    }
}

// Call layout methods
$ObjLayout->header($conf);
$ObjLayout->navbar($conf);
$ObjLayout->banner($conf);
$ObjLayout->form_content($conf, $ObjForm, $ObjFncs);
$ObjLayout->footer($conf);
