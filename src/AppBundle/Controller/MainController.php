<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction($words)
    {
        $alljobs = $this->getDoctrine()->getRepository('AppBundle:Occurence')->findjobs($words);
        var_dump($alljobs);
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

    public function backAction(){
        $stats = $this->getDoctrine()->getRepository('AppBundle:Stat')->findAll();
        $statstreated = [];
        foreach ($stats as $stat){
            $statstreated[$stat->getType()][] = $stat;
        }
        //  var_dump($statstreated);
        return $this->render('app/main/back.html.twig',
            array('stats' => $statstreated,
            'title' =>''));
    }

    public function back1Action(){
        $types = ['domain20-global', 'job20-global', 'word20-global' ];
        $stats = $this->getDoctrine()->getRepository('AppBundle:Stat')->findAll();
        $statstreated = [];
        foreach ($stats as $stat){
            if(in_array($stat->getType(),$types)){
                $statstreated[$stat->getType()][] = $stat;
            }
        }

        return $this->render('app/main/back.html.twig',
            array('stats' => $statstreated,
                'title' =>'Statistiques globales des votes'));

    }

    public function back2Action(){
        $types = ['domain20-H', 'job20-H', 'word20-H','domain20-F', 'job20-F', 'word20-F' ];
        $stats = $this->getDoctrine()->getRepository('AppBundle:Stat')->findAll();
        $statstreated = [];
        foreach ($stats as $stat){
            if(in_array($stat->getType(),$types)){
                $statstreated[$stat->getType()][] = $stat;
            }
        }

        return $this->render('app/main/back.html.twig',
            array('stats' => $statstreated,
                'title' =>'Classement par sexe'));

    }

    public function back3Action(){
        $types = ['domain20-Collégien', 'job20-Collégien', 'word20-Collégien','domain20-Lycéen', 'job20-Lycéen', 'word20-Lycéen','domain20-Etudiant', 'job20-Etudiant', 'word20-Etudiant' ];
        $stats = $this->getDoctrine()->getRepository('AppBundle:Stat')->findAll();
        $statstreated = [];
        foreach ($stats as $stat){
            if(in_array($stat->getType(),$types)){
                $statstreated[$stat->getType()][] = $stat;
            }
        }

        return $this->render('app/main/back.html.twig',
            array('stats' => $statstreated,
                'title' =>'Classement pour les collégien, lycéen et étudiant'));

    }

    public function back4Action(){
    $types = ['domain20-Demandeur d\'emploi', 'job20-Demandeur d\'emploi', 'word20-Demandeur d\'emploi','domain20-Adulte en réorientation', 'job20-Adulte en réorientation', 'word20-Adulte en réorientation','domain20-Salarié', 'job20-Salarié', 'word20-Salarié', 'domain20-Autre', 'job20-Autre', 'word20-Autre' ];
        $stats = $this->getDoctrine()->getRepository('AppBundle:Stat')->findAll();
        $statstreated = [];
        foreach ($stats as $stat){
            if(in_array($stat->getType(),$types)){
                $statstreated[$stat->getType()][] = $stat;
            }
        }

        return $this->render('app/main/back.html.twig',
            array('stats' => $statstreated,
                'title' =>'Classement pour les demandeur d\'emploi, adulte en réorientation et salarié'));

    }

    public function back5Action(){
        $types = ['domain20-0-16', 'job20-0-16', 'word20-0-16','domain20-17-20', 'job20-17-20', 'word20-17-20', 'domain20-21-25', 'job20-21-25', 'word20-21-25' ];
        $stats = $this->getDoctrine()->getRepository('AppBundle:Stat')->findAll();
        $statstreated = [];
        foreach ($stats as $stat){
            if(in_array($stat->getType(),$types)){
                $statstreated[$stat->getType()][] = $stat;
            }
        }

        return $this->render('app/main/back.html.twig',
            array('stats' => $statstreated,
                'title' =>'Classement par age pour les -16ans, 17-20ans et 21-25ans'));

    }

    public function back6Action(){
        $types = ['domain20-26-35', 'job20-26-35', 'word20-26-35','domain20-36-45', 'job20-36-45', 'word20-36-45'];
        $stats = $this->getDoctrine()->getRepository('AppBundle:Stat')->findAll();
        $statstreated = [];
        foreach ($stats as $stat){
            if(in_array($stat->getType(),$types)){
                $statstreated[$stat->getType()][] = $stat;
            }
        }

        return $this->render('app/main/back.html.twig',
            array('stats' => $statstreated,
                'title' =>'Classement par age pour les 26-35ans, 36-45ans et plus'));

    }
}
