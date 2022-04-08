<?php

/**
 * @var Post $post
 * @var User $user
 */

use App\Models\Post;
use App\Models\User;

?>

<?php echo $post->getTitle()?>
<?php echo $post->getCreatedAt()?>
<?php echo $user->getUsername()?>
<?php echo $post->getImg()?>
<?php echo $user->getPfp()?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= '/' . constant('URL_SUBFOLDER').'/public/css/style.css'?>">

    <!-- Font for Post Title -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300;1,400&family=Roboto&display=swap" rel="stylesheet">

    <title> Memechamps </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <div class="row main-row p-2">
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="blog-img">
                    <img src="<?= '/' . constant('URL_SUBFOLDER').'/public/images/uploads/pfps/defaultpfp.jpg'?>" alt="Post Image" class="img-fluid">
                </div>
                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <ul class="list-group list-group-horizontal ul-cls">
                            <li class="list-group-item btm=n btn-outline-dark">
                                <i class="fa fa-line-chart fa-2x" aria-hidden="true"></i>
                            </li>
                            <li class="list-group-item btm=n btn-outline-dark">
                                <i class="fa fa fa-bullhorn fa-2x" aria-hidden="true"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="blog-title mb-3">
                    <div style="display: inline;">
                        <h3 style="display: inline;"> <?php echo $user->getUsername()?> </h3>
                        <img style="border-radius: 50%;width: 50px;justify-content: center" src="<?= '/' . constant('URL_SUBFOLDER').'/public/images/uploads/pfps/2022-03-16-1647440100-126450285.jpg'?>" alt="User pfp" class="img-fluid">
                    </div>
                </div>
                <div class="blog-date mb-2" >
                    <span class="date">Date Posted: <?php echo $post->getCreatedAt()?> </span>
                </div>
                <div class="blog-des mb-2">
                    <span style="font-family: 'Cormorant Garamond', serif;"><h2> <?php echo $post->getTitle()?> </h2> </span>
                </div>
                <div class="blog-read-more mb-2">
                    <button class="btm=n btn-outline-dark">Comment</button>
                </div>
            </div>
        </div>
    </div>
</body>
