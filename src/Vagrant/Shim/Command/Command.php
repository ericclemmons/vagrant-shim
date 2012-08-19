<?php

namespace Vagrant\Shim\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Vagrant\Shim\Manager\ManagerAwareInterface;
use Vagrant\Shim\Manager\ShimManager;

class Command extends BaseCommand implements ManagerAwareInterface
{
    protected $manager;

    public function setManager(ShimManager $manager)
    {
        $this->manager = $manager;
    }
}
