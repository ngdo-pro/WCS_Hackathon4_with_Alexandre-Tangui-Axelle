<?php

namespace MigrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MigrationBundle:Default:index.html.twig');
    }
}
