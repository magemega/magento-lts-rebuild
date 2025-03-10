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

namespace Mage\Catalog\Test\Fixture\CatalogProductSimple;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Repository\RepositoryFactory;

/**
 * Preset for price.
 *
 * Data keys:
 *  - preset (Price verification preset name)
 *  - value (Price value)
 *
 */
class Price extends DataSource
{
    /**
     * Current preset.
     *
     * @var string
     */
    protected $priceData;

    /**
     * @constructor
     * @param RepositoryFactory $repositoryFactory
     * @param array $params
     * @param array $data
     */
    public function __construct(RepositoryFactory $repositoryFactory, array $params, $data = [])
    {
        $this->params = $params;
        $this->data = (!isset($data['dataset']) && !isset($data['value'])) ? $data : null;

        if (isset($data['value'])) {
            $this->data = $data['value'];
        }

        if (isset($data['dataset']) && isset($this->params['repository'])) {
            $this->priceData = $repositoryFactory->get($this->params['repository'])->get($data['dataset']);
        }
    }

    /**
     * Get price data for different pages.
     *
     * @return array|null
     */
    public function getPriceData()
    {
        return $this->priceData;
    }
}
