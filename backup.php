	private static $tags = array(
		'em'=>'/\__([^\*]+)\__/',
		'strong'=>'/\*([^\*]+)\*/',
		'a'=>'/\[([^\*]+)\;([^\*]+)\;([^\*]+)\]/',
		'img'=>'/\!([^\*]+)\;([^\*]+)\!/',
		'imglink'=>'/\{([^\*]+)\;([^\*]+);([^\*]+);([^\*]+)\}/',
		'code'=>'/\@([^\*]+)\@/',
		'p'=>'/(?:\n)([^\*]+)\n\n/',
		'br'=>'/(?:\n)([^\*]+)\n/',
	);
	private static $htmlTags = array(
		'em'=>'<em>\1</em>',
		'strong'=>'<strong>\1</strong>',
		'a'=>'<a href="\2" title="\3">\1</a>',
		'img'=>'<img src="\1" alt="\2" />',
		'imglink'=>'<a href="\2" title="\3"><img src="\1" alt="\4" /></a>',
		'code'=>'<code>\1</code>',
		'p'=>'<p>\1</p>',
		'br'=>'\1<br />'
	);
	private static $callbacks=array(
		'em'=>null,
		'strong'=>null,
		'a'=>'tagLink',
		'img'=>'tagImage',
		'imglink'=>'tagLinkImage',
		'code'=>null,
		'p'=>null,
		'br'=>null,
	);


