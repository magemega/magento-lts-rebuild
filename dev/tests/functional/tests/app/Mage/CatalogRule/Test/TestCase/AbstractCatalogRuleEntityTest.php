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

namespace Mage\CatalogRule\Test\TestCase;

use Mage\CatalogRule\Test\Page\Adminhtml\CatalogRuleIndex;
use Mage\CatalogRule\Test\Page\Adminhtml\CatalogRuleEdit;
use Magento\Mtf\TestCase\Injectable;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Parent class for CatalogRule tests.
 */
abstract class AbstractCatalogRuleEntityTest extends Injectable
{
    /**
     * Page CatalogRuleIndex.
     *
     * @var CatalogRuleIndex
     */
    protected $catalogRuleIndex;

    /**
     * Page CatalogRuleEdit.
     *
     * @var CatalogRuleEdit
     */
    protected $catalogRuleEdit;

    /**
     * Catalog Rules.
     *
     * @var array
     */
    protected $catalogRules = [];

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Delete all Catalog Rule before test.
     *
     * @return void
     */
    public function __prepare()
    {
        $this->objectManager->create('Mage\CatalogRule\Test\TestStep\DeleteAllCatalogRulesStep')->run();
    }

    /**
     * Injection data.
     *
     * @param CatalogRuleIndex $catalogRuleIndex
     * @param CatalogRuleEdit $catalogRuleEdit
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function __inject(
        CatalogRuleIndex $catalogRuleIndex,
        CatalogRuleEdit $catalogRuleEdit,
        FixtureFactory $fixtureFactory
    ) {
        $this->catalogRuleIndex = $catalogRuleIndex;
        $this->catalogRuleEdit = $catalogRuleEdit;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Clear data after test.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->objectManager->create('Mage\CatalogRule\Test\TestStep\DeleteAllCatalogRulesStep')->run();
    }
}
