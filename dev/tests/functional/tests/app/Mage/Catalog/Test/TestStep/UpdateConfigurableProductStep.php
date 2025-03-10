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
use Mage\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Mage\Catalog\Test\Fixture\ConfigurableProduct;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\ObjectManager;
use Magento\Mtf\TestStep\TestStepInterface;
use Mage\Catalog\Test\Fixture\ConfigurableProduct\ConfigurableOptions;
use Magento\Mtf\Fixture\InjectableFixture;
use Mage\Adminhtml\Test\Block\Catalog\Product\Edit\Tab\Configurable as ConfigurableTab;
use Mage\Catalog\Test\TestStep\UpdateConfigurableProductStep\AbstractSubStep;

/**
 * Update configurable product step.
 */
class UpdateConfigurableProductStep implements TestStepInterface
{
    /**
     * List sub steps.
     *
     * @var array
     */
    protected $subSteps = ['deleteOptions', 'updateOptions', 'addOptions', 'createProduct'];

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Object manager.
     *
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Catalog product edit page.
     *
     * @var CatalogProductEdit
     */
    protected $catalogProductEdit;

    /**
     * Fixture original ConfigurableProduct.
     *
     * @var ConfigurableProduct
     */
    protected $product;

    /**
     * Configurable options edit data.
     *
     * @var array
     */
    protected $configurableOptionsEditData;

    /**
     * Current attributes fixture.
     *
     * @var array
     */
    protected $currentAttributes = [];

    /**
     * Current assigned fixtures products.
     *
     * @var array
     */
    protected $currentAssignedProducts = [];

    /**
     * Current configurable options data.
     *
     * @var array
     */
    protected $currentConfigurableOptionsData = [];

    /**
     * Checkout data for result product.
     *
     * @var array
     */
    protected $checkoutData = [];

    /**
     * @constructor
     * @param ObjectManager $objectManager
     * @param FixtureFactory $fixtureFactory
     * @param CatalogProductEdit $catalogProductEdit
     * @param ConfigurableProduct $product
     * @param array $configurableOptionsEditData
     * @param array $checkoutData [optional]
     */
    public function __construct(
        ObjectManager $objectManager,
        FixtureFactory $fixtureFactory,
        CatalogProductEdit $catalogProductEdit,
        ConfigurableProduct $product,
        array $configurableOptionsEditData,
        array $checkoutData = []
    ) {
        $this->fixtureFactory = $fixtureFactory;
        $this->objectManager = $objectManager;
        $this->catalogProductEdit = $catalogProductEdit;
        $this->product = $product;
        $this->configurableOptionsEditData = $configurableOptionsEditData;
        $this->currentAssignedProducts = $this->getOriginalProductAssignedProducts();
        $this->currentAttributes = $this->getOriginalProductAttributes();
        $this->currentConfigurableOptionsData = $this->product->getConfigurableOptions()['attributes_data'];
        $this->checkoutData = $checkoutData;
    }

    /**
     * Update configurable product.
     *
     * @return array
     */
    public function run()
    {
        $this->openConfigurableTab();
        foreach ($this->subSteps as $subStepName) {
            if (isset($this->configurableOptionsEditData[$subStepName])) {
                $subStep = $this->getSubStep($subStepName);
                $subStep->run();
                $this->updateArguments($subStep);
            }
        }

        return ['product' => $this->prepareResultProduct()];
    }

    /**
     * Get sub step.
     *
     * @param string $subStepName
     * @return AbstractSubStep
     */
    protected function getSubStep($subStepName)
    {
        $class = 'Mage\Catalog\Test\TestStep\UpdateConfigurableProductStep\\' . ucfirst($subStepName) . 'SubStep';
        $arguments = [
            'product' => $this->product,
            'configurableOptionsEditData' => $this->configurableOptionsEditData,
            'currentAssignedProducts' => $this->currentAssignedProducts,
            'currentAttributes' => $this->currentAttributes,
            'currentConfigurableOptionsData' => $this->currentConfigurableOptionsData,
            'checkoutData' => $this->checkoutData

        ];

        return $this->objectManager->create($class, $arguments);
    }

    /**
     * Update local arguments.
     *
     * @param AbstractSubStep $subStep
     * @return void
     */
    protected function updateArguments(AbstractSubStep $subStep)
    {
        $returnSubStepArguments = $subStep->returnArguments();
        foreach ($returnSubStepArguments as $argumentName => $value) {
            $this->$argumentName = $value;
        }
    }

    /**
     * Prepare result product.
     *
     * @return ConfigurableProduct
     */
    protected function prepareResultProduct()
    {
        $originalProductData = $this->product->getData();
        $originalProductData['configurable_options'] = $this->getCurrentConfigurableOptions();
        $originalProductData['price'] = ['value' => $this->product->getPrice()];
        if (!empty($this->checkoutData)) {
            $originalProductData['checkout_data'] = $this->checkoutData;
        }

        return $this->fixtureFactory->createByCode('configurableProduct', ['data' => $originalProductData]);
    }

    /**
     * Get current configurable options.
     *
     * @return array
     */
    protected function getCurrentConfigurableOptions()
    {
        return !empty($this->currentAssignedProducts)
            ? [
                'data' => [
                    'data' => ['attributes_data' => $this->currentConfigurableOptionsData],
                    'attributes_data' => [
                        'attributes' => $this->currentAttributes,
                        'attributeSet' => $this->getOriginalProductOptionsSource()->getAttributeSet()
                    ],
                    'assigned_product' => $this->currentAssignedProducts
                ]
            ]
            : [];
    }

    /**
     * Open configurable specify tab.
     *
     * @return void
     */
    protected function openConfigurableTab()
    {
        $this->catalogProductEdit->getProductForm()->openTab('configurable');
    }

    /**
     * Get assigned products from original configurable product.
     *
     * @return InjectableFixture[]
     */
    protected function getOriginalProductAssignedProducts()
    {
        return $this->getOriginalProductOptionsSource()->getProducts();
    }

    /**
     * Get attributes' fixtures for original product.
     *
     * @return CatalogProductAttribute[]
     */
    protected function getOriginalProductAttributes()
    {
        return $this->getOriginalProductOptionsSource()->getAttributesData();
    }

    /**
     * Get configurable options source for original product.
     *
     * @return ConfigurableOptions
     */
    protected function getOriginalProductOptionsSource()
    {
        return $this->product->getDataFieldConfig('configurable_options')['source'];
    }
}
