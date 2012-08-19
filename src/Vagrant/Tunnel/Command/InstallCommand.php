<?php

namespace Vagrant\Tunnel\Command;

use Symfony\Component\Console\Command\Command;
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
            ->setDescription('Symlink vagrant-tunnel to a directory in $PATH')
            ->addArgument('path', InputArgument::OPTIONAL, '<comment>Default</comment>: <info>/usr/local/bin</info>')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path') ?: '/usr/local/bin';

        if (!realpath($path)) {
            throw new \InvalidArgumentException('Path does not exist: '.$path);
        }

        if (!is_writable($path)) {
            throw new \InvalidArgumentException('Path is not writeable');
        }

        $target = __DIR__.'/../../../../bin/vagrant-tunnel';
        $link = $path.'/'.basename($target);

        if (file_exists($link)) {
            $output->write(sprintf('Removing <info>%s</info>...', $link));

            if (unlink($link)) {
                $output->writeln('<comment>SUCCESS</comment>');
            } else {
                $output->writeln('<error>FAILED</error>');
            }
        }

        $output->write(sprintf('Symlinking <info>%s</info>...', $link));

        if (symlink($target, $link)) {
            $output->writeln('<comment>SUCCESS</comment>');
        } else {
            $output->writeln('<error>FAILED</error>');
        }
    }
}
