<?php 

namespace App\Controllers;

use App\Helpers\Auth;
use App\Models\User;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

class UserController
{
    // Show user attributes based on the id provided in the url
	public function profile(int $id, RouteCollection $routes, RequestContext $context)
	{
        $user = new User();

        if ($user->load('id', $id)) {
            require_once APP_ROOT . '/views/Profile.php';
        } else {
            // redirect to login page if not logged in
            header('Location: ' . $routes->get('homepage')->getPath());
        }
	}

    public function signup(RouteCollection $routes, RequestContext $context)
    {
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
                if (User::exists('email', $email)) {
                    $errors['email'] = 'Email is taken';
                }
            }
            if (!isset($errors['username'])) {
                if (User::exists('username', $username)) {
                    $errors['username'] = "Username is taken";
                }
            }

            if (empty($errors)) {
                $user = User::build($username, $email, $password)->save();

                // add user info to the current session
                Auth::setSession(['username' => $user->getUsername(), 'id' => $user->getId()]);

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
                $user = new User();
                $user->load('username', $username);

                // if user with provided username was found
                if ($user->isLoaded()) {
                    // verify if the passwords match
                    if ($user->getPassword() == $password) {
                        // add user info to the current session
                        Auth::setSession(['username' => $user->getUsername(), 'id' => $user->getId()]);

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
        Auth::clearSession();

        header('Location: ' . $routes->get('homepage')->getPath());
    }

    public function edit_profile(int $id, RouteCollection $routes, RequestContext $context) {
        $errors = array();
        $messages = array();

        // handle username update only if current user has permission
        if (Auth::isOwner($id)) {

            $user = new User();
            $user->load('id', $id);

            // handle username update
            if (isset($_POST['username'])) {
                $username = filter_input(INPUT_POST, 'username');

                // check if username passed filter
                if ($username) {
                    // check if username is unique
                    if (!User::exists('username', $username)) {
                        $user->setUsername($username);
                        $user->save();

                        Auth::setSession(['username' => $username]);

                        $messages['username'] = 'Username updated successfully';
                    } else {
                        $errors['username'] = 'Username is taken';
                    }
                } else {
                    $errors['username'] = 'Username is required';
                }
            }

            // TODO: refactor this eventually
            // handle pfp update
            if (!empty($_FILES)) {
                if (!empty($_FILES['pfp']['name'])) {
                    $targetDir = APP_ROOT . '/public/images/uploads/pfps';
                    $fileName = basename($_FILES['pfp']['name']);
                    $fileType = pathinfo($fileName,PATHINFO_EXTENSION);
                    $date = date('Y-m-d');
                    $time = time();
                    $rand = rand();
                    $newFileName = $date . '-' . $time . '-' . $rand . '.' . $fileType;
                    $targetFilePath = $targetDir . '/' . $newFileName;

                    // Allow certain file formats
                    $allowTypes = array('jpg','png','jpeg');
                    if(in_array($fileType, $allowTypes)) {
                        // Upload file to server
                        if(move_uploaded_file($_FILES["pfp"]["tmp_name"], $targetFilePath)){
                            // Insert image file name into database
                            $user->setPfp($newFileName);
                            $user->save();
                            $messages['pfp'] = 'Profile picture updated successfully';
                        }
                    } else {
                        $errors['pfp'] = 'Only JPG, JPEG & PNG files are allowed';
                    }
                } else {
                    $errors['pfp'] = 'Image is required';
                }
            }

            require_once APP_ROOT . '/views/EditProfile.php';
        } else {
            require_once APP_ROOT . '/views/Unauthorized.php';
        }
    }
}