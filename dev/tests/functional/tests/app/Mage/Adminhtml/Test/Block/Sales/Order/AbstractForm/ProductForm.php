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

namespace Mage\Adminhtml\Test\Block\Sales\Order\AbstractForm;

/**
 * Item product form on items block.
 */
abstract class ProductForm extends Product
{
    /**
     * Fill item product data.
     *
     * @param array $data
     * @return void
     */
    public function fillProduct(array $data)
    {
        $data = $this->dataMapping($data);
        $this->_fill($data);
    }
}
