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

namespace Mage\Catalog\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Block for search field.
 */
class Search extends Block
{
    /**
     * Selector matches found - "Suggest Search".
     *
     * @var string
     */
    protected $searchAutocomplete = './/div[@id="search_autocomplete"]//li[text()="%s"]';

    /**
     * Selector number of matches for a given row.
     *
     * @var string
     */
    protected $searchItemAmount = '/span[@class="amount" and text()="%d"]';

    /**
     * Search field.
     *
     * @var string
     */
    protected $searchInput = '#search';

    /**
     * Search button.
     *
     * @var string
     */
    private $searchButton = '[title="Search"]';

    /**
     * Search products by a keyword
     *
     * @param string $keyword
     * @return void
     *
     * @SuppressWarnings(PHPMD.ConstructorWithNameAsEnclosingClass)
     */
    public function search($keyword)
    {
        $this->fillSearch($keyword);
        $this->_rootElement->find($this->searchButton, Locator::SELECTOR_CSS)->click();
    }

    /**
     * Fills the search field
     *
     * @param string $text
     * @return void
     */
    public function fillSearch($text)
    {
        $this->_rootElement->find($this->searchInput, Locator::SELECTOR_CSS)->setValue($text);
    }

    /**
     * Checking block visibility "Suggest Search"
     *
     * @param string $text
     * @param int|null $amount
     * @return bool
     */
    public function isSuggestSearchVisible($text, $amount = null)
    {
        $searchAutocomplete = sprintf($this->searchAutocomplete, $text);
        if ($amount !== null) {
            $searchAutocomplete .= sprintf($this->searchItemAmount, $amount);
        }

        $rootElement = $this->_rootElement;
        return (bool)$this->_rootElement->waitUntil(
            function () use ($rootElement, $searchAutocomplete) {
                return $rootElement->find($searchAutocomplete, Locator::SELECTOR_XPATH)->isVisible() ? true : null;
            }
        );
    }
}
