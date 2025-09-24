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
$ObjFncs = new fncs();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    // Validate and process signin
    $errors = [];
    
    // Get form data
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Store email in session for repopulation
    $_SESSION['email'] = $email;
    
    // Validate email
    if (empty($email)) {
        $errors['login_error'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['login_error'] = 'Invalid email format';
    }
    
    // Validate password
    if (empty($password)) {
        $errors['login_error'] = 'Password is required';
    }
    
    // If no errors, process signin
    if (empty($errors)) {
        // TODO: Add your database authentication logic here
        // For now, we'll simulate authentication
        
        // Check if credentials are valid (replace with actual database check)
        $valid_email = 'user@example.com'; // Example valid email
        $valid_password = 'password123';   // Example valid password
        
        if ($email === $valid_email && $password === $valid_password) {
            // Clear session data
            unset($_SESSION['email']);
            
            // Set success message and user session
            $_SESSION['user'] = $email;
            $ObjFncs->setMsg('msg', 'Welcome back! You have successfully signed in.', 'success');
            
            // Redirect to dashboard or homepage
            header('Location: index.php');
            exit;
        } else {
            $errors['login_error'] = 'Invalid email or password';
            $ObjFncs->setMsg('errors', $errors, '');
            $ObjFncs->setMsg('msg', 'Invalid credentials. Please try again.', 'danger');
        }
    } else {
        // Set error messages
        $ObjFncs->setMsg('errors', $errors, '');
        $ObjFncs->setMsg('msg', 'Please fix the errors below.', 'danger');
    }
}

// Call layout methods
$ObjLayout->header($conf);
$ObjLayout->navbar($conf);
$ObjLayout->banner($conf);
$ObjLayout->form_content($conf, $ObjForm, $ObjFncs);
$ObjLayout->footer($conf);
