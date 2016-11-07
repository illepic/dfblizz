<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppGetBlizzDataCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('app:get-blizz-data')
            ->setDescription('Query the Blizzard API to return to be written to disk')
//            ->addArgument('key', InputArgument::REQUIRED, 'Blizzard API key')
//            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $creator = $this->getContainer()->get('app.character_creator');

        $output->writeln("There are {$creator->getCount()} Characters!");

    }

}
