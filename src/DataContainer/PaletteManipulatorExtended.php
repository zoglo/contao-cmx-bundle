<?php

namespace Kiwi\Contao\CmxBundle\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;

class PaletteManipulatorExtended extends PaletteManipulator{
    public static function create(): self
    {
        return new self();
    }

    public function applyToAllPalettes(string $table, array $arrExceptions = []):object
    {
        foreach ($GLOBALS['TL_DCA'][$table]['palettes'] as $strPalette => $varFields) {
            if(!is_string($varFields) || in_array($strPalette, ($arrExceptions ?? []))) continue;

            $this->applyToPalette($strPalette, $table);
        }
        return $this;
    }
}