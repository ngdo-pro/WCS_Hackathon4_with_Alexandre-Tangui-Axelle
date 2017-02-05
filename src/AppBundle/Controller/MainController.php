<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Occurence;
use AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    public function indexAction(Request $request)
    {

        /** @var Form $form */
        $form = $this->createFormBuilder()
            ->add('keyword1', TextType::class, array(
                'label' => 'Mot-clé n°1',
                'attr'  => array(
                    'class' => 'autocomplete',
                    'id'    => 'searchField1',
                ),
                'required' => false
            ))
            ->add('keyword2', TextType::class, array(
                'label' => 'Mot-clé n°2',
                'attr'  => array(
                    'class' => 'autocomplete',
                    'id'    => 'searchField2',
                ),
                'required' => false
            ))
            ->add('keyword3', TextType::class, array(
                'label' => 'Mot-clé n°3',
                'attr'  => array(
                    'class' => 'autocomplete',
                    'id'    => 'searchField3',
                ),
                'required' => false
            ))
            ->add('keyword4', TextType::class, array(
                'label' => 'Mot-clé n°4',
                'attr'  => array(
                    'class' => 'autocomplete',
                    'id'    => 'searchField4',
                ),
                'required' => false
            ))
            ->add('keyword5', TextType::class, array(
                'label' => 'Mot-clé n°5',
                'attr'  => array(
                    'class' => 'autocomplete',
                    'id'    => 'searchField5',
                ),
                'required' => false
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $datas = $form->getData();
            $words = array();
            foreach ($datas as $data){
                if($data != null){
                    $words[] = $data;
                }
            }
            $alljobs = $this->getDoctrine()->getRepository('AppBundle:Occurence')->findjobs($words);
            $nbword = count($words);
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
            $result=[];
            foreach($sortings as $key => $value){
                if($value == $nbword){
                    $result[]=$key;
                }
            }
            return $this->render('app/main/results.html.twig', array(
                'results' => $result
            ));
        }


        return $this->render('app/main/index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function wordAutocompleteAction(Request $request)
    {
        $keyword = $request->request->get('keyword');
        $em = $this->getDoctrine()->getManager();
        $words = $em->getRepository(Word::class)->searchWords($keyword);

        return new JsonResponse($words);
    }
}
