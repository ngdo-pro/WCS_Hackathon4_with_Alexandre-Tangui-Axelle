<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Occurence;
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
        $words = $em->getRepository(Word::class)->findBy(array('tag' => "Créativité"));
        $formatted = array();
        foreach ($words as $word){
            /** @var Occurence $occurence */
            foreach ($word->getOccurences() as $occurence){
                $formatted[] = $occurence->getProfession()->getName();
            }
        }
        return new JsonResponse($formatted);
    }
}
