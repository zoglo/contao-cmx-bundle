<?php

namespace Kiwi\Contao\CmxBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;

#[AsHook('loadDataContainer')]
class LoadDataContainerListener
{
    public function __invoke(string $strTable): void
    {
        if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create('')) || ($_ENV['APP_ENV'] ?? false) == "dev" || System::getContainer()->get('request_stack')->getCurrentRequest()?->attributes?->get('_preview') ?? false) {
            $GLOBALS['TL_CSS'][] = "bundles/kiwicmx/main.css";
            $GLOBALS['TL_CSS'][] = "bundles/kiwicmx/backend.css";
        }
    }
}
