<?php
include_once("private/autoloader.php");

$content="{image:images/image.jpg;sample image;A sample image on left;left;cover}*Lorem ipsum* dolor sit amet, consectetur adipiscing elit. Aliquam aliquam dignissim ligula eget iaculis. Vestibulum odio velit, tristique nec molestie et, porta a magna. Donec sit amet mollis dolor. Nulla facilisi. Nulla a ligula sapien. Phasellus at diam id dolor vehicula consequat. Vivamus a neque at nibh consequat tempor. Sed nibh nisi, ultrices eget pharetra sed, consequat a sem. Quisque quis nisi vel massa ullamcorper viverra sed nec arcu. Donec varius aliquet tempor. Donec tincidunt, quam vitae faucibus feugiat, lacus quam mollis neque, ut gravida ante dui nec est. Sed dui mi, aliquam at tempus vitae, consequat ut magna. Nulla eu sem id nulla pretium luctus. Quisque vehicula libero et erat luctus adipiscing. Donec tincidunt, augue a scelerisque lacinia, lorem sapien gravida massa, et accumsan tortor felis ut elit. Quisque sit amet pellentesque orci. Nam lectus felis, ornare vitae congue in, ultricies eget augue. Suspendisse potenti. Integer non turpis ipsum. Maecenas fringilla ullamcorper arcu.\n\n".
		"{image:images/image.jpg;a sample image;A sample image on right;right;cover}__Duis fermentum malesuada ipsum__, quis bibendum diam tincidunt non. Donec ut leo in metus vulputate aliquam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi vitae pulvinar nisi. Proin ac bibendum mi. Cras at metus sit amet mauris laoreet consequat sit amet at arcu. Nam dolor nibh, dictum vel pellentesque quis, pulvinar sed justo. Suspendisse dapibus augue a lectus vulputate ut dignissim nisl convallis. In hac habitasse platea dictumst. Praesent eleifend, quam vitae ultricies fermentum, massa orci varius ipsum, ac tempor orci est vitae est. Morbi commodo ligula at sem suscipit sit amet lacinia lectus tempor. Nam a lorem lorem, sed vestibulum tellus. Ut a urna risus, vel faucibus mi. Morbi fermentum purus imperdiet nulla rutrum vel gravida augue sodales. Mauris porta ultricies lacinia. Quisque hendrerit cursus urna vel posuere.\n\n".
		"[my Link;http://www.mylink.com;My title for my URL]\n".
		"\n".
		"{imagelink:images/icons/add.png;?add&id=1;Add this article;Add}\n".
		"{gallery:Title of the gallery;image1:title image1:alt image1,image2:title image2:alt image2,image3:title image3:alt image3,}\n".
		"@myVariable=122;@\n";

$content_initial=$content;
$textile = new Textile();

$content = $textile->parse($content);

include_once("templates/index.tpl");
?>
