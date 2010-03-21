<?php
/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Administrative Components
 *
 * class ACGridColumn
 *
 * Column base class
 */
abstract class ACGridColumn extends Control
{
	protected $index;
	
	protected $caption;
	
	protected $width;
	
	protected $html;
	

	/**
	 * Constructor
	 *
	 * @param strind $index		column index
	 * @param <type> $caption	column caption
	 * @param <type> $width		column width
	 * @param <type> $html		extending html
	 */
	public function __construct($index, $caption = NULL, $width = NULL, $html = NULL)
	{
		$this->index = $index;
		$this->caption = $caption ? $caption : $index;
		$this->width = $width;
		$this->html = $html;
	}

	/****** Setters & Getters **********************/

	public function getIndex() {
		return $this->index;
	}

	public function setIndex($index) {
		$this->index = $index;
	}

	public function getCaption() {
		return $this->caption;
	}

	public function setCaption($caption) {
		$this->caption = $caption;
	}

	public function getWidth() {
		return $this->width;
	}

	public function setWidth($width) {
		$this->width = $width;
	}

	public function getHtml() {
		return $this->html;
	}

	public function setHtml($html) {
		$this->html = $html;
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
		$html = Html::el('div')->contenteditable('true')->class('text')->style(array('width' => $this->width))
			->setHtml($value);
		return $html;
	}
	
}

?>