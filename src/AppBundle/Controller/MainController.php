<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Occurence;
use AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('app/main/index.html.twig');
    }

    public function wordAutocompleteAction(Request $request)
    {
        $formatted = $request->request->get('keyword');



        return new JsonResponse($formatted);
    }
}
