<?php

namespace SimpleCli\Command;

use SimpleCli\SimpleCli;

abstract class Controller
{
    protected $app;

    protected $input;

    abstract public function handle();

    public function boot(SimpleCli $app)
    {
        $this->app = $app;
    }

    public function run(Call $input)
    {
        $this->input = $input;
        $this->handle();
    }

    public function teardown()
    {
        //
    }

    protected function getArgs()
    {
        return $this->input->args;
    }

    protected function getParams()
    {
        return $this->input->params;
    }

    protected function hasParam($param)
    {
        return $this->input->hasParam($param);
    }

    protected function getParam($param)
    {
        return $this->input->getParam($param);
    }

    protected function getApp()
    {
        return $this->app;
    }

    protected function getPrinter()
    {
        return $this->getApp()->getPrinter();
    }
}