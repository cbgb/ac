<?php

/**
 * @author Ladislak Liholak
 * @copyright 2010
 */

class ACGridSelect extends ACGridColumn
{
	protected $options = array();


	public function __construct($index, $caption = NULL, $options = NULL, $width = NULL)
	{
		parent::__construct($index, $caption, $width);
		$this->options = $options;
		if ($options) $this->createSelect();
	}

	/****** Setters & Getters **********************/
	public function setOptions($v)
	{
		if ($v) {
			$this->options = $v;
			$this->createSelect();
		}
	}
	public function getOptions()
	{
		return $this->options;
	}
	
	public function filter($row)
	{
		$value = $row[$this->index];
		$content = $this->options ? $this->options[$value] : $value;
		$html = Html::el('div')->class('select')
			->style(array('width' => $this->width ? $this->width : '10em'))->setHtml($content);
		return $html;
	}
	
	protected function createSelect()
	{
		$html = Html::el('select')->id('sel' . $this->index)->class('acSelect')
			->style(array('width' => $this->width ? $this->width : '10em'));
		foreach ($this->options as $key => $text)
			$html->create('option')->value($key)->setHtml($text);
		$this->html = $html;
	}

}

?>