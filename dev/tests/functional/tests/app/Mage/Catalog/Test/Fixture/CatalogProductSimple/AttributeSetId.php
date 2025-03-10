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

use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Fixture\FixtureFactory;
use Mage\Catalog\Test\Fixture\CatalogAttributeSet;

/**
 * Preset for AttributeSetId.
 *
 *  Data keys:
 *  - dataset
 *  - attribute_set
 */
class AttributeSetId implements FixtureInterface
{
    /**
     * Attribute Set name.
     *
     * @var string
     */
    protected $data;

    /**
     * Attribute Set fixture.
     *
     * @var CatalogAttributeSet
     */
    protected $attributeSet;

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['dataset']) && $data['dataset'] !== '-') {
            $attributeSet = $fixtureFactory->createByCode('catalogAttributeSet', ['dataset' => $data['dataset']]);
            if (!$attributeSet->hasData('attribute_set_id')) {
                $attributeSet->persist();
            }
        }
        if (isset($data['attribute_set']) && $data['attribute_set'] instanceof CatalogAttributeSet) {
            $attributeSet = $data['attribute_set'];
        }
        /** @var CatalogAttributeSet $attributeSet */
        if (!isset($data['dataset']) && !isset($data['attribute_set'])) {
            $this->data = $data;
        } else {
            $this->data = $attributeSet->getAttributeSetName();
            $this->attributeSet = $attributeSet;
        }
    }

    /**
     * Persist attribute options.
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
     * @param string|null $key
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getData($key = null)
    {
        return $this->data;
    }

    /**
     * Return Attribute Set fixture.
     *
     * @return CatalogAttributeSet
     */
    public function getAttributeSet()
    {
        return $this->attributeSet;
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
}
