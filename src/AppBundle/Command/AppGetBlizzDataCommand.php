<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use BlizzardApi\BlizzardClient;
use BlizzardApi\Service\WorldOfWarcraft;

class AppGetBlizzDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:get-blizz-data')
            ->setDescription('Query the Blizzard API to return to be written to disk')
            ->addArgument('key', InputArgument::REQUIRED, 'Blizzard API key')
            ->addArgument('secret', InputArgument::REQUIRED, 'Blizzard API secret')
//            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $client = new BlizzardClient($input->getArgument('key'));
        $wow = new WorldOfWarcraft($client->setAccessToken($input->getArgument('secret')));

        // Use API method for getting specific data
        $response = $wow->getCharacter('gorgonnash', 'elapsed', [
          'fields' => '',
        ]);

        $output->writeln($response->getBody()->getContents());
    }

}
