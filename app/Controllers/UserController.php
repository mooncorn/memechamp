<?php 

namespace App\Controllers;

use App\Helpers\Auth;
use App\Helpers\Routing;
use App\Models\Enums\GetUserBy;
use App\Models\User;
use App\Services\UserService;

class UserController
{
	public function profile(int $userId, string $tab)
    {
        $user = User::fetch($userId);

        if ($user)
        {
            require_once APP_ROOT . '/views/Profile.php';
        }
        else
        {
            require_once APP_ROOT . '/views/404.php';
        }
	}

    /**
     * @Route("/api/signup", name="handle_signup", method="POST")
     */
    public function signup()
    {
        $username = filter_input(INPUT_POST, 'username');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        if (UserService::signup($username, $email, $password))
        {
            Routing::redirectToPage('homepage');
        }
        else
        {
            Routing::redirectToCustomPage('signup', ['status'=>'rejected']);
        }
    }

    /**
     * @Route("/api/signin", name="handle_signin", method="POST")
     */
    public function signin()
    {
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        if (UserService::signin($username, $password))
        {
            Routing::redirectToPage('homepage');
        }
        else
        {
            Routing::redirectToCustomPage('signin', ['status'=>'rejected']);
        }
    }

    /**
     * @Route("/api/signout", name="handle_signout", method="GET")
     */
    public function signout()
    {
        Auth::clearSession();
        Routing::redirectToPage('homepage');
    }

    public function edit_profile(int $id)
    {
        $errors = array();
        $messages = array();

        // handle username update only if current user has permission
        if (Auth::isOwner($id))
        {
            $user = User::fetch($id);

            // handle username update
            if (isset($_POST['username']))
            {
                $username = filter_input(INPUT_POST, 'username');

                // check if username passed filter
                if ($username)
                {
                    // check if username is unique
                    if (!User::exists(GetUserBy::USERNAME, $username))
                    {
                        $user->setUsername($username);
                        $user->save();

                        Auth::setSession(['username' => $username]);

                        $messages['username'] = 'Username updated successfully';
                    }
                    else
                    {
                        $errors['username'] = 'Username is taken';
                    }
                }
                else
                {
                    $errors['username'] = 'Username is required';
                }
            }

            // TODO: refactor this eventually
            // handle pfp update
            if (!empty($_FILES))
            {
                if (!empty($_FILES['pfp']['name']))
                {
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
                    if(in_array($fileType, $allowTypes))
                    {
                        // Upload file to server
                        if(move_uploaded_file($_FILES["pfp"]["tmp_name"], $targetFilePath))
                        {
                            // Insert image file name into database
                            $user->setPfp($newFileName);
                            $user->save();
                            $messages['pfp'] = 'Profile picture updated successfully';
                        }
                    }
                    else
                    {
                        $errors['pfp'] = 'Only JPG, JPEG & PNG files are allowed';
                    }
                }
                else
                {
                    $errors['pfp'] = 'Image is required';
                }
            }

            require_once APP_ROOT . '/views/EditProfile.php';
        }
        else
        {
            require_once APP_ROOT . '/views/Unauthorized.php';
        }
    }
}