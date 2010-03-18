<?php

/**
 * @author Ladislak Liholak
 * @copyright 2010
 */

class ACGridRadio extends ACGridColumn
{
	protected $options = array();
	

	public function __construct($index, $caption = NULL, $options = NULL, $width = NULL)
	{
		parent::__construct($index, $caption, $width);
		$this->options = $options;
	}
	
	/****** Setters & Getters **********************/
	public function setOptions($v)
	{
		$this->options = $v;
	}
	public function getOptions()
	{
		return $this->options;
	}

	
	public function filter($row)
	{
		$value = $row[$this->index];
		$html = Html::el('div')->class('radio')->style(array('width' => $this->width));
		if ($this->options) foreach ($this->options as $key => $text) {
			$item = Html::el('input')->type('radio')->name($this->index . $row->id)->value($key);
			if ($key == $value) $item->checked('checked');
			$html->add($item);
			$html->create('span')->setHtml($text);
		}
		return $html;
	}
}

?>