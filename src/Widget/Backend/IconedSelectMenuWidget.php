<?php

namespace Kiwi\Contao\CmxBundle\Widget\Backend;

use Contao\SelectMenu;
use Contao\StringUtil;

class IconedSelectMenuWidget extends SelectMenu
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_widget';

    public function generate()
    {
        $GLOBALS['TL_JAVASCRIPT'][]="/bundles/kiwicmx/main.js";

        $arrIcons=[];
        $arrData = $GLOBALS['TL_DCA'][$this->strTable]['fields'][$this->strField];
        if (\is_array($arrData['icon_callback'] ?? null))
        {
            $arrCallback = $arrData['icon_callback'];
            $arrIcons = static::importStatic($arrCallback[0])->{$arrCallback[1]}($this);
        }
        elseif (\is_callable($arrData['icon_callback'] ?? null))
        {
            $arrIcons = $arrData['icon_callback']($this);
        }

        //copied from parent
        $arrOptions = array();
        $strClass = 'tl_select';

        if ($this->multiple)
        {
            $this->strName .= '[]';
            $strClass = 'tl_mselect';
        }

        // Add an empty option if there are none
        if (empty($this->arrOptions) || !\is_array($this->arrOptions))
        {
            $this->arrOptions = array(array('value'=>'', 'label'=>'-'));
        }

        $arrAllOptions = $this->arrOptions;

        // Add an unknown option, so it is not lost when saving the record (see #920)
        if (isset($this->unknownOption[0]))
        {
            $arrAllOptions[] = array('value' => $this->unknownOption[0], 'label' => \sprintf($GLOBALS['TL_LANG']['MSC']['unknownOption'], $this->unknownOption[0]));
        }

        foreach ($arrAllOptions as $strKey=>$arrOption)
        {
            if (isset($arrOption['value']))
            {
                $arrOptions[] = \sprintf(
                    //different from parent
                    '<option value="%s"%s data-icon="%s">%s</option>',
                    self::specialcharsValue($arrOption['value']),
                    $this->isSelected($arrOption),
                    //different from parent
                    $arrIcons[$arrOption['value']] ?? '',
                    $arrOption['label'] ?? null
                );
            }
            else
            {
                $arrOptgroups = array();

                foreach ($arrOption as $arrOptgroup)
                {
                    $arrOptgroups[] = \sprintf(
                        //different from parent
                        '<option value="%s"%s data-icon="%s">%s</option>',
                        self::specialcharsValue($arrOptgroup['value'] ?? ''),
                        $this->isSelected($arrOptgroup),
                        //different from parent
                        $arrIcons[$arrOptgroup['value']] ?? '',
                        $arrOptgroup['label'] ?? null
                    );
                }

                $arrOptions[] = \sprintf('<optgroup label="&nbsp;%s">%s</optgroup>', StringUtil::specialchars($strKey), implode('', $arrOptgroups));
            }
        }

        // Chosen
        if ($this->chosen)
        {
            $strClass .= ' tl_chosen';
        }

        return \sprintf(
            '<div class="iconedSelect">%s<select name="%s" id="ctrl_%s" class="%s%s"%s data-action="focus->contao--scroll-offset#store">%s</select>%s</div>',
            $this->multiple ? '<input type="hidden" name="' . (str_ends_with($this->strName, '[]') ? substr($this->strName, 0, -2) : $this->strName) . '" value="">' : '',
            $this->strName,
            $this->strId,
            $strClass,
            $this->strClass ? ' ' . $this->strClass : '',
            $this->getAttributes(),
            implode('', $arrOptions),
            $this->wizard
        );
    }
}