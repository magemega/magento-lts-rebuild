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

namespace Mage\Cms\Test\Constraint;

use Mage\Catalog\Test\Page\Category\CatalogCategoryView;
use Mage\Cms\Test\Fixture\CmsBlock;
use Mage\Cms\Test\Page\CmsIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Assert that created CMS block non visible on frontend category page.
 */
class AssertCmsBlockNotOnCategoryPage extends AbstractConstraint
{
    /**
     * Assert that created CMS block non visible on frontend category page.
     *
     * @param CmsIndex $cmsIndex
     * @param CmsBlock $cmsBlock
     * @param CatalogCategoryView $catalogCategoryView
     * @param FixtureFactory $fixtureFactory
     * @return void
     */
    public function processAssert(
        CmsIndex $cmsIndex,
        CmsBlock $cmsBlock,
        CatalogCategoryView $catalogCategoryView,
        FixtureFactory $fixtureFactory
    ) {
        $category = $fixtureFactory->createByCode(
            'catalogCategory',
            [
                'dataset' => 'default_subcategory',
                'data' => [
                    'display_mode' => 'Static block and products',
                    'landing_page' => $cmsBlock->getTitle(),
                ]
            ]
        );
        $category->persist();
        $cmsIndex->open();
        $cmsIndex->getTopmenu()->selectCategory($category->getName());
        $categoryViewContent = $catalogCategoryView->getViewBlock()->getText();
        $cmsBlockContent = explode("\n", $categoryViewContent);
        \PHPUnit_Framework_Assert::assertNotContains($cmsBlock->getContent(), $cmsBlockContent);
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'CMS block description is absent on Category page (frontend).';
    }
}
