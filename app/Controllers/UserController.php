<?php 

namespace App\Controllers;

use App\Models\Product;
use Symfony\Component\Routing\RouteCollection;

class UserController
{
  // Show the user attributes based on the id.
	public function showAction(int $id, RouteCollection $routes)
	{
        $user = new User();
        $user->load($id);

        // show view with user data
        require_once APP_ROOT . '/views/Profile.php';
	}
}