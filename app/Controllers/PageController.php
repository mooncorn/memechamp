<?php 

namespace App\Controllers;

use App\Models\User;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

class PageController
{
	public function homepage()
	{
        $user = new User();
        $user->setUsername('john');
        $user->setPassword('john');
        $user->setEmail('john@gmail.com');
        $user->save();


        $user1 = new User();
        $user1->load('id', 1);
        $user->setUsername('changedtest');
        $user->save();


        require_once APP_ROOT . '/views/Feed.php';
	}
}