<?php

namespace Shura\Node;

use Shura\Exeggutor\CommandInterface;

class NodeCommand implements CommandInterface
{
    private $cmd;

    public function __construct(CommandInterface $cmd)
    {
        $this->cmd = $cmd;
    }

    public function __toString()
    {
        return (string) $this->cmd;
    }

    public function getStandardIn()
    {
        return $this->cmd->getStandardIn();
    }

    public function getExitCode()
    {
        return $this->cmd->getExitCode();
    }

    public function getStandardOut()
    {
        return $this->cmd->getStandardOut();
    }

    public function getStandardError()
    {
        return $this->cmd->getStandardError();
    }
}
