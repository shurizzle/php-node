<?php

namespace Shura\Node;

interface NodeExecutorInterface
{
    public function exec($script, $arguments = null, $requires = null, $out = null, $err = null);
    public function execFile($script, $arguments = null, $requires = null, $out = null, $err = null);
}
