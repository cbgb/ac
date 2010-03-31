<?php
/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Administrative Components
 *
 * class ACGridDateTime
 *
 * Date - time column class
 */
class ACGridDateTime extends ACGridColumn
{
	/** @var string */
	protected $format;


	/**
	 * Constructor
	 *
	 * @param string $index		column index
	 * @param string $caption	column caption
	 * @param string $format	column date - time format
	 * @param string $width		column width
	 */
	public function __construct($index, $caption = NULL, $format = 'j.n.Y H:i:s', $width = NULL)
	{
		parent::__construct($index, $caption, $width);
		$this->format = $format;
	}


	/****** Setters & Getters **********************/

	public function getFormat() {
		return $this->format;
	}

	public function setFormat($format) {
		$this->format = $format;
	}


	/**
	 * Render the html block
	 *
	 * @param DibiFluent $row	table row
	 * @return string					html block
	 */
	public function render($row)
	{
		$value = $row[$this->index];
		$html = Html::el('div')->class('datetime')->setHtml(date($this->format, $value));
		return $html;
	}

}

?>