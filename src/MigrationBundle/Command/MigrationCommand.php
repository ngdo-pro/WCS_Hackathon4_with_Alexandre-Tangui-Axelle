<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 04/02/17
 * Time: 15:37
 */

namespace MigrationBundle\Command;


use AppBundle\Entity\Profession;
use AppBundle\Entity\Word;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
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
        $this->connection = $targetManager->getConnection();
        $this->platform   = $this->connection->getDatabasePlatform();

        // migrating answer database to profession
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

    }



    private function truncate($table)
    {
        $this->output->writeln("Truncate $table");
        $this->connection->executeUpdate("SET FOREIGN_KEY_CHECKS=0;");
        $this->connection->executeUpdate($this->platform->getTruncateTableSQL($table, true));
        $this->connection->executeUpdate("SET FOREIGN_KEY_CHECKS=1;");
    }
}