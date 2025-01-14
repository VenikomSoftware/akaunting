<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process;

/**
 * An executable finder specifically designed for the PHP executable.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class PhpExecutableFinder
{
    private $executableFinder;

    public function __construct()
    {
        // @override
        //$this->executableFinder = new ExecutableFinder();
    }

    public function getPhpPath()
    {
        $php_path = getenv('APP_PHP_PATH');

        if (! empty($php_path)) {
            return $php_path;
        }

        if ($this->isCpanel()) {
            return '/usr/local/bin/php';
        }

        if ($this->isPlesk()) {
            $php_80 = '/opt/plesk/php/8.0/bin/php';
            $php_81 = '/opt/plesk/php/8.1/bin/php';
            $php_82 = '/opt/plesk/php/8.2/bin/php';

            if (@is_executable($php_80)) {
                return $php_80;
            }

            if (@is_executable($php_81)) {
                return $php_81;
            }

            if (@is_executable($php_82)) {
                return $php_82;
            }
        }

        return 'php';
    }

    public function isCpanel()
    {
        return $this->checkFolderAndPort('/usr/local/cpanel', 2082);
    }

    public function isPlesk()
    {
        return $this->checkFolderAndPort('/usr/local/psa', 8443);
    }

    public function isVirtualmin()
    {
        return $this->checkFolderAndPort('/usr/share/webmin', 10000);
    }

    public function checkFolderAndPort($folder, $port)
    {
        try {
            return is_dir($folder);
        } catch (\ErrorException|\Exception|\Throwable $e) {
            return $this->checkSocket($port);
        }
    }

    public function checkSocket($port)
    {
        try {
            $ip = @gethostbyname('localhost');
            $link = @fsockopen($ip, $port, $errno, $error);

            if ($link) {
                return true;
            }

            return false;
        } catch (\ErrorException|\Exception|\Throwable $e) {
            return false;
        }
    }

    /**
     * Finds The PHP executable.
     *
     * @return string|false The PHP executable path or false if it cannot be found
     */
    public function find(bool $includeArgs = true)
    {
        // @override
        // Not working on shared hosting due to "open_basedir" restriction applied by cPanel/Plesk
        return $this->getPhpPath();

        if ($php = getenv('PHP_BINARY')) {
            if (! is_executable($php)) {
                $command = '\\' === \DIRECTORY_SEPARATOR ? 'where' : 'command -v';
                if ($php = strtok(exec($command.' '.escapeshellarg($php)), PHP_EOL)) {
                    if (! is_executable($php)) {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            return $php;
        }

        $args = $this->findArguments();
        $args = $includeArgs && $args ? ' '.implode(' ', $args) : '';

        // PHP_BINARY return the current sapi executable
        if (PHP_BINARY && \in_array(\PHP_SAPI, ['cgi-fcgi', 'cli', 'cli-server', 'phpdbg'], true)) {
            return PHP_BINARY.$args;
        }

        if ($php = getenv('PHP_PATH')) {
            if (! @is_executable($php)) {
                return false;
            }

            return $php;
        }

        if ($php = getenv('PHP_PEAR_PHP_BIN')) {
            if (@is_executable($php)) {
                return $php;
            }
        }

        if (@is_executable($php = PHP_BINDIR.('\\' === \DIRECTORY_SEPARATOR ? '\\php.exe' : '/php'))) {
            return $php;
        }

        $dirs = [PHP_BINDIR];
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $dirs[] = 'C:\xampp\php\\';
        }

        return $this->executableFinder->find('php', false, $dirs);
    }

    /**
     * Finds the PHP executable arguments.
     *
     * @return array The PHP executable arguments
     */
    public function findArguments()
    {
        $arguments = [];
        if ('phpdbg' === \PHP_SAPI) {
            $arguments[] = '-qrr';
        }

        return $arguments;
    }
}
