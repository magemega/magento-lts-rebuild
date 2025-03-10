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

namespace Mage\Cms\Test\Fixture\CmsPage;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\Fixture\FixtureInterface;

/**
 * Prepare content for cms page.
 */
class Content extends DataSource
{
    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @constructor
     * @param array $params
     * @param array $data
     * @param FixtureFactory $fixtureFactory
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->fixtureFactory = $fixtureFactory;
        $this->params = $params;
        $this->data = $data;
        if (isset($data['widget']['preset'])) {
            $this->data['widget']['preset'] = $this->getPreset($data['widget']['preset']);
        }
    }

    /**
     * Preset for Widgets.
     *
     * @param string $name
     * @return array|null
     */
    protected function getPreset($name)
    {
        $presets = [
            'default' => [
                'widget_1' => [
                    'widget_type' => 'CMS Page Link',
                    'anchor_text' => 'CMS Page Link anchor_text_%isolation%',
                    'title' => 'CMS Page Link anchor_title_%isolation%',
                    'template' => 'CMS Page Link Block Template',
                    'chosen_option' => [
                        'filter_url_key' => 'home',
                    ],
                ],
            ],
        ];
        if (!isset($presets[$name])) {
            return null;
        }
        return $presets[$name];
    }
}
