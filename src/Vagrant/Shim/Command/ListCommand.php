<?php

namespace Vagrant\Shim\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('list')
            ->setDescription('Lists current shims')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $shims = $this->manager->getShims();

        $output->writeln(sprintf("Found <comment>%s</comment> shims in <info>%s</info>:\n", count($shims), $this->manager->getShimRoot()));

        foreach ($shims as $path => $shim) {
            $output->writeln(sprintf("    - <info>%s</info>", $shim));
        }

        $output->writeln('');
    }
}
