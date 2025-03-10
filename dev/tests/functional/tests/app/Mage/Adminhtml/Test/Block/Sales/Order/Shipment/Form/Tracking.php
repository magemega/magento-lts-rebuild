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

use Mage\Adminhtml\Test\Block\Sales\Order\Shipment\Form\Tracking\Item;
use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Tracking to ship block.
 */
class Tracking extends Block
{
    /**
     * Add tracking button.
     *
     * @var string
     */
    protected $addTracking = '[onclick*="trackingControl.add"]';

    /**
     * Item tracking block.
     *
     * @var string
     */
    protected $itemTracking = './/tbody/tr[not(contains(@class,"no-display"))][%d]';

    /**
     * Get tracking block.
     *
     * @param int $index
     * @return Item
     */
    protected function getItemTrackingBlock($index)
    {
        return $this->blockFactory->create(
            'Mage\Adminhtml\Test\Block\Sales\Order\Shipment\Form\Tracking\Item',
            ['element' => $this->_rootElement->find(sprintf($this->itemTracking, $index), Locator::SELECTOR_XPATH)]
        );
    }

    /**
     * Fill tracking.
     *
     * @param array $data
     * @return void
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if (!$this->getItemTrackingBlock(++$key)->isVisible()) {
                $this->_rootElement->find($this->addTracking)->click();
            }
            $this->getItemTrackingBlock($key)->fillRow($value);
        }
    }
}
