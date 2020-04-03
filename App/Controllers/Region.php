<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Region extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function getTerAction()
    {
       $ter_pid = $_GET['ter_pid'];
       $data = [];
       $data['terArr'] =  \App\Models\Region::getTerByPid($ter_pid);
       echo json_encode($data, JSON_UNESCAPED_UNICODE);die;
    }
}
