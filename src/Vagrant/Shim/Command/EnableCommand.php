<?php

namespace Vagrant\Shim\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EnableCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('enable')
            ->setDescription('Add shims to $PATH')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->manager->isEnabled()) {
            $output->writeln($this->manager->enable());
        }
    }
}