<?php
class GalleryTextilePlugin extends TextilePlugin implements ITextilePlugin{
	public function getName(){
		return "gallery";
	}
	public function getPattern(){
		return "/\{(?:gallery\:)([^\*]+);([^\*]+)\}/";

	}
	public function getTemplate(){
		return '<div id="\1url"><div class="legend">\1</div><div class="images">{lOOP_1}<div class="">< a href="\2"><img src="\2"></a><p>\3</p></div>{/LOOP_1}</div></div>';
	}
	public function render($line,$TextileContext){
	}
}
?>