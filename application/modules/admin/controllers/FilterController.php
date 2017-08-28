<?php
/**
 * Created by PhpStorm.
 * User: gvalero
 * Date: 28/08/2017
 * Time: 16:26
 */

class Admin_FilterController extends Genius_AbstractController
{
    public function init()
    {

    }

    public function indexAction()
    {
        var_dump('admin.index');
    }

    public function imprimanteAction()
    {
        var_dump('admin.imprimante');
    }

    public function douchetteAction()
    {
        var_dump('admin.douchette');

    }

    public function terminalAction()
    {
        var_dump('admin.terminal');
        die();

    }
}