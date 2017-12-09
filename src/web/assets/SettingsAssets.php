<?php
/**
 * Matrix Colors plugin for Craft CMS
 *
 * Identify your matrix blocks by giving each type a different color.
 *
 * @author    Double Secret Agency
 * @link      https://www.doublesecretagency.com/
 * @copyright Copyright (c) 2014 Double Secret Agency
 */

namespace doublesecretagency\matrixcolors\web\assets;

use craft\web\AssetBundle;

/**
 * Class SettingsAssets
 * @since 2.0.0
 */
class SettingsAssets extends AssetBundle
{

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $this->sourcePath = '@doublesecretagency/matrixcolors/resources';

        $this->js = [
            'js/settings.js',
        ];
    }

}