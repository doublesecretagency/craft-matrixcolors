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
use craft\helpers\Cp;
use craft\helpers\Json;
use craft\helpers\Template;
use craft\web\View;
use doublesecretagency\matrixcolors\models\Settings;
use doublesecretagency\matrixcolors\web\assets\ColorsAssets;
use doublesecretagency\matrixcolors\web\assets\SettingsAssets;
use yii\base\InvalidConfigException;

/**
 * Class MatrixColors
 * @since 2.0.0
 */
class MatrixColors extends Plugin
{

    /**
     * @var Plugin Self-referential plugin property.
     */
    public static Plugin $plugin;

    /**
     * @var bool The plugin has a settings page.
     */
    public bool $hasCpSettings = true;

    /**
     * @var array Complete mapping of matrix block colors.
     */
    private array $_matrixBlockColors;

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            $this->_colorBlocks();
        }
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }

    /**
     * @inheritdoc
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
        $matrixBlockColorsTable = Cp::editableTableFieldHtml([
            'label' => Craft::t('matrix-colors', "Block Type Colors"),
            'instructions' => Craft::t('matrix-colors', "Add background colors to your matrix block types."),
            'id' => 'matrixBlockColors',
            'name' => 'matrixBlockColors',
            'cols' => [
                'blockType' => [
                    'heading' => Craft::t('matrix-colors', 'Block Type Handle'),
                    'type' => 'singleline',
                ],
                'backgroundColor' => [
                    'heading' => Craft::t('matrix-colors', 'CSS Background Color'),
                    'type' => 'singleline',
                    'class' => 'code',
                ],
            ],
            'rows' => $this->_matrixBlockColors,
            'addRowLabel'  => Craft::t('matrix-colors', 'Add a block type color'),
            'allowAdd' => true,
            'allowReorder' => true,
            'allowDelete' => true,
        ]);
        // Settings JS
        $view->registerAssetBundle(SettingsAssets::class);
        // Output settings template
        return $view->renderTemplate('matrix-colors/settings', [
            'matrixBlockColorsTable' => Template::raw($matrixBlockColorsTable),
        ]);
    }

    /**
     * Register the CSS and JS necessary to colorize Matrix blocks.
     *
     * @throws InvalidConfigException
     */
    private function _colorBlocks(): void
    {
        $view = Craft::$app->getView();
        $settings = $this->getSettings();
        $this->_matrixBlockColors = $settings->matrixBlockColors ?? [];
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
        $view->registerJs('var colorList = '.Json::encode($colorList).';', View::POS_HEAD);
        $view->registerAssetBundle(ColorsAssets::class);
    }

}
