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

namespace doublesecretagency\matrixcolors;

use Craft;
use craft\base\Plugin;
use craft\helpers\Template;
use craft\web\View;

use doublesecretagency\matrixcolors\models\Settings;
use doublesecretagency\matrixcolors\web\assets\SettingsAssets;
use doublesecretagency\matrixcolors\web\assets\ColorsAssets;

/**
 * Class MatrixColors
 * @since 2.0.0
 */
class MatrixColors extends Plugin
{

    /** @var Plugin  $plugin  Self-referential plugin property. */
    public static $plugin;

    /** @var array  $_matrixBlockColors  Complete mapping of matrix block colors. */
    private $_matrixBlockColors;

    /** @inheritDoc */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            $this->_colorBlocks();
        }
    }

    /**
     * @return Settings  Plugin settings model.
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @return string  The fully rendered settings template.
     */
    protected function settingsHtml(): string
    {
        // Get view
        $view = Craft::$app->getView();
        // If not set, create a default row
        if (!$this->_matrixBlockColors) {
            $this->_matrixBlockColors = [['blockType' => '', 'backgroundColor' => '']];
        }
        // Generate table
        $matrixBlockColorsTable = $view->renderTemplateMacro('_includes/forms', 'editableTableField', [
            [
                'label'        => Craft::t('matrix-colors', 'Block Type Colors'),
                'instructions' => Craft::t('matrix-colors', 'Add background colors to your matrix block types'),
                'id'           => 'matrixBlockColors',
                'name'         => 'matrixBlockColors',
                'cols'         => [
                    'blockType' => [
                        'heading' => Craft::t('matrix-colors', 'Block Type Handle'),
                        'type'    => 'singleline',
                    ],
                    'backgroundColor' => [
                        'heading' => Craft::t('matrix-colors', 'CSS Background Color'),
                        'type'    => 'singleline',
                        'class'   => 'code',
                    ],
                ],
                'rows' => $this->_matrixBlockColors,
                'addRowLabel'  => Craft::t('matrix-colors', 'Add a block type color'),
            ]
        ]);
        // Settings JS
        $view->registerAssetBundle(SettingsAssets::class);
        // Output settings template
        return $view->renderTemplate('matrix-colors/settings', [
            'matrixBlockColorsTable' => Template::raw($matrixBlockColorsTable),
        ]);
    }

    /**
     * @return void
     */
    private function _colorBlocks()
    {
        $view = Craft::$app->getView();
        $settings = $this->getSettings();
        $this->_matrixBlockColors = $settings->matrixBlockColors;
        $css = '';
        $colorList = [];
        // Loop through block colors
        if ($this->_matrixBlockColors) {
            foreach ($this->_matrixBlockColors as $row) {
                // Set color
                $color = $row['backgroundColor'];
                // Split comma-separated strings
                $types = explode(',', $row['blockType']);
                // Loop over each block type
                foreach ($types as $type) {
                    $type = trim($type);
                    // Ignore empty strings
                    if (empty($type)) {
                        continue;
                    }
                    // Add type to color list
                    $colorList[] = $type;
                    // Set CSS for type
                    $css .= "
.mc-solid-{$type} {background-color: {$color};}
.btngroup .btn.mc-gradient-{$type} {background-image: linear-gradient(white,{$color});}";
                }
            }
            // Load CSS
            $view->registerCss($css);
        }
        // Load JS
        $view->registerJs('var colorList = '.json_encode($colorList).';', View::POS_HEAD);
        $view->registerAssetBundle(ColorsAssets::class);
    }

}