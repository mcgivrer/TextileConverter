<?php
include_once("private/autoloader.php");

$content="\n*bold*\n\n".
		"__italic__\n".
		"[my Link;http://www.mylink.com;My title for my URL]\n".
		//"{image:path/to/image.jpg;Alt;Title;align;id}",
		"{image:images/image.jpg;a sample image;Title for this sample image;left;cover}\n".
		"{imagelink:images/icons/add.png;?add&id=1;Add this article;Add}\n".
		"{gallery:Title of the gallery;image1:title image1:alt image1,image2:title image2:alt image2,image3:title image3:alt image3,}\n".
		"@myVariable=122;@\n";

$content_initial=$content;
$textile = new Textile();

$content = $textile->parse($content);

include_once("index.tpl");
?>
