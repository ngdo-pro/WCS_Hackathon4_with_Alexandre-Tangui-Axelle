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
        $output->writeln("");
        $output->writeln("Importing Words done");

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
        $output->writeln("");
        $output->writeln("Importing Professions done");

        // calculating stats domain by sexe

        $this->truncate('stat');
        $output->writeln("Calculating stats");

        $sexes = ['H','F'];

        foreach($sexes as $sexe) {
            $domains = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20domainsbysexe($sexe);

            $id = 1;
            foreach ($domains as $domain) {
                $stat = new Stat();
                $stat->setId($id);
                $stat->setName($domain['domain']);
                $stat->setNumber($domain['total']);
                $stat->setType('domain20' . $sexe);
                $targetManager->persist($stat);

                $id++;
            }

            //  $metadata = $targetManager->getClassMetaData(get_class($stat));
            // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();
        }
        $output->writeln("");
        $output->writeln("Importing Professions done");

        // calculating stats domain by sexe
        /*
                $this->truncate('stat');
                $output->writeln("Calculating stats");

                $sexes = ['H','F'];

                foreach($sexes as $sexe) {
                    $domains = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->get20domainsbysexe($sexe);

                    $id = 1;
                    foreach ($domains as $domain) {
                        $stat = new Stat();
                        $stat->setId($id);
                        $stat->setName($domain['domain']);
                        $stat->setNumber($domain['total']);
                        $stat->setType('domain20' . $sexe);
                        $targetManager->persist($stat);

                        $id++;
                    }

                    //  $metadata = $targetManager->getClassMetaData(get_class($stat));
                    // $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                    $targetManager->flush();
                }
        */
        // charging occurence

        $output->writeln("Calculating occurence");
        $this->truncate('occurence');
        $output->writeln('occurence truncated');
        $totalRecords = 1558;
        $progress = new ProgressBar($output, $totalRecords);
        for($j=2;$j<1558; $j++) {
            $occunumbers = $doctrine->getRepository('MigrationBundle:Interview', 'migration')->wordtojob($j);

            foreach ($occunumbers as $occunumber) {
                $occurence = new Occurence();
                //     $output->writeln($occunumber['jobid']);
                //     $output->writeln($occunumber['answerid']);
                $jobname = $targetManager->getRepository('AppBundle:Profession')->find($occunumber['jobid']);
                $occurence->setProfession($jobname);
                $answername = $targetManager->getRepository('AppBundle:Word')->find($occunumber['answerid']);
                $occurence->setWord($answername);
                $occurence->setNumber($occunumber['total']);
                $targetManager->persist($occurence);
                $progress->advance();
            }
        }

            $metadata = $targetManager->getClassMetaData(get_class($occurence));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $targetManager->flush();
        $output->writeln("");
        $output->writeln("Importing Words done");


        $output->writeln("");
        $output->writeln("Importing Professions done");


    }



    private function truncate($table)
    {
        $this->output->writeln("Truncate $table");
        $this->connection->executeUpdate("SET FOREIGN_KEY_CHECKS=0;");
        $this->connection->executeUpdate($this->platform->getTruncateTableSQL($table, true));
        $this->connection->executeUpdate("SET FOREIGN_KEY_CHECKS=1;");
    }
}