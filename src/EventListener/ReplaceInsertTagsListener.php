<?php

namespace Kiwi\Contao\CmxBundle\EventListener;

use Contao\ArticleModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\Content\PageResolver;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsHook("replaceInsertTags")]
class ReplaceInsertTagsListener
{
    public function __construct(protected ContentUrlGenerator $pageResolverService)
    {
    }

    public function __invoke(string $strTag)
    {
        if ($strTag === 'nbsp') {
            return '&nbsp;';
        } elseif ($strTag === 'shy') {
            return '&shy;';
        }

        $arrTag = explode('::', $strTag);

        if ($arrTag[0] == 'anchor_url') {
            $objArticle = ArticleModel::findById($arrTag[1]);

            if (!$objArticle) {
                return "";
            }

            $objParentPage = PageModel::findById($objArticle->pid);
            $strUrl = $this->pageResolverService->generate($objParentPage);

            $id = 'article-' . $objArticle->id;

            // Generate the CSS ID if it is not set
            if (empty($cssID = StringUtil::deserialize($objArticle->cssID,true)[0] ?? ""))
            {
                $cssID = $id;
            }
            return $strUrl.="#$cssID";
        }

        return false;
    }
}
