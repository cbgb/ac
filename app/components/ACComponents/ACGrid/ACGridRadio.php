<?php
/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Radio button list column class
 *
 */
class ACGridRadio extends ACGridColumn
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
	}
	

	/****** Setters & Getters **********************/

	public function setOptions($options) {
		$this->options = $options;
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