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

namespace Mage\Adminhtml\Test\Block\Sitemap;

use Magento\Mtf\Client\Locator;

/**
 * Sitemap grid.
 */
class Grid extends \Mage\Adminhtml\Test\Block\Widget\Grid
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'sitemap_filename' => [
            'selector' => '#sitemapGrid_filter_sitemap_filename',
        ],
        'sitemap_path' => [
            'selector' => '#sitemapGrid_filter_sitemap_path',
        ],
        'sitemap_id' => [
            'selector' => '#sitemapGrid_filter_sitemap_id',
        ],
    ];

    /**
     * Locator link for Google in grid.
     *
     * @var string
     */
    protected $linkForGoogle = ".//td/a[contains(.,'.xml')]";

    /**
     * Get link for Google.
     *
     * @return string
     */
    public function getLinkForGoogle()
    {
        return $this->_rootElement->find($this->linkForGoogle, Locator::SELECTOR_XPATH)->getText();
    }
}
