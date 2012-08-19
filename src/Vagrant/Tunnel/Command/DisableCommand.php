<?php

namespace Vagrant\Tunnel\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DisableCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('disable')
            ->setDescription('Remove shims from $PATH')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->manager->isEnabled()) {
            $output->writeln($this->manager->disable());
        }
    }
}
