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

namespace Mage\Adminhtml\Test\Block\CatalogRule\Promo;

/**
 * Grid page actions block for 'Catalog Price Rules'.
 */
class GridPageActions extends \Mage\Adminhtml\Test\Block\GridPageActions
{
    /**
     * 'Apply Rules' button.
     *
     * @var string
     */
    protected $applyRules = '#apply_rules';

    /**
     * Click 'Apply Rules' button.
     */
    public function applyRules()
    {
        $this->_rootElement->find($this->applyRules)->click();
    }
}
