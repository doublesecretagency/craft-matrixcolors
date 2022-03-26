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
use craft\web\assets\cp\CpAsset;

/**
 * Class ColorsAssets
 * @since 2.0.0
 */
class ColorsAssets extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        $this->sourcePath = '@doublesecretagency/matrixcolors/resources';
        $this->depends = [CpAsset::class];

        $this->js = [
            'js/matrixcolors.js',
        ];
    }

}
