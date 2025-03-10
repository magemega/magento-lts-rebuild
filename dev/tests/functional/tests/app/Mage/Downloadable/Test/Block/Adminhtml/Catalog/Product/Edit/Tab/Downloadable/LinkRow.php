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

namespace Mage\Downloadable\Test\Block\Adminhtml\Catalog\Product\Edit\Tab\Downloadable;

use Magento\Mtf\Block\Form;

/**
 * Form item links.
 */
class LinkRow extends Form
{
    /**
     * Delete button selector.
     *
     * @var string
     */
    protected $deleteButton = '.delete-link-item';

    /**
     * Fill item link.
     *
     * @param array $fields
     * @return void
     */
    public function fillLinkRow(array $fields)
    {
        $mapping = $this->dataMapping($fields);
        $this->_fill($mapping);
    }

    /**
     * Get data item link.
     *
     * @param array $fields
     * @return array
     */
    public function getDataLinkRow(array $fields)
    {
        $mapping = $this->dataMapping($fields);
        return $this->_getData($mapping);
    }

    /**
     * Click delete button.
     *
     * @return void
     */
    public function clickDeleteButton()
    {
        $this->_rootElement->find($this->deleteButton)->click();
    }
}
