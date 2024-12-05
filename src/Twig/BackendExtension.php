<?php

namespace Kiwi\Contao\CmxBundle\Twig;

use Contao\System;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BackendExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('csrf', [$this, 'getCSRF']),
            new TwigFunction('clipboard', [$this, 'getClipboard']),
            new TwigFunction('copiedArticle', [$this, 'getCopiedArticleId']),
        ];
    }

    public function getCSRF(): string
    {
        return System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue();
    }

    public function getClipboard()
    {
        $objSession = System::getContainer()->get('request_stack')->getSession();
        $arrClipboard = $objSession->get('CLIPBOARD');

        return $arrClipboard;
    }

    public function getCopiedArticleId()
    {
        $objSession = System::getContainer()->get('request_stack')->getSession();
        $arrClipboard = $objSession->get('CLIPBOARD');

        return ($arrClipboard['tl_article']['mode'] ?? false) == 'copy' ? $arrClipboard['tl_article']['id'] : false;
    }
}