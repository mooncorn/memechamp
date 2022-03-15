<?php 

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

class UserController
{
  // Show the user attributes based on the id.
	public function showAction(int $id, RouteCollection $routes, RequestContext $context)
	{
        $user = new User();
        $user->setId($id);
        $user->setEmail('test@test.com');
        // global $_SESSION;
        // $username = $_SESSION["username"];
        print_r($_SESSION);

        // show view with user data
        require_once APP_ROOT . '/views/Profile.php';
	}
}