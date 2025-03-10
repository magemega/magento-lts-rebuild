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

namespace Mage\Adminhtml\Test\Block\Catalog\Product\Edit\Tab;

use Magento\Mtf\Client\Element\SimpleElement as Element;
use Mage\Adminhtml\Test\Block\Widget\Tab;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Fixture\FixtureInterface;

/**
 * Websites Tab.
 */
class Websites extends Tab
{
    /**
     * Tab selector.
     *
     * @var string
     */
    protected $tabSelector = '#product_info_tabs_websites';

    /**
     * Selector foe checked websites fields.
     *
     * @var string
     */
    protected $checkedWebsites = '[name="product[website_ids][]"]';

    /**
     * Selector for label website.
     *
     * @var string
     */
    protected $websiteLabel = './..//label';

    /**
     * Fill data to fields on tab.
     *
     * @param array $fields
     * @param Element|null $element
     * @return $this
     */
    public function fillFormTab(array $fields, Element $element = null)
    {
        $context = $element ? $element : $this->_rootElement;
        $mapping = $this->dataMapping(['website' => 'Yes']);
        $data = [];
        foreach ($fields as $key => $website) {
            $data[$key] = $mapping['website'];
            $data[$key]['selector'] = sprintf($mapping['website']['selector'], $website);
        }
        $this->_fill($data, $context);

        return $this;
    }

    /**
     * Get data of the form.
     *
     * @param FixtureInterface|null $fixture
     * @param Element|null $element
     * @return array
     */
    public function getData(FixtureInterface $fixture = null, Element $element = null)
    {
        $result = [];
        $checkedWebsites = $this->_rootElement->getElements($this->checkedWebsites, Locator::SELECTOR_CSS, 'checkbox');
        foreach ($checkedWebsites as $item) {
            if($item->getValue() == 'Yes') {
                $result[] = $item->find($this->websiteLabel, Locator::SELECTOR_XPATH)->getText();
            }
        }

        return $result;
    }

    /**
     * Check if the tab is visible or not.
     *
     * @return bool
     */
    public function isVisible()
    {
        return $this->_rootElement->find($this->tabSelector)->isVisible();
    }
}
