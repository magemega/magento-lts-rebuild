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
 * Class for Fpt preset.
 *
 * Data keys:
 *  - preset (Price options preset name)
 */
class Fpt extends DataSource
{
    /**
     * @constructor
     * @param RepositoryFactory $repositoryFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(RepositoryFactory $repositoryFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['dataset']) && isset($this->params['repository'])) {
            $this->data = $repositoryFactory->get($this->params['repository'])->get($data['dataset']);
        }
    }
}
