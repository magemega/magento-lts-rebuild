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

namespace Mage\Adminhtml\Test\Block\Sales\Order\Shipment\Form;

use Mage\Adminhtml\Test\Block\Sales\Order\AbstractItemsNewBlock;

/**
 * Block for items to shipment on new shipment page.
 */
class Items extends AbstractItemsNewBlock
{
    /**
     * Item block class.
     *
     * @var string
     */
    protected $classItemBlock = 'Mage\Adminhtml\Test\Block\Sales\Order\Shipment\Form\Items\Product';
}
