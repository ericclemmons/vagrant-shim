<?php

namespace Vagrant\Shim\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DisableCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('disable')
            ->setDescription('Remove shims from $PATH')
            ->setHelp(<<<HELP
Disable vagrant-shim by running:

    eval "\$(vagrant-shim disable)"
HELP
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->manager->isEnabled()) {
            $output->writeln($this->manager->disable());
        }
    }
}
