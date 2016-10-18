<?php

namespace Shura\Node;

abstract class NodeCommandBuilder implements NodeCommandBuilderInterface
{
    abstract public function makeCommand();

    public function buildExec($script, $arguments = null, $requires = null, $out = null, $err = null)
    {
        $cmd = $this->makeCommand()->setExitCode();

        if (is_string($out)) {
            $cmd->setStandardOut($out);
        } else {
            $cmd->setStandardOut();
        }

        if (is_string($err)) {
            $cmd->setStandardError($err);
        } else {
            $cmd->setStandardError();
        }

        if ((is_array($requires) && count($requires) > 0) ||
            (is_string($requires) && strlen($requires) > 0)) {
            $cmd->addFlag('r', $requires);
        }

        $cmd->addFlag('e', $script);

        if (is_array($arguments) && count($arguments) > 0) {
            foreach ($arguments as $argument) {
                $cmd->addArgument($argument);
            }
        } elseif (is_string($arguments) && strlen($arguments) > 0) {
            $cmd->addArgument($arguments);
        }

        return new NodeCommand($cmd);
    }

    public function buildExecFile($script, $arguments = null, $requires = null, $out = null, $err = null)
    {
        $cmd = $this->makeCommand()->setExitCode();

        if (is_string($out)) {
            $cmd->setStandardOut($out);
        } else {
            $cmd->setStandardOut();
        }

        if (is_string($err)) {
            $cmd->setStandardError($err);
        } else {
            $cmd->setStandardError();
        }

        if ((is_array($requires) && count($requires) > 0) ||
            (is_string($requires) && strlen($requires) > 0)) {
            $cmd->addFlag('r', $requires);
        }

        $cmd->addArgument($script);

        if (is_array($arguments) && count($arguments) > 0) {
            foreach ($arguments as $argument) {
                $cmd->addArgument($argument);
            }
        } elseif (is_string($arguments) && strlen($arguments) > 0) {
            $cmd->addArgument($arguments);
        }

        return new NodeCommand($cmd);
    }
}
