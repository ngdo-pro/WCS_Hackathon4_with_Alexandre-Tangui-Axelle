<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 04/02/17
 * Time: 15:37
 */

namespace MigrationBundle\Command;


use AppBundle\Entity\Occurence;
use AppBundle\Entity\Profession;
use AppBundle\Entity\Stat;
use AppBundle\Entity\Word;
use MigrationBundle\Entity\Answer;
use MigrationBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('migration:run')
            ->setDescription('Get salon database and treat if to get stats and make search engine query easier. Also removing user datas.')
            ->setHelp('Get salon database and treat if to get stats and make search engine query easier. Also removing user datas.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $doctrine = $this->getContainer()->get("doctrine");
        $targetManager = $doctrine->getManager("default");
        $oldManager = $doctrine->getManager("migration");
        $this->connection = $targetManager->getConnection();
        $this->platform   = $this->connection->getDatabasePlatform();

        // count total interview
        $interview = $doctrine->getRepository("MigrationBundle:Interview", 'migration')->findAll();
        $totalInt = count($interview);
        $output->writeln($totalInt);

        // migrating answer database to word
        $this->truncate('word');
        $output->writeln("Migrating words");
        $answers = $doctrine->getRepository('MigrationBundle:Answer', 'migration')->migration();

        foreach ($answers as $answer){
            $word = new Word();
            $word ->setTag($answer['word']);
            $word ->setId($answer['id']);
            $targetManager->persist($word);
        }

        $metadata = $targetManager->getClassMetaData(get_class($word));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $targetManager->flush();
        $output->writeln("Importing Words done");
        $output->writeln("");


        // migrating job database to profession

        $this->truncate('profession');
        $output->writeln("Migrating jobs");
        $jobs = $doctrine->getRepository('MigrationBundle:Job', 'migration')->migration();

        foreach ($jobs as $job){
            $profession = new Profession();
            $profession ->setName($job['name']);
            $profession ->setDomain($job['domain']);
            $profession ->setId($job['id']);
            $targetManager->persist($profession);
        }

        $metadata = $targetManager->getClassMetaData(get_class($profession));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $targetManager->flush();
        $output->writeln("Importing Professions done");
        $output->writeln("");


        /**** STATISTICS ****/

        $this->truncate('stat');

        // Global stats

        $output->writeln("Calculating global stats");
            // domain
        $output->writeln(" stat 1");

        $domains = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20domains();
        foreach ($domains as $domain) {
            $stat = new Stat();
            $stat->setName($domain['domain']);
            $stat->setNumber(round(($domain['total']/$totalInt)*100, 2));
            $stat->setType('domain20-global');
            $targetManager->persist($stat);
        }
        //  $metadata = $targetManager->getClassMetaData(get_class($stat));
        // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $targetManager->flush();


            // jobs
        $output->writeln(" stat 2");

        $jobs = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20jobs();

        foreach ($jobs as $job) {
            $stat = new Stat();
            $stat->setName($job['name']);
            $stat->setNumber(round(($job['total']/$totalInt)*100, 2));
            $stat->setType('job20-global');
            $targetManager->persist($stat);
        }

        //  $metadata = $targetManager->getClassMetaData(get_class($stat));
        // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $targetManager->flush();


            //words
        $output->writeln(" stat 3");

        $words = $doctrine->getRepository('MigrationBundle:Answer', 'migration')->getword20();
        foreach ($words as $word) {
            $stat = new Stat();
            $stat->setName($word['word']);
            $stat->setNumber(round(($word['total']/$totalInt)*100, 2));
            $stat->setType('word20-global');
            $targetManager->persist($stat);
        }




        // Stats by sexes

        $output->writeln("Calculating stats by sexe");
        $sexes = ['H','F'];
        foreach($sexes as $sexe) {
            $totalsexe = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->getTotalBySexe($sexe);
            $output->writeln($totalsexe);

            // calculating stats for domain

            $domains = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20domainsbysexe($sexe);

            foreach ($domains as $domain) {
                $stat = new Stat();
                $stat->setName($domain['domain']);
                $stat->setNumber(round(($domain['total']/$totalsexe)*100, 2));
                $stat->setType('domain20-' . $sexe);
                $targetManager->persist($stat);
            }

            //  $metadata = $targetManager->getClassMetaData(get_class($stat));
            // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();

            // calculating stats for job

            $jobs = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20jobsbysexe($sexe);

            foreach ($jobs as $job) {
                $stat = new Stat();
                $stat->setName($job['name']);
                $stat->setNumber(round(($job['total']/$totalsexe)*100, 2));
                $stat->setType('job20-' . $sexe);
                $targetManager->persist($stat);
            }

            //  $metadata = $targetManager->getClassMetaData(get_class($stat));
            // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();

        }
        $output->writeln("Stats by sexe done");
        $output->writeln("");



        // Stats by statut

        $output->writeln("Calculating stats by status");
        $statuts = ['Collégien','Lycéen', 'Etudiant', 'Parent', 'Demandeur d\'emploi', 'Adulte en réorientation', 'Professionnel de l\'orientation et de la formation', 'Salarié', 'Autre'];

        foreach($statuts as $statut) {
            $totalStatus = $doctrine->getRepository("MigrationBundle:Interview", 'migration')->getTotalByStatus($statut);
            $output->writeln($totalStatus);
            // calculating stats for domain

            $domains = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20domainsbystatus($statut);

            foreach ($domains as $domain) {
                $stat = new Stat();
                $stat->setName($domain['domain']);
                $stat->setNumber($domain['total']);
                $stat->setType('domain20-' . $statut);
                $targetManager->persist($stat);
            }

            //  $metadata = $targetManager->getClassMetaData(get_class($stat));
            // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();

            // calculating stats for job

            $jobs = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20jobsbystatus($statut);

            foreach ($jobs as $job) {
                $stat = new Stat();
                $stat->setName($job['name']);
                $stat->setNumber($job['total']);
                $stat->setType('job20-' . $statut);
                $targetManager->persist($stat);
            }

            //  $metadata = $targetManager->getClassMetaData(get_class($stat));
            // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();

        }
        $output->writeln("Stats by status done");
        $output->writeln("");



        // Stats by age

        $output->writeln("Calculating stats by age");
        $ages = [[0,16],[17,20], [21,25],[26,35],[36,45],[46,100],];

        foreach($ages as $age) {

            // calculating stats for domain

            $domains = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20domainsbyage($age[0], $age[1]);

            foreach ($domains as $domain) {
                $stat = new Stat();
                $stat->setName($domain['domain']);
                $stat->setNumber($domain['total']);
                $stat->setType('domain20-'.$age[0]."-".$age[1]);
                $targetManager->persist($stat);
            }

            //  $metadata = $targetManager->getClassMetaData(get_class($stat));
            // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();

            // calculating stats for job

            $jobs = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20jobsbyage($age[0], $age[1]);

            foreach ($jobs as $job) {
                $stat = new Stat();
                $stat->setName($job['name']);
                $stat->setNumber($job['total']);
                $stat->setType('job20-' . $age[0]."-".$age[1]);
                $targetManager->persist($stat);
            }

            //  $metadata = $targetManager->getClassMetaData(get_class($stat));
            // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();

        }
        $output->writeln("Stats by status done");
        $output->writeln("");
















                            /*** LOADING BD FOR SEARCH ENGINE ***/

        $output->writeln("Calculating occurences");
        $this->truncate('occurence');
        $output->writeln('occurence truncated');
        $totalRecords = 1558;
        $progress = new ProgressBar($output, $totalRecords);
        for($j=2;$j<1558; $j++) {
            $occunumbers = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->wordtojob($j);

            foreach ($occunumbers as $occunumber) {
                $occurence = new Occurence();
                $jobname = $targetManager->getRepository('AppBundle:Profession')->find($occunumber['jobid']);
                $occurence->setProfession($jobname);
                $answername = $targetManager->getRepository('AppBundle:Word')->find($occunumber['answerid']);
                $occurence->setWord($answername);
                $occurence->setNumber($occunumber['total']);
                $targetManager->persist($occurence);
            }
            $progress->advance();
        }

            $metadata = $targetManager->getClassMetaData(get_class($occurence));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();
        $output->writeln("");

        $output->writeln("Calculating occurence done");


    }



    private function truncate($table)
    {
        $this->output->writeln("Truncate $table");
        $this->connection->executeUpdate("SET FOREIGN_KEY_CHECKS=0;");
        $this->connection->executeUpdate($this->platform->getTruncateTableSQL($table, true));
        $this->connection->executeUpdate("SET FOREIGN_KEY_CHECKS=1;");
    }
}