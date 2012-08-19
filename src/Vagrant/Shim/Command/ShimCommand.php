<?php

namespace Vagrant\Shim\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ShimCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('shim')
            ->setDescription('Specify programs to shim through Vagrant')
            ->addArgument('programs', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Programs shim through to Vagrant')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $programs   = $input->getArgument('programs');
        $dialog     = $this->getHelperSet()->get('dialog');

        // Gather list of programs
        if (empty($programs)) {
            $question   = 'Specify a program (or <comment>ENTER</comment> when done): ';

            while ($program = $dialog->ask($output, $question)) {
                $programs = array_merge($programs, explode(' ', trim($program)));
            }
        }

        $question = sprintf(
            'Shim <comment>%s</comment> programs: <info>%s</info>? [<comment>Y</comment>/n] ',
            count($programs),
            join('</info>, <info>', $programs)
        );

        if ($dialog->askConfirmation($output, $question)) {
            // Shim programs
            foreach ($programs as $program) {
                if ($this->manager->createShim($program)) {
                    $output->writeln(sprintf('Created shim for <info>%s</info>', $program));
                }
            }
        }
    }
}
