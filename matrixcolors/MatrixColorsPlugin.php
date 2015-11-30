<?php
namespace Craft;

class MatrixColorsPlugin extends BasePlugin
{

	private $_matrixBlockColors;

	public function init()
	{
		parent::init();
		if (craft()->request->isCpRequest()) {
			$this->_colorBlocks();
		}
	}

	public function getName()
	{
		return Craft::t('Matrix Colors');
	}

	public function getDescription()
	{
		return 'Identify your matrix blocks by giving each type a different color.';
	}

	public function getDocumentationUrl()
	{
		return 'https://github.com/lindseydiloreto/craft-matrixcolors';
	}

	public function getVersion()
	{
		return '1.1.0';
	}

	public function getSchemaVersion()
	{
		return '1.1.0';
	}

	public function getDeveloper()
	{
		return 'Double Secret Agency';
	}

	public function getDeveloperUrl()
	{
		return 'https://github.com/lindseydiloreto/craft-matrixcolors';
		//return 'http://doublesecretagency.com';
	}

	protected function defineSettings()
	{
		return array(
			'matrixBlockColors' => array(AttributeType::Mixed, 'label' => 'Matrix Block Colors', 'default' => array()),
		);
	}

	public function getSettingsHtml()
	{
		// If not set, create a default row
		if (!$this->_matrixBlockColors) {
			$this->_matrixBlockColors = array(array('blockType' => '', 'backgroundColor' => ''));
		}
		// Generate table
		$matrixBlockColorsTable = craft()->templates->renderMacro('_includes/forms', 'editableTableField', array(
			array(
				'label'        => Craft::t('Block Type Colors'),
				'instructions' => Craft::t('Add background colors to your matrix block types'),
				'id'           => 'matrixBlockColors',
				'name'         => 'matrixBlockColors',
				'cols'         => array(
					'blockType' => array(
						'heading' => Craft::t('Block Type Handle'),
						'type'    => 'singleline',
					),
					'backgroundColor' => array(
						'heading' => Craft::t('CSS Background Color'),
						'type'    => 'singleline',
						'class'   => 'code',
					),
				),
				'rows' => $this->_matrixBlockColors,
				'addRowLabel'  => Craft::t('Add a block type color'),
			)
		));
		// Output settings template
		return craft()->templates->render('matrixcolors/_settings', array(
			'matrixBlockColorsTable' => TemplateHelper::getRaw($matrixBlockColorsTable),
		));
	}

	private function _colorBlocks()
	{
		$this->_matrixBlockColors = $this->getSettings()->matrixBlockColors;
		$blockColors = '';
		if ($this->_matrixBlockColors) {
			foreach ($this->_matrixBlockColors as $row) {
				if ($blockColors) {$blockColors .= ',';}
				$blockColors .= "'{$row['blockType']}':'{$row['backgroundColor']}'";
			}
		}
		craft()->templates->includeJs('var blockColors = {'.$blockColors.'};');
		craft()->templates->includeJsResource('matrixcolors/js/matrixcolors.js');
	}

}
