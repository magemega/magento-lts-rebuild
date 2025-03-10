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
 * @copyright  Copyright (c) 2022 The OpenMage Contributors (https://www.openmage.org)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Adminhtml store delete group block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 */
class Mage_Adminhtml_Block_System_Store_Delete_Website extends Mage_Adminhtml_Block_Template
{
    /**
     * @inheritDoc
     */
    protected function _prepareLayout()
    {
        $itemId = $this->getRequest()->getParam('website_id');

        $this->setTemplate('system/store/delete_website.phtml');
        $this->setAction($this->getUrl('*/*/deleteWebsitePost', ['website_id' => $itemId]));
        $this->setChild(
            'confirm_deletion_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('core')->__('Delete Website'),
                    'onclick'   => "deleteForm.submit()",
                    'class'     => 'cancel'
                ])
        );
        $onClick = Mage::helper('core/js')->getSetLocationJs($this->getUrl('*/*/editWebsite', ['website_id' => $itemId]));
        $this->setChild(
            'cancel_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('core')->__('Cancel'),
                    'onclick'   => $onClick,
                    'class'     => 'cancel'
                ])
        );
        $this->setChild(
            'back_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData([
                    'label'     => Mage::helper('core')->__('Back'),
                    'onclick'   => $onClick,
                    'class'     => 'cancel'
                ])
        );
        return parent::_prepareLayout();
    }
}
