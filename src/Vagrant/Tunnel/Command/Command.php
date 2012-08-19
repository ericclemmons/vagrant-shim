<?php

namespace Vagrant\Tunnel\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Vagrant\Tunnel\Manager\ManagerAwareInterface;
use Vagrant\Tunnel\Manager\TunnelManager;

class Command extends BaseCommand implements ManagerAwareInterface
{
    protected $manager;

    public function setManager(TunnelManager $manager)
    {
        $this->manager = $manager;
    }
}
