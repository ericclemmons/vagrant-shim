<?php

namespace Vagrant\Shim\Manager;

interface ManagerAwareInterface
{
    public function setManager(ShimManager $manager);
}
