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

namespace Mage\Admin\Test\Constraint;

use Mage\Adminhtml\Test\Page\Adminhtml\Dashboard;
use Magento\Mtf\Constraint\AbstractConstraint;
use Mage\Adminhtml\Test\Page\AdminAuthLogin;

/**
 * Asserts that login form is present on page.
 */
class AssertUserSuccessLogOut extends AbstractConstraint
{
    /**
     * Constraint severeness.
     *
     * @var string
     */
    protected $severeness = 'low';

    /**
     * Asserts that login form is present on page.
     *
     * @param AdminAuthLogin $adminAuth
     * @param Dashboard $dashboard
     * @return void
     */
    public function processAssert(
        AdminAuthLogin $adminAuth,
        Dashboard $dashboard
    ) {
        $dashboard->getAdminPanelHeader()->logOut();
        $isLoginBlockVisible = $adminAuth->getLoginBlock()->isVisible();
        \PHPUnit_Framework_Assert::assertTrue($isLoginBlockVisible, 'Admin user was not logged out.');
    }

    /**
     * Return string representation of object.
     *
     * @return string
     */
    public function toString()
    {
        return 'User had successfully logged out.';
    }
}
