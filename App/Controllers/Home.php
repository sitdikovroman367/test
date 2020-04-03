<?php

namespace App\Controllers;

use App\Models\Region;
use App\Models\User;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function viewUserAction() {
        $userId = $_GET['user_id'];
        $user = User::getUserByID($userId);
        $pathTowm = [];
        $r = Region::getTerByID($user['ter_id']);
        array_push($pathTowm, $r);
        if($r['ter_level'] > 1) {
            $r = Region::getTerByID( $r['ter_pid']);
            array_push($pathTowm, $r);
            if($r['ter_level'] > 1) {
                $r = Region::getTerByID( $r['ter_pid']);
                array_push($pathTowm, $r);
                if($r['ter_level'] > 1) {
                    $r = Region::getTerByID( $r['ter_pid']);
                    array_push($pathTowm, $r);
                }
            }
        }

        View::renderTemplate('Home/view_user.html', [
            'user' =>  $user,
            'pathTowm' => $pathTowm,
        ]);


    }
    public function indexAction()
    {

        if(isset($_POST['reg_submit'])) {
            if($user = User::existByEmail($_POST['email'])) {
                header('Location: /home/viewUser?user_id='.$user['id']);
                exit;
            }
            if($user_id = User::createUser($_POST['fio'], $_POST['email'], $_POST['ter_id'])){
                header('Location: /home/viewUser?user_id='.$user_id);
                exit;
            }
        }
        View::renderTemplate('Home/register.html', [
            'obl_arr' =>  Region::getObl()
        ]);
    }
}
