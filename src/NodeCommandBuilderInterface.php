<?php

namespace Shura\Node;

interface NodeCommandBuilderInterface
{
    public function buildExec($script, $arguments = null, $requires = null, $out = null, $err = null);
    public function buildExecFile($script, $arguments = null, $requires = null, $out = null, $err = null);
}
