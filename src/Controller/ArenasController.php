<?php
namespace App\Controller;
use App\Controller\AppController;
/**
* Personal Controller
* User personal interface
*
*/
class ArenasController  extends AppController
{
	public function toto()
	{
	// die('test');
	}

    public function index()
    {
    	$this->set('myname', "JP Vielma");
    	$this->loadModel('Fighters');
		$figterlist=$this->Fighters->find('all');
		pr($figterlist->toArray());
        pr($this->Fighters->getBestFighter());
    }

    public function login()
    {

    }

    public function fighter()
    {

    }

    public function sight()
    {

    }

    public function diary()
    {

    }
}