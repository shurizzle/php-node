<?php

namespace Shura\Node\CommandBuilders;

use Shura\Which\Which;
use Shura\Node\NodeCommandBuilder;
use Shura\Exeggutor\Commands\CommandBuilder;

class SystemNodeCommandBuilder extends NodeCommandBuilder
{
    private static $bin;

    public function makeCommand()
    {
        return new CommandBuilder(self::getBinPath());
    }

    public static function getBinPath()
    {
        if (!isset(self::$bin)) {
            $file = Which::which('node');

            if (!isset($file)) {
                $file = Which::which('nodejs');
            }

            if (isset($file)) {
                self::$bin = $file;
            }
        }

        return self::$bin;
    }

    public static function isValid()
    {
        return self::getBinPath() !== null;
    }
}
