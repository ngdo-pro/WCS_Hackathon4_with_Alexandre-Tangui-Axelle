<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('app/main/index.html.twig');
    }

    public function wordAutocompleteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository(Word::class)->findAll();
        return new JsonResponse($tags);
    }
}
