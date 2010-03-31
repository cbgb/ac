<?php

/**
 * @author Petr Blazicek
 * @copyright 2010
 */
/**
 * Administrative Components
 *
 * class ACPic
 *
 * Image uploading component
 *
 * Thumbnail directory is supposed as
 * image subdirectory. If needed will be created.
 */
class ACPic extends Control
{
	protected $imagePath;

	protected $imageUri;

	protected $thumbPath;

	protected $thPrefix;

	protected $imageWidth;

	protected $imageHeight;

	protected $imageList;

	protected $rate;


	/**
	 * Constructor
	 * 
	 * @param string $imagePath	image directory
	 * @param string $thumbPath	thumbnail directory
	 * @param string $thPrefix	thumbnail prefix
	 */
	public function  __construct($imagePath, $thumbPath = NULL, $thPrefix = NULL)
	{
		parent::__construct();
		$this->imagePath = WWW_DIR . '/' . $imagePath ? $imagePath : 'images';
		$this->imageUri = Environment::getVariable('baseUri') . $imagePath;
		$this->thumbPath = $thumbPath ? $thumbPath : 'thumbs';
		$this->thPrefix = $thPrefix ? $thPrefix : 'thumb_';
		$this->imageWidth = 90;
		$this->imageHeight = 60;
		$this->rate = 'fast';
	}


	/***************** Getters & Setters ********************/

	public function getImagePath() {
		return $this->imagePath;
	}

	public function setImagePath($imagePath) {
		$this->imagePath = $imagePath;
	}

	public function getImageUri() {
		return $this->imageUri;
	}

	public function setImageUri($imageUri) {
		$this->imageUri = $imageUri;
	}

	public function getThumbPath() {
		return $this->thumbPath;
	}

	public function setThumbPath($thumbPath) {
		$this->thumbPath = $thumbPath;
	}

	public function getThPrefix() {
		return $this->thPrefix;
	}

	public function setThPrefix($thPrefix) {
		$this->thPrefix = $thPrefix;
	}

	public function getImageWidth() {
		return $this->imageWidth;
	}

	public function setImageWidth($imageWidth) {
		$this->imageWidth = $imageWidth;
	}

	public function getImageHeight() {
		return $this->imageHeight;
	}

	public function setImageHeight($imageHeight) {
		$this->imageHeight = $imageHeight;
	}

	public function getRate() {
		return $this->rate;
	}

	public function setRate($rate) {
		$this->rate = $rate;
	}


	/**
	 * Checks the thumbnail subdirectory.
	 * If not exists, is created.
	 * Missing thumbnails are created.
	 */
	protected function checkImages()
	{
		$thumbs = $this->imagePath . '/' . $this->thumbPath;
		if (!file_exists($thumbs)) mkdir($thumbs);
		$thumbs .= '/' . $this->thPrefix;
		$empty = FALSE;	//dummy picture present flag
		foreach (new DirectoryIterator($this->imagePath) as $fileInfo) {
			if ($fileInfo->isDir()) continue;
			$fileName = $fileInfo->getFileName();
			if ($fileName == 'empty.png') $empty = TRUE;
			if (!file_exists($thumbs . $fileName)) {
				$image = Image::fromFile($this->imagePath . '/' . $fileName)
					->resize($this->imageWidth, $this->imageHeight);
				$image->save($thumbs . $fileName);
			}
			$this->imageList[] = $fileName;
		}
		if (!$empty) {
			if (!copy(WWW_DIR . '/css/img/empty.png', $this->imagePath . '/empty.png'))
				die ('File not found. (empty.png)');
			$this->checkImages();
		}
	}

	/**
	 * Renders the template
	 */
	public function render()
	{
		$this->checkImages();
		$this->template->imageList = $this->imageList;
		$this->template->imageUri = $this->imageUri;
		$this->template->thumbPath = $this->thumbPath;
		$this->template->thPrefix = $this->thPrefix;
		$this->template->thumbs = $this->imageUri . '/' . $this->thumbPath . '/' . $this->thPrefix;
		$this->template->rate = $this->rate;

		$this->template->setFile(dirname(__FILE__) . '/acpic.phtml');
		$this->template->render();
	}

	/**
	 * AJAX request server handle
	 */
	public function handleServer()
	{
		foreach ($_POST as $var => $value) $$var = $value;

		$result = 'Ok';

		if (!empty($_FILES)) {				//new file uploaded

			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetFile = $this->imagePath . '/' . $_FILES['Filedata']['name'];
			if(!move_uploaded_file($tempFile, $targetFile)) $result = 'Moving uploaded file failed';
			else $this->checkImages();

		} else {											//no upload => check command

			switch ($cmd) {
				case 'delete':						//delete => delete image & thumbnail
					$path = $this->imagePath . '/' . $filename;
					$thumb = $this->imagePath . '/' . $this->thumbPath . '/' . $this->thPrefix . $filename;
					if (is_file($path)) if (!unlink($path)) $result = 'Unable to delete image ' . $filename;
					if (is_file($thumb)) if (!unlink($thumb)) $result = 'Unable to delete thumbnail ' . $this->thPrefix . $filename;
					break;
				default:									//unknown command sent
					$result = 'Unrecognised command ' . $cmd;
					break;
			}
		}
		$this->presenter->payload->result = $result;
		$this->presenter->terminate(new JsonResponse($this->presenter->payload));
	}

}

?>
