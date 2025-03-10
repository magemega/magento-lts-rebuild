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

namespace Mage\Rating\Test\Fixture\Rating;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\Fixture\InjectableFixture;
use Mage\Adminhtml\Test\Fixture\Store;

/**
 * Source stores for rating fixture.
 */
class Stores extends InjectableFixture
{
    /**
     * Configuration settings.
     *
     * @var array
     */
    protected $params;

    /**
     * Stores data.
     * For example: ['0' => 'Main Website/Main Website Store/Default Store View']
     *
     * @var array
     */
    protected $data = [];

    /**
     * The created stores.
     *
     * @var Store[]
     */
    protected $stores = [];

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['datasets'])) {
            $datasets = explode(',', $data['datasets']);
            foreach ($datasets as $dataset) {
                /** @var Store $store */
                $store = $fixtureFactory->createByCode('store', ['dataset' => $dataset]);
                if (!$store->hasData('store_id')) {
                    $store->persist();
                }
                $this->stores[] = $store;
                $this->data[] = $store->getGroupId() . '/' . $store->getName();
            }
        }
    }

    /**
     * Persist data.
     *
     * @return void
     */
    public function persist()
    {
        //
    }

    /**
     * Return id of the created entity.
     *
     * @param string|null $key [optional]
     * @return int
     */
    public function getData($key = null)
    {
        return $this->data;
    }

    /**
     * Return data set configuration settings.
     *
     * @return array
     */
    public function getDataConfig()
    {
        return $this->params;
    }

    /**
     * Get stores.
     *
     * @return array
     */
    public function getStores()
    {
        return $this->stores;
    }
}
