<?php

use Kiwi\Contao\CmxBundle\Widget\Backend\IconedSelectMenuWidget;

$GLOBALS['BE_FFL']['iconedSelect'] = IconedSelectMenuWidget::class;

if (($_ENV['APP_ENV'] ?? false) == "dev") {
    $GLOBALS['TL_CSS'][] = "bundles/kiwicmx/main.css";
}