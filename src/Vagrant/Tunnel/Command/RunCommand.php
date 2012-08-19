<?php

namespace Vagrant\Tunnel\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Run shimmed program through Vagrant')

            // These are only for validation purposes
            ->addArgument('program', InputArgument::REQUIRED, 'Shimmed program to run')
            ->addArgument('arguments', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Arguments to pass to wrapped program')
            ->addOption('no-shim', null, InputOption::VALUE_NONE, 'Bypass the Vagrant wrapper')

            // So we can collection options
            ->ignoreValidationErrors()
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argv       = array_slice($_SERVER['argv'], 2);
        $command    = join(' ', $argv);
        $bypass     = $input->getOption('no-shim');

        if ($bypass) {
            $output->writeln('<info>Bypassing</info>...');

            $this->manager->runLocally($command);
        } elseif ($this->manager->hasVagrant()) {
            $output->writeln('<info>Shimming</info>...');

            $this->manager->runRemote($command);
        } else {
            $this->manager->runLocally($command);
        }
    }
}
