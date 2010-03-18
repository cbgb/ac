<?php

/**
 * @author Ladislak Liholak
 * @copyright 2010
 */

abstract class ACGridColumn extends Control
{
	protected $index;
	
	protected $caption;
	
	protected $width;
	
	protected $html;
	

	public function __construct($index, $caption = NULL, $width = NULL, $html = NULL)
	{
		$this->index = $index;
		$this->caption = $caption ? $caption : $index;
		$this->width = $width;
		$this->html = $html;
	}

	/****** Setters & Getters **********************/
	public function setIndex($v)
	{
		$this->index = $v;
	}
	public function getIndex()
	{
		return $this->index;
	}
	public function setCaption($v)
	{
		$this->caption = $v;
	}
	public function getCaption()
	{
		return $this->caption;
	}
	public function setWidth($v)
	{
		$this->width = $v;
	}
	public function getWidth()
	{
		return $this->width;
	}	
	public function setHtml($v)
	{
		$this->html = $v;
	}
	public function getHtml()
	{
		return $this->html;
	}	


	public function filter($row)
	{
		$value = $row[$this->index];
		$html = Html::el('div')->contenteditable('true')->class('text')->style(array('width' => $this->width))
			->setHtml($value);
		return $html;
	}
	
}

?>