<?php

namespace Shura\Node;

use Shura\Exeggutor\ExecutorInterface;

class NodeExecutor implements NodeExecutorInterface
{
    protected $executor;
    protected $commandBuilder;

    public function __construct(ExecutorInterface $executor, NodeCommandBuilderInterface $commandBuilder)
    {
        $this->executor = $executor;
        $this->commandBuilder = $commandBuilder;
    }

    public function exec($script, $arguments = null, $requires = null, $out = null, $err = null)
    {
        return $this->executor->run($this->commandBuilder->buildExec($script, $arguments, $requires, $out, $err));
    }

    public function execFile($script, $arguments = null, $requires = null, $out = null, $err = null)
    {
        return $this->executor->run($this->commandBuilder->buildExecFile($script, $arguments, $requires, $out, $err));
    }
}
