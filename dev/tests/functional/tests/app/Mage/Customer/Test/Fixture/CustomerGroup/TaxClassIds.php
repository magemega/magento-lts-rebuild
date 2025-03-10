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

namespace Mage\Customer\Test\Fixture\CustomerGroup;

use Mage\Tax\Test\Fixture\TaxClass;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\Fixture\FixtureInterface;

/**
 * Tax class ids source for customer group.
 *
 * Data keys:
 *  - dataset
 */
class TaxClassIds implements FixtureInterface
{
    /**
     * Tax class name.
     *
     * @var string
     */
    protected $data;

    /**
     * TaxClass fixture.
     *
     * @var TaxClass
     */
    protected $taxClass;

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data)
    {
        $this->params = $params;
        if (isset($data['dataset'])) {
            /** @var TaxClass $taxClass */
            $taxClass = $fixtureFactory->createByCode('taxClass', ['dataset' => $data['dataset']]);
            if (!$taxClass->hasData('id')) {
                $taxClass->persist();
            }
            $this->data = $taxClass->getClassName();
            $this->taxClass = $taxClass;
        }
    }

    /**
     * Persist Tax class.
     *
     * @return void
     */
    public function persist()
    {
        //
    }

    /**
     * Return prepared data set.
     *
     * @param $key [optional]
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getData($key = null)
    {
        return $this->data;
    }

    /**
     * Return TaxClass fixture.
     *
     * @return TaxClass
     */
    public function getTaxClass()
    {
        return $this->taxClass;
    }

    /**
     * Return data set configuration settings.
     *
     * @return string
     */
    public function getDataConfig()
    {
        return $this->params;
    }
}
