<?php

namespace Vagrant\Shim\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('install')
            ->setDescription('Symlink vagrant-shim to a directory in $PATH')
            ->addArgument('path', InputArgument::OPTIONAL, '<comment>Default</comment>: <info>/usr/local/bin</info>')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path') ?: '/usr/local/bin';

        if ($this->manager->isInstalled()) {
            $output->write(sprintf('Uninstalling from <info>%s</info>...', join('</info>, <info>', $this->manager->getInstalledPaths())));

            if ($this->manager->uninstall()) {
                $output->writeln('<comment>SUCCESS</comment>');
            } else {
                $output->writeln('<error>FAILED</error>');

                return 1;
            }
        }

        $output->write(sprintf('Installing to <info>%s</info>...', $path));

        if ($this->manager->install($path)) {
            $output->writeln('<comment>SUCCESS</comment>');
        } else {
            $output->writeln('<error>FAILED</error>');

            return 1;
        }
    }
}
