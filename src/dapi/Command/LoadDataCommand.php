<?php

namespace dapi\Command;

use \dapi\Command;
use \dapi\Client\ClientFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LoadDataCommand
 * @package dapi\Command
 */
final class LoadDataCommand extends Command
{
    /**
     * Custom symfony/cli config setup.
     */
    protected function configure()
    {
        $this
            ->setName('load')
            ->setDescription('load data')
        ;

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('[' . __METHOD__ . ']::[started]');
        $this->validateExecute();
        $client     = ClientFactory::getClient($this->getConfigBy('client', []));
        $results    = $client->search();
        $output->writeln('[' . __METHOD__ . ']::[completed]');
    }

    /**
     * @throws \RuntimeException
     */
    public function validateExecute()
    {
        if ($this->hasConfig() === false) {
            throw new \RuntimeException('[ERROR]::[' . __METHOD__ .']::[missing the required config file]');
        }
    }
}