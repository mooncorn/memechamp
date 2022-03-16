<?php 

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

class UserController
{
    // Show the user attributes based on the session id
	public function profile(int $id, RouteCollection $routes, RequestContext $context)
	{
        global $db;

        $user = new User($db);

        if ($user->load('id', $id)) {
            require_once APP_ROOT . '/views/Profile.php';
        } else {
            // redirect to login page if not logged in
            header('Location: ' . $routes->get('homepage')->getPath());
        }
	}

    public function signup(RouteCollection $routes, RequestContext $context)
    {
        global $db;
        $errors = array();

        if (!empty($_POST)) {
            $username = filter_input(INPUT_POST, 'username');
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

            // check required fields
            if (!$username) {
                $errors["username"] = "Username is required";
            }
            if (!$email) {
                $errors["email"] = "Email is invalid";
            }
            if (!$password) {
                $errors["password"] = "Password is required";
            }

            // check unique fields
            if (!isset($errors['email'])) {
                if (User::exists($db, 'email', $email)) {
                    $errors['email'] = 'Email is taken';
                }
            }
            if (!isset($errors['username'])) {
                if (User::exists($db, 'username', $username)) {
                    $errors['username'] = "Username is taken";
                }
            }

            if (empty($errors)) {
                $user = new User($db);
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword($password);

                // Handle profile picture upload
                if (!empty($_FILES['pfp']['name'])) {
                    $targetDir = APP_ROOT . '/public/images/uploads/pfps';
                    $fileName = basename($_FILES['pfp']['name']);
                    $fileType = pathinfo($fileName,PATHINFO_EXTENSION);
                    $date = date('Y-m-d');
                    $time = time();
                    $rand = rand();
                    $newFileName = $date . '-' . $time . '-' . $rand . '.' . $fileType;
                    $targetFilePath = $targetDir . '/' . $newFileName; // ok

                    // Allow certain file formats
                    $allowTypes = array('jpg','png','jpeg');
                    if(in_array($fileType, $allowTypes)) {
                        // Upload file to server
                        if(move_uploaded_file($_FILES["pfp"]["tmp_name"], $targetFilePath)){
                            // Insert image file name into database
                            $user->setPfp($newFileName);

                        }
                    }
                    else {
                        $errors['pfp'] = 'Only JPG, JPEG & PNG files are allowed';
                    }
                }

                $user->save();

                // add user info to the current session
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['id'] = $user->getId();

                // redirect to homepage
                header('Location: ' . $routes->get('homepage')->getPath());
            }
        }

        require_once APP_ROOT . '/views/Signup.php';
    }

    public function signin(RouteCollection $routes, RequestContext $context)
    {
        $errors = array();

        if (!empty($_POST)) {
            $username = filter_input(INPUT_POST, 'username');
            $password = filter_input(INPUT_POST, 'password');

            // check required fields
            if (!$username) {
                $errors["username"] = "Username is required";
            }
            if (!$password) {
                $errors["password"] = "Password is required";
            }

            if (empty($errors)) {
                global $db;
                $user = new User($db);
                $user->load('username', $username);

                if ($user->isLoaded()) {
                    if ($user->getPassword() == $password) {
                        // add user info to the current session
                        $_SESSION['username'] = $user->getUsername();
                        $_SESSION['id'] = $user->getId();

                        // redirect to homepage
                        header('Location: ' . $routes->get('homepage')->getPath());
                    } else {
                        $errors["main"] = "Invalid credentials";
                    }
                } else {
                    $errors["main"] = "Invalid credentials";
                }
            }
        }

        require_once APP_ROOT . '/views/Signin.php';
    }

    public function signout(RouteCollection $routes, RequestContext $context)
    {
        unset($_SESSION['id']);
        unset($_SESSION['username']);

        header('Location: ' . $routes->get('homepage')->getPath());
    }
}