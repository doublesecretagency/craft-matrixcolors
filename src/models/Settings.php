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

namespace doublesecretagency\matrixcolors\models;

use craft\base\Model;

/**
 * Class Settings
 * @since 2.0.0
 */
class Settings extends Model
{

    /**
     * @var mixed|null Mapping of colors for Matrix block types.
     */
    public mixed $matrixBlockColors = [];

}
