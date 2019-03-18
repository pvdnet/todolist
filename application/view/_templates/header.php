<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>To-do list</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <!-- logo, check the CSS file for more info how the logo "image" is shown -->
        <div class="logo">To-do-list.Local</div>

        <!-- navigation -->
        <div class="navigation">
            <a href="<?php echo URL; ?>">home</a>
            <a href="<?php echo URL; ?>checklist/index">Checklists</a>

            <?php 
            if($this->loggedIn()) {  //User is logged in. Show logged in menu.
            ?>

            <?php 
            }
            ?>

            <div class="right">
                <ul>
                    <li>
                        <?php if($this->loggedIn()) : ?>
                            <a href="<?php echo URL; ?>user/index">My account</a>
                            <ul class="navigation-submenu">
                                <li>
                                    <a href="<?php echo URL; ?>login/logout">Logout</a>
                                </li>
                            </ul>
                        <?php else : ?>
                            <a href="<?php echo URL; ?>login">Login/register</a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
    