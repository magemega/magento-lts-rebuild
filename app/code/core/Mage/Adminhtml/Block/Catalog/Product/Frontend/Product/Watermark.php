<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @copyright  Copyright (c) 2019-2022 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Fieldset config form element renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 */
class Mage_Adminhtml_Block_Catalog_Product_Frontend_Product_Watermark extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    public const XML_PATH_IMAGE_TYPES = 'global/catalog/product/media/image_types';

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $html = $this->_getHeaderHtml($element);
        $renderer = Mage::getBlockSingleton('adminhtml/system_config_form_field');

        $attributes = Mage::getConfig()->getNode(self::XML_PATH_IMAGE_TYPES)->asArray();

        foreach ($attributes as $key => $attribute) {
            /**
             * Watermark size field
             */
            $field = new Varien_Data_Form_Element_Text();
            $field->setName("groups[watermark][fields][{$key}_size][value]")
                ->setForm($this->getForm())
                ->setLabel(Mage::helper('adminhtml')->__('Size for %s', $attribute['title']))
                ->setRenderer($renderer);
            $html .= $field->toHtml();

            /**
             * Watermark upload field
             */
            $field = new Varien_Data_Form_Element_Imagefile();
            $field->setName("groups[watermark][fields][{$key}_image][value]")
                ->setForm($this->getForm())
                ->setLabel(Mage::helper('adminhtml')->__('Watermark File for %s', $attribute['title']))
                ->setRenderer($renderer);
            $html .= $field->toHtml();

            /**
             * Watermark position field
             */
            $field = new Varien_Data_Form_Element_Select();
            $field->setName("groups[watermark][fields][{$key}_position][value]")
                ->setForm($this->getForm())
                ->setLabel(Mage::helper('adminhtml')->__('Position of Watermark for %s', $attribute['title']))
                ->setRenderer($renderer)
                ->setValues(Mage::getSingleton('adminhtml/system_config_source_watermark_position')->toOptionArray());
            $html .= $field->toHtml();
        }

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    protected function _getHeaderHtml($element)
    {
        $id = $element->getHtmlId();
        $default = !$this->getRequest()->getParam('website') && !$this->getRequest()->getParam('store');

        $html = '<h4 class="icon-head head-edit-form">' . $element->getLegend() . '</h4>';
        $html .= '<fieldset class="config" id="' . $element->getHtmlId() . '">';
        $html .= '<legend>' . $element->getLegend() . '</legend>';

        // field label column
        $html .= '<table cellspacing="0"><colgroup class="label" /><colgroup class="value" />';
        if (!$default) {
            $html .= '<colgroup class="use-default" />';
        }
        $html .= '<tbody>';

        return $html;
    }

    protected function _getFooterHtml($element)
    {
        return '</tbody></table></fieldset>';
    }
}
