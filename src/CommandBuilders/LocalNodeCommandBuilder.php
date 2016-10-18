<?php

namespace Shura\Node\CommandBuilders;

use Shura\Node\NodeCommandBuilder;
use Shura\Exeggutor\Commands\CommandBuilder;

class LocalNodeCommandBuilder extends NodeCommandBuilder
{
    private static $bin;

    public function makeCommand()
    {
        return new CommandBuilder(self::getBinPath());
    }

    public static function getBinPath()
    {
        if (!isset(self::$bin)) {
            $os = mb_strtolower(php_uname('s'));
            $march = str_replace('x86_64', 'x64', mb_strtolower(php_uname('m')));
            $file = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'bins'.DIRECTORY_SEPARATOR.$os.'-'.$march.'-node';

            if (is_file($file)) {
                self::$bin = ($file = realpath($file));

                if (is_executable($file)) {
                    @chmod($file, 0755);
                }
            }
        }

        return self::$bin;
    }

    public static function isValid()
    {
        return self::getBinPath() !== null;
    }
}
