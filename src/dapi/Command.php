<?php

namespace dapi;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \Cilex\Command\Command as VendorCommand;

/**
 * Class Command
 * @package dapi
 */
abstract class Command extends VendorCommand
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * Configure this tasks options and arguments.
     */
    protected function configure()
    {
        $this
            ->addOption('config_file', 'c', InputOption::VALUE_REQUIRED, 'Path to configuration file')
        ;

        parent::configure();
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param $key
     * @param null $default_value
     * @return mixed|null
     */
    public function getConfigBy($key, $default_value = null)
    {
        return isset($this->config[$key])? $this->config[$key] : $default_value;
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Get the input(argument|option|any) data.
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
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return bool
     */
    public function hasConfig(): bool
    {
        return isset($this->config) && !empty($this->config);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    final public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->setInput($input);
        $this->setOutput($output);
        $this->loadConfigurationFile();
    }

    /**
     * @throws \RuntimeException
     */
    public function loadConfigurationFile()
    {
        $config_file    = $this->getInputData('config_file');
        $config         = [];

        if ($config_file && is_file($config_file)) {
            $config = @json_decode(file_get_contents($config_file), true);
            if (json_last_error()) {
                throw new \RuntimeException('Error parsing configuration file json:[' . $config_file . ']');
            }
        }

        $this->setConfig($config);
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param InputInterface $input
     */
    public function setInput($input)
    {
        $this->input = $input;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }
}