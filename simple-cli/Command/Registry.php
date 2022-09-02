<?php

namespace SimpleCli\Command;


class Registry
{
    /**
     * Indicate the path to the commands
     * @var string
     */
    protected $commands_path;

    /**
     * indicates the namespace to access commands
     * @var array
     */
    protected $namespaces = [];

    /**
     * Initialize the command registry
     * @param $commands_path
     */
    public function __construct($commands_path)
    {
        $this->commands_path = $commands_path;
        $this->autoloadNamespaces();
    }
    /*
     * Load the commands in memory
     */
    public function autoloadNamespaces()
    {
        foreach (glob($this->getCommandsPath() . '/*', GLOB_ONLYDIR) as $namespace_path) {
            $this->registerNamespace(basename($namespace_path));
        }
    }

    /*
     * Load namespaces for commands
     */
    public function registerNamespace($command_namespace)
    {
        $namespace = new Namespaces($command_namespace);
        $namespace->loadControllers($this->getCommandsPath());
        $this->namespaces[strtolower($command_namespace)] = $namespace;
    }

    public function getNamespace($command)
    {
        return isset($this->namespaces[$command]) ? $this->namespaces[$command] : null;
    }

    public function getCommandsPath()
    {
        return $this->commands_path;
    }

    public function registerCommand($name, $callable)
    {
        $this->default_registry[$name] = $callable;
    }

    public function getCommand($command)
    {
        return isset($this->default_registry[$command]) ? $this->default_registry[$command] : null;
    }

    public function getCallableController($command, $subcommand = null)
    {

        $namespace = $this->getNamespace($command);


        if ($namespace !== null) {
            return $namespace->getController($subcommand);
        }

        return null;
    }

    public function getCallable($command)
    {

        $single_command = $this->getCommand($command);
        if ($single_command === null) {
            throw new \Exception(sprintf("Command \"%s\" not found.", $command));
        }

        return $single_command;
    }

}