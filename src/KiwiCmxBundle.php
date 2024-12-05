<?php

namespace Kiwi\Contao\CmxBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KiwiCmxBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
