<?php
/**
 * OpenMage
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available at https://opensource.org/license/osl-3-0-php
 *
 * @category   Tests
 * @package    Tests_Functional
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (https://www.magento.com)
 * @license    https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Mage\Adminhtml\Test\Block\CatalogRule;

/**
 * Form page actions block.
 */
class FormPageActions extends \Mage\Adminhtml\Test\Block\FormPageActions
{
    /**
     * 'Save' button selector.
     *
     * @var string
     */
    protected $saveButton = '[onclick*="editForm.submit();"]';

    /**
     * "Save and Apply" button selector.
     *
     * @var string
     */
    protected $saveAndApplyButton = '[onclick*="$(\'rule_auto_apply\')"]';

    /**
     * Click on "Save and Apply" button.
     *
     * @return void
     */
    public function saveAndApply()
    {
        $this->_rootElement->find($this->saveAndApplyButton)->click();
    }

    /**
     * Click "Delete" button.
     *
     * @return void
     */
    public function delete()
    {
        $this->_rootElement->find($this->deleteButton)->click();
        $this->browser->acceptAlert();
    }
}
