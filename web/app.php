<?php
require_once '../app/parameters.php';

function __autoload($class_name) {
    $path = '../src/'.str_replace('\\', '/', $class_name) . '.php';
    if(file_exists($path)) include $path;
}

$actions = [
    'home' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/Home.php';
    },
    'chat' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/Chat.php';
    },
    'go' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::go();
    },
    'send' => function() {
        Mondo\SocialNetworkBundle\Controller\ChatController::send();
    },
    'upload_photo' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::uploadPhoto();
    },
    'user_table' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/UserTable.php';
    },
    'messages' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/Messages.php';
    },
    'notify' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::notify();
    },
    'logout' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::logout();
    },
    'account_settings' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/AccountSettings.php';
    },
    'profile_image' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::profileImage($_GET['user']);
    },
    'profile' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/Profile.php';
    },
    'change_password' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/ChangePassword.php';
    },
    'account_update' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::accountUpdate();
    },
    'update_password' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::updatePassword();
    },
    'reset_after' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::resetAfter();
    },
    'prepare_reset' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::prepareReset($_GET['code']);
    },
    'verify' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::verify($_GET['id']);
    },
    'verify_after' => function() {
        Mondo\SocialNetworkBundle\Controller\UserController::verifyAfter($_GET['code']);
    },
    'reset_view' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/ResetPassword.php';
    },
    'reset_password' => function() {
        if(isset($_GET['email'])) $email = $_GET['email'];
        else $email = $_POST['email'];
        Mondo\SocialNetworkBundle\Controller\UserController::resetPassword($email);
    },
    'search' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/Search.php';
    },
    'ajax_query' => function() {
        Mondo\UtilBundle\Core\DB::ajaxQuery(urldecode($_GET['query']), json_decode(urldecode($_GET['args']), true));
    },
    'forgot_password' => function() {
        include '../src/Mondo/SocialNetworkBundle/View/ForgotPassword.php';
    }
];

if(!isset($_GET['action'])) $action = 'home';
else $action = $_GET['action'];
Mondo\SocialNetworkBundle\Controller\UserController::autoGo($action);
$actions[$action]();
