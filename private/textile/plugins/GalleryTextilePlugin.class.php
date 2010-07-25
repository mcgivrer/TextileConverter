<?php
class GalleryTextilePlugin extends TextilePlugin{

	public function __construct(){
		$this->log = new Logger(__CLASS__);
		parent::TextilePlugin();	
	}
	
	public function getName(){
		return "gallery";
	}
	public function getPattern(){
		return "/\{(?:gallery\:)([^\*]+);([^\*]+)\}/";

	}
	public function getTemplate(){
		return '<div id="\1url"><div class="legend">\1</div><div class="images">{lOOP_1}<div class="">< a href="\2"><img src="\2"></a><p>\3</p></div>{/LOOP_1}</div></div>';
	}
	
	public function getCallBack(){
		return __CLASS__."::render()";
	}
	public function getOptions(){
		return null;
	}
}
?>