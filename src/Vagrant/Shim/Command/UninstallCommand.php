<?php

namespace Vagrant\Shim\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UninstallCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('uninstall')
            ->setDescription('Remove vagrant-shim from $PATH')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->manager->isInstalled()) {
            $output->write(sprintf('Uninstalling from <info>%s</info>...', join('</info>, <info>', $this->manager->getInstalledPaths())));

            if ($this->manager->uninstall()) {
                $output->writeln('<comment>SUCCESS</comment>');
            } else {
                $output->writeln('<error>FAILED</error>');

                return 1;
            }
        } else {
            $output->writeln('<error>Not installed.</error>');
        }
    }
}
