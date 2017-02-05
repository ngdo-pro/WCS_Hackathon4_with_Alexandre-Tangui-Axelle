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
    public function indexAction($words)
    {
        $alljobs = $this->getDoctrine()->getRepository('AppBundle:Occurence')->findjobs([9,200]);
        var_dump($alljobs);
        $nbword = 2; //count($words);
        $sortings = [];
        foreach ($alljobs as $key => $alljob){
            $jobname = $this->getDoctrine()->getRepository('AppBundle:Occurence')->find($alljob['id'])->getProfession()->getName();

            if (array_key_exists($jobname , $sortings)){
                $sortings[$jobname]++;
            }
            else
            {
             $sortings[$jobname]=1;
            }
        }
        var_dump($sortings);
        $result=[];
        foreach($sortings as $key => $value){
            if($value ==$nbword){
                $result[]=$key;
            }
        }
        var_dump($result);
        return $this->render('app/main/index.html.twig');
    }

    public function wordAutocompleteAction(Request $request)
    {
        $formatted = $request->request->get('keyword');



        return new JsonResponse($formatted);
    }
}
