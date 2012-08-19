<?php

namespace Vagrant\Shim\Manager;

use Symfony\Component\Console\Application;

class ShimManager
{
    /**
     * @var string Root directory for shims
     */
    private $shimRoot;

    public function __construct($shimRoot)
    {
        $this->shimRoot = $shimRoot;
    }

    /**
     * @var string Program
     */
    public function createShim($program)
    {
        if (!is_dir($this->shimRoot) && !@mkdir($this->shimRoot)) {
            throw new \LogicException('Could not create shim directory: '.$this->shimRoot);
        }

        $path   = $this->getShimPath($program);
        $stub   = $this->getShimStub();

        if (file_put_contents($path, $stub)) {
            chmod($path, 0750);

            return true;
        }

        return false;
    }

    public function disable()
    {
        $paths      = $this->getPaths();
        $shimRoot   = $this->shimRoot;
        $filtered   = array_filter($paths, function($path) use ($shimRoot) {
            return $path !== $shimRoot;
        });

        $command = sprintf('export PATH=%s', join(':', $filtered));

        return $command;
    }

    public function enable()
    {
        $command = sprintf('export PATH=%s:${PATH}', $this->shimRoot);

        return $command;
    }

    /**
     * @return array Paths to vagrant-shim
     */
    public function getInstalledPaths()
    {
        return $this->searchPaths('vagrant-shim');
    }

    public function getPaths()
    {
        return explode(':', $_SERVER['PATH']);
    }

    /**
     * @var string Program
     * @return string Path to shim
     */
    public function getShimPath($program)
    {
        return $this->shimRoot.'/'.$program;
    }

    public function getShimRoot()
    {
        return $this->shimRoot;
    }

    public function getShims()
    {
        $root   = $this->getShimRoot();
        $files  = array_map(function($file) use ($root) {
            return $root.'/'.$file;
        }, scandir($root));

        $shims  = array();
        foreach ($files as $file) {
            if (is_file($file) && is_executable($file)) {
                $shims[$file] = basename($file);
            }
        }

        return $shims;
    }

    public function getShimStub()
    {
        $stub = <<<BASH
#!/usr/bin/env bash
set -e
vagrant-shim run "\${0##*/}" "\$@"
BASH;

        return $stub;
    }

    public function getVagrantPath($path = null)
    {
        $root = $path ?: getcwd();

        while ($root && $root !== '/' && !file_exists($root.'/Vagrantfile')) {
            $root = realpath($root.'/../');
        }

        if (file_exists($root.'/Vagrantfile')) {
            return $root;
        }
    }

    /**
     * @var string Installation path for vagrant-shim
     */
    public function install($path)
    {
        if (!realpath($path)) {
            throw new \InvalidArgumentException('Path does not exist: '.$path);
        }

        if (!is_writable($path)) {
            throw new \InvalidArgumentException('Path is not writeable');
        }

        $target = realpath(__DIR__.'/../../../../bin/vagrant-shim');
        $link   = $path.'/'.basename($target);

        return symlink($target, $link);
    }

    public function isEnabled()
    {
        $paths = $this->getPaths();

        return in_array($this->shimRoot, $paths);
    }

    /**
     * @return bool If vagrant-shim is installed in $PATH
     */
    public function isInstalled()
    {
        return count($this->getInstalledPaths());
    }

    public function hasVagrant($path = null)
    {
        return (bool) $this->getVagrantPath($path);
    }

    /**
     * Inject ShimManager into console commands
     */
    public function registerCommands(Application $console, array $commands)
    {
        foreach ($commands as $command) {
            if ($command instanceof ManagerAwareInterface) {
                $command->setManager($this);
            }

            $console->add($command);
        }
    }

    /**
     * Passes through command execution to local machine.
     * Used when Vagrant is not available as fall-back
     */
    public function runLocally($command)
    {
        $disable = $this->disable();

        $command = sprintf('%s && %s', $disable, $command);

        passthru($command);
    }

    /**
     * Run command through Vagrant VM relative to current working directory
     *
     * @var string Complete command to execute
     * @var string Optional path to the current working directory
     */
    public function runRemote($command, $cwd = null)
    {
        $cwd        = $cwd ?: getcwd();
        $root       = $this->getVagrantPath($cwd);
        $relative   = str_replace($root, null, $cwd);
        $command    = sprintf('cd .%s && %s', $relative, $command);
        $command    = sprintf('vagrant ssh -c %s', escapeshellarg($command));

        passthru($command);
    }

    /**
     * Search $PATH folders for specified program
     *
     * @return array matching paths
     */
    public function searchPaths($program)
    {
        $paths      = $this->getPaths();
        $matching   = array_filter($paths, function($path) use ($program) {
            if (file_exists($path.'/'.$program)) {
                return $path;
            }
        });

        return array_unique($matching);
    }

    /**
     * Remove vagrant-shim from matching $PATH folders
     */
    public function uninstall()
    {
        foreach ($this->getInstalledPaths() as $path) {
            $link = $path.'/vagrant-shim';

            if (file_exists($link)) {
                if (!unlink($link)) {
                    return false;
                }
            }
        }

        return true;
    }
}
