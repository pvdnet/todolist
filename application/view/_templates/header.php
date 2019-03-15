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
</head>
<body>
    <!-- logo, check the CSS file for more info how the logo "image" is shown -->
    <div class="logo">To-do-list.Local</div>

    <!-- navigation -->
    <div class="navigation">
        <a href="<?php echo URL; ?>">home</a>
    
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