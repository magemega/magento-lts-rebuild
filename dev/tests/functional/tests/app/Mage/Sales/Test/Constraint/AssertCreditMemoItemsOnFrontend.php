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

namespace Mage\Sales\Test\Constraint;

use Mage\Sales\Test\Page\CreditMemoView;
use Magento\Mtf\ObjectManager;
use Magento\Mtf\Fixture\InjectableFixture;
use Magento\Mtf\System\Event\EventManagerInterface;

/**
 * Assert that credit memo items is equal to data from fixture on 'My Account' page.
 */
class AssertCreditMemoItemsOnFrontend extends AbstractAssertSalesEntityItemsOnFrontend
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Entity type.
     *
     * @var string
     */
    protected $entityType = 'refund';

    /**
     * Special fields for verify.
     *
     * @var array
     */
    protected $specialFields = [
        'item_price',
        'item_subtotal',
        'item_discount',
        'item_row_total'
    ];

    /**
     * @constructor
     * @param ObjectManager $objectManager
     * @param EventManagerInterface $eventManager
     * @param CreditMemoView $creditMemoView
     */
    public function __construct(
        ObjectManager $objectManager,
        EventManagerInterface $eventManager,
        CreditMemoView $creditMemoView
    )
    {
        parent::__construct($objectManager, $eventManager);
        $this->salesTypeViewPage = $creditMemoView;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Credit memo items quantity is equal to data from fixture on "My Account" page.';
    }
}
