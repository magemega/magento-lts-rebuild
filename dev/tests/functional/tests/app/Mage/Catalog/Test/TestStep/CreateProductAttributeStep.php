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

namespace Mage\Catalog\Test\TestStep;

use Mage\Catalog\Test\Fixture\CatalogProductAttribute;
use Mage\Catalog\Test\Page\Adminhtml\CatalogProductAttributeIndex;
use Mage\Catalog\Test\Page\Adminhtml\CatalogProductAttributeNew;
use Mage\Catalog\Test\Page\Adminhtml\CatalogProductAttributeEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Create new product attribute.
 */
class CreateProductAttributeStep implements TestStepInterface
{
    /**
     * CatalogProductAttribute fixture.
     *
     * @var CatalogProductAttribute
     */
    protected $attribute;

    /**
     * Catalog product attribute new page.
     *
     * @var CatalogProductAttributeNew
     */
    protected $attributeNew;

    /**
     * Catalog product attribute edit page.
     *
     * @var CatalogProductAttributeEdit
     */
    protected $attributeEdit;

    /**
     * Catalog Product Attribute Index page.
     *
     * @var CatalogProductAttributeIndex
     */
    protected $catalogProductAttributeIndex;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @constructor
     * @param CatalogProductAttribute $productAttribute
     * @param CatalogProductAttributeNew $attributeNew
     * @param CatalogProductAttributeEdit $attributeEdit
     * @param CatalogProductAttributeIndex $catalogProductAttributeIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __construct(
        CatalogProductAttribute $productAttribute,
        CatalogProductAttributeNew $attributeNew,
        CatalogProductAttributeEdit $attributeEdit,
        CatalogProductAttributeIndex $catalogProductAttributeIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->attribute = $productAttribute;
        $this->attributeNew = $attributeNew;
        $this->attributeEdit = $attributeEdit;
        $this->catalogProductAttributeIndex = $catalogProductAttributeIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Fill attribute form on attribute new page.
     *
     * @return array
     */
    public function run()
    {
        $this->catalogProductAttributeIndex->open();
        $this->catalogProductAttributeIndex->getPageActionsBlock()->addNew();

        $this->attributeNew->getAttributeForm()->fill($this->attribute);
        $this->attributeNew->getPageActions()->saveAndContinue();
        $this->prepareAttribute();

        return ['attribute' => $this->attribute, 'templatesData' => ['attributes' => [$this->attribute]]];
    }

    /**
     * Prepare attribute fixture.
     *
     * @return void
     */
    protected function prepareAttribute()
    {
        $data = $this->attribute->getData();
        if (isset($data['options'])) {
            $data['options'] = $this->prepareOptionsData($data['options']);
        }
        $data['attribute_id'] = $this->attributeEdit->getAttributeForm()->getAttributeId();
        $this->attribute = $this->fixtureFactory->createByCode('catalogProductAttribute', ['data' => $data]);
    }

    /**
     * Prepare options data.
     *
     * @param array $optionsData
     * @return array
     */
    protected function prepareOptionsData(array $optionsData)
    {
        return [
            'value' => $optionsData,
            'optionsIds' => $this->attributeEdit->getAttributeForm()->getOptionsIds()
        ];
    }
}
