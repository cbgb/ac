<?php
/**
 * Description of ACPic
 *
 * @author Petr Blažíček
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


	public function  __construct($imagePath, $thumbPath = NULL, $thPrefix = NULL)
	{
		parent::__construct();
		$this->imagePath = WWW_DIR . '/' . $imagePath ? $imagePath : 'images';
		$this->imageUri = Environment::getVariable('baseUri') . $imagePath;
		$this->thumbPath = $thumbPath ? $thumbPath : 'thumbs';
		$this->thPrefix = $thPrefix ? $thPrefix : 'thumb_';
		$this->imageWidth = 90;
		$this->imageHeight = 60;
	}


	/***************** Getters & Setters ********************/
	public function setImagePath($imagePath) {
		$this->imagePath = $imagePath;
	}

	public function setImageUri($imageUri) {
		$this->imageUri = $imageUri;
	}

	public function setThumbPath($thumbPath) {
		$this->thumbPath = $thumbPath;
	}

	public function setThPrefix($thPrefix) {
		$this->thPrefix = $thPrefix;
	}

	public function setImageWidth($imageWidth) {
		$this->imageWidth = $imageWidth;
	}

	public function setImageHeight($imageHeight) {
		$this->imageHeight = $imageHeight;
	}

	public function setListId($listId) {
		$this->listId = $listId;
	}


	protected function checkImages()
	{
		$thumbs = $this->imagePath . '/' . $this->thumbPath . '/' . $this->thPrefix;
		foreach (new DirectoryIterator($this->imagePath) as $fileInfo) {
			if ($fileInfo->isDir()) continue;
			$fileName = $fileInfo->getFileName();
			if (!file_exists($thumbs . $fileName)) {
				$image = Image::fromFile($this->imagePath . '/' . $fileName)
					->resize($this->imageWidth, $this->imageHeight);
				$image->save($thumbs . $fileName);
			}
			$this->imageList[] = $fileName;
		}
	}

	public function render()
	{
		$this->checkImages();
		$this->template->imageList = $this->imageList;
		$this->template->imageUri = $this->imageUri;
		$this->template->thumbPath = $this->thumbPath;
		$this->template->thPrefix = $this->thPrefix;
		$this->template->thumbs = $this->imageUri . '/' . $this->thumbPath . '/' . $this->thPrefix;

		$this->template->setFile(dirname(__FILE__) . '/acpic.phtml');
		$this->template->render();
	}

	public function handleServer()
	{
		foreach ($_POST as $var => $value) $$var = $value;

		$res = 'Ok';									//suppose success

		if (!empty($_FILES)) {				//new file uploaded
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetFile = $this->imagePath . '/' . $_FILES['Filedata']['name'];
			if(move_uploaded_file($tempFile,$targetFile)) {
				$this->checkImages();
				$res = '1';
			}
		} else {											//no upload => check command
			switch ($cmd) {
				case 'delete':						//delete => delete image & thumbnail
					$path = $this->imagePath . '/' . $filename;
					$thumb = $this->imagePath . '/' . $this->thumbPath . '/' . $this->thPrefix . $filename;
					if (is_file($path)) if (!unlink($path)) $res = 'Unable to delete image ' . $filename;
					if (is_file($thumb)) if (!unlink($thumb)) $res = 'Unable to delete thumbnail ' . $this->thPrefix . $filename;
					break;
				default:									//unknown command sent
					$res = 'Unrecognised command ' . $cmd;
					break;
			}
			if ($type == 'json') {			//format the response
				$wrk['result'] = $res;
				$res = json_encode($wrk);
			}
		}
		die ($res);
	}

}
?>
