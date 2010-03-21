<?php
/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Administrative Components
 *
 * class ACGridSelect
 *
 * Selectbox driven column class
 */
class ACGridSelect extends ACGridColumn
{
	protected $options = array();


	/**
	 * Constructor
	 *
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param array $options	options associative array
	 * @param string $width		column width
	 */
	public function __construct($index, $caption = NULL, $options = NULL, $width = NULL)
	{
		parent::__construct($index, $caption, $width);
		$this->options = $options;
		if ($options) $this->createSelectbox();
	}

	/****** Setters & Getters **********************/

	public function setOptions($options)
	{
		$this->options = $options;
		$this->createSelectbox();
	}


	/**
	 * Render the html block
	 *
	 * @param DibiFluent $row	table row
	 * @return string					html block
	 */
	public function filter($row)
	{
		$value = $row[$this->index];
		$content = $this->options ? $this->options[$value] : $value;
		$html = Html::el('div')->class('select')
			->style(array('width' => $this->width ? $this->width : '10em'))->setHtml($content);
		return $html;
	}
	
	/**
	 * Assemble the hidden selectbox
	 */
	protected function createSelectbox()
	{
		$html = Html::el('select')->id('sel' . $this->index)->class('acSelect')
			->style(array('width' => $this->width ? $this->width : '10em'));
		foreach ($this->options as $key => $text)
			$html->create('option')->value($key)->setHtml($text);
		$this->html = $html;
	}

}
//TODO: options from database
?>