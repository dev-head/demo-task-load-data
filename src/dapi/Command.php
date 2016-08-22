<?php

namespace dapi;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use \Cilex\Command\Command as VendorCommand;

/**
 * Class Command
 * @package dapi
 */
abstract class Command extends VendorCommand
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * Used to get the input(argument|option|any) data in a normalized fashion.
     *
     * @param $name
     * @param null $default_value
     * @param string $type
     * @return null
     * @throws \RuntimeException
     */
    public function getInputData($name, $default_value = null, $type = 'any')
    {
        $input  = $this->getInput();
        $return = null;

        if (!$input) {
            throw new \RuntimeException('Missing valid input object.');
        }

        switch ($type) {
            case 'option':
                $return = $input->hasOption($name)? $input->getOption($name) : $return;
                break;
            case 'argument':
                $return = $input->hasArgument($name)? $input->getArgument($name) : $return;
                break;
            case 'any':
                $return = $input->hasOption($name)? $input->getOption($name) : $return;
                $return = !$return && $input->hasArgument($name)? $input->getArgument($name) : $return;
                break;
        }

        if (!$return) {
            $return = $default_value;
        }

        return $return;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    final public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->setInput($input);
        $this->setOutput($output);
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param InputInterface $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }
}