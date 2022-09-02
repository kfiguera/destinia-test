<?php

namespace SimpleCli;

use SimpleCli\Command\Call;
use SimpleCli\Command\Controller;
use SimpleCli\Command\Registry;

class SimpleCli
{
    protected $printer;

    protected $command_registry;

    protected $app_signature;

    public function __construct()
    {
        $this->printer = new Printer();
        $this->command_registry = new Registry(__DIR__ . '/../src/Command');
    }

    public function getPrinter()
    {
        return $this->printer;
    }

    public function getSignature()
    {
        return $this->app_signature;
    }

    public function printSignature()
    {
        $this->getPrinter()->display(sprintf("usage: %s", $this->getSignature()));
    }

    public function setSignature($app_signature)
    {
        $this->app_signature = $app_signature;
    }


    public function registerCommand($name, $callable)
    {
        $this->command_registry->registerCommand($name, $callable);
    }

    public function runCommand(array $argv = [])
    {

        $input = new Call($argv);

        if (count($input->args) < 2) {
            $this->printSignature();

        } else {
            $controller = $this->command_registry->getCallableController($input->command, $input->subcommand);

            if ($controller instanceof Controller) {
                $controller->boot($this);
                $controller->run($input);
                $controller->teardown();

            } else {
                $this->runSingle($input);
            }
        }
    }

    protected function runSingle(Call $input)
    {
        try {
            $callable = $this->command_registry->getCallable($input->command);
            call_user_func($callable, $input);
        } catch (\Exception $e) {
            $this->getPrinter()->display("ERROR: " . $e->getMessage());
            $this->printSignature();
        }
    }

}