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

namespace Mage\Cms\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Client\Element\SimpleElement;

/**
 * Cms Page block for the content on the frontend.
 */
class Page extends Block
{
    /**
     * Cms page content.
     *
     * @var string
     */
    protected $cmsPageContent = ".std";

    /**
     * Cms page title.
     *
     * @var string
     */
    protected $cmsPageTitle = ".page-title";

    /**
     * Cms page head title.
     *
     * @var string
     */
    protected $cmsPageHeadTitle = ".page-head-alt";

    /**
     * Cms page text locator.
     *
     * @var string
     */
    protected $textSelector = "//div[contains(.,'%s')]";

    /**
     * Widgets selectors.
     *
     * @var array
     */
    protected $widgetSelectors = [
        'CMS Page Link' => './/*/a[contains(.,"%s")]',
    ];

    /**
     * Get page content.
     *
     * @param SimpleElement|null $element
     * @return string
     */
    public function getPageContent(SimpleElement $element = null)
    {
        $element = ($element === null) ? $this->_rootElement : $element;
        $this->waitForElementVisible($this->cmsPageContent);
        return $element->find($this->cmsPageContent)->getText();
    }

    /**
     * Get page title.
     *
     * @param SimpleElement|null $element
     * @return string
     */
    public function getPageTitle(SimpleElement $element = null)
    {
        $element = ($element === null) ? $this->_rootElement : $element;
        return $element->find($this->cmsPageTitle)->getText();
    }

    /**
     * Get page head title.
     *
     * @return string
     */
    public function getPageHeadTitle()
    {
        return $this->_rootElement->find($this->cmsPageHeadTitle)->getText();
    }

    /**
     * Wait for text is visible in the block.
     *
     * @param string $text
     * @return void
     */
    public function waitUntilTextIsVisible($text)
    {
        $textSelector = sprintf($this->textSelector, $text);
        $browser = $this->browser;
        $this->_rootElement->waitUntil(
            function () use ($browser, $textSelector) {
                $blockText = $browser->find($textSelector, Locator::SELECTOR_XPATH);
                return $blockText->isVisible() == true ? false : null;
            }
        );
    }

    /**
     * Check is visible widget selector.
     *
     * @param array $widgetData
     * @return bool
     * @throws \Exception
     */
    public function isWidgetVisible($widgetData)
    {
        if (isset($this->widgetSelectors[$widgetData['widget_type']])) {
            return $this->_rootElement->find(
                sprintf($this->widgetSelectors[$widgetData['widget_type']], $widgetData['anchor_text']),
                Locator::SELECTOR_XPATH
            )->isVisible();
        } else {
            throw new \Exception('Determine how to find the widget on the page.');
        }
    }
}
