<?php

namespace dapi\Command;

use \dapi\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 * @package DAC
 */
final class LoadDataCommand extends Command
{

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('load')
            ->setDescription('load data')
        ;

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

    }
}