<?php

namespace Vagrant\Shim\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShimCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('shim')
            ->setDescription('Specify programs to shim through Vagrant')
            ->addArgument('programs', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Programs shim through to Vagrant')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $programs = $input->getArgument('programs');

        if (in_array('php', $programs)) {
            throw new \InvalidArgumentException('PHP cannot be shimmed for vagrant-shim to work!');
        }

        foreach ($programs as $program) {
            if ($this->manager->createShim($program)) {
                $output->writeln(sprintf('Created shim for <info>%s</info>', $program));
            }
        }
    }
}
