<?php
/**
 * Textile Engine class to render textile text to HTML.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/07/24
 * @category Textile
 */
class Textile extends ParseOptions{
	
	/**
	 * Internal Tags definitions
	 */
	private static $tags = array(
		'em'=>array( 'pattern'=>'/\__([^\*]+)\__/',
					 'template'=>'<em>\1</em>',
					 'callback'=>null),
		'strong'=>array( 'pattern'=>'/\*([^\*]+)\*/',
					 'template'=>'<strong>\1</strong>',
					 'callback'=>null),
		'a'=>array( 'pattern'=>'/\[([^\*?!}]+)\;([^\*?!}]+)\;([^\*?!}]+)\]/',
					 'template'=>'<a href="\2" title="\3">\1</a>',
					 'callback'=>'Textile::tagLink'),
		'img'=>array( 'pattern'=>'/\{(?:image\:)([^\*?!}]+.[gif|png|jpg])(?:\;)([^\*?!}]+)+\}/',
					 'template'=>'<img src="\1" @0 @1 @2 @3/>',
					 'callback'=>'Textile::tagImg',
					 'options' => array(
							array('id'=>'0','condition'=>'copy','template'=>'alt="@0"'),
		  					array('id'=>'1','condition'=>'copy','template'=>'title="@1"'),
		  					array('id'=>'2','condition'=>'=','value'=>'left','template'=>'style="float:left;"'),
		  					array('id'=>'2','condition'=>'=','value'=>'right','template'=>'style="float:right;"'),
		  					array('id'=>'2','condition'=>'=','value'=>'','template'=>''),
		  					array('id'=>'3','condition'=>'copy','template'=>'id="@3"')
							)
					 ),
		'imglink'=>array( 'pattern'=>'/\{(?:imagelink\:)([^\*?!}]+)(?:\;)([^\*?!}]+)\}/',
						 'template'=>'<a href="@1" @2 @4><img src="@0" @3 /></a>',
						 'callback'=>'Textile::tagImgLink',
					 	 'options'=>array(
					 		array('id'=>'0','contition'=>'copy','template'=>'src="@0"'),
					 		array('id'=>'1','condition'=>'copy','template'=>'@1'),
					 		array('id'=>'2','condition'=>'copy','template'=>'title="@2"'),
					 		array('id'=>'3','condition'=>'copy','template'=>'alt="@3"'),
					 		array('id'=>'4','condition'=>'copy','template'=>'id="@4"'),
					 		)),
		'code'=>array( 'pattern'=>'/\@([^\*]+)\@/',
					 'template'=>'<code>\1</code>',
					 'callback'=>null),
	);
	
	/**
	 * Default constructor for Textile Class.
	 */
	public function __construct(){
		if(!isset(self::$log)){
			self::$log = new Logger(__CLASS__);
		}
		$directories = opendir(dirname(__FILE__)."/plugins/");
		self::$log->debug("Textile::Textile() [directories:".print_r($directories,true)."]");
		
		while (($file = readdir($directories)) !== false) {
			self::$log->debug("Textile::Textile() : parse file :'".print_r($file,true)."'");
			if (is_file(dirname(__FILE__)."/plugins/".$file) && $file != "." && $file!=".."){
				$plugininfo = explode('.',$file);
				$pluginName = $plugininfo[0];
				self::$log->debug("Textile::Textile() : instanciate :'$pluginName'");
				$extension = new $pluginName;
				$this->addExtension($extension);
			}
		}
        closedir($directories);
	}
	
	public function tagLink($params){
		self::$log->debug("Link:".print_r($params,true));
		$tag=self::$tags['a']['template'];
		$tag= str_replace("\\1",$params[1],$tag);
		$tag= str_replace("\\2",$params[2],$tag);
		$tag= str_replace("\\3",$params[3],$tag);
		return $tag;
	}

	public function tagImg($params){
		self::$log->debug("image:".print_r($params,true));
		$tag=self::$tags['img']['template'];
		$tag= str_replace("\\1",$params[1],$tag);
		//replace options by values
		$params2 = explode(';',$params[2]);
		$tag = $this->readOptions(self::$tags['img']['options'], $tag, $params2);

		return $tag;
	}
	public function tagImgLink($params){
		self::$log->debug("ImgLink:".print_r($params,true));
		$tag=self::$tags['imglink']['template'];
		$tag= str_replace("\\1",$params[1],$tag);
		$tag= str_replace("\\2",$params[2],$tag);
		$tag= str_replace("\\3",$params[3],$tag);
		$tag= str_replace("\\4",$params[4],$tag);
		return $tag;
	}

	public function parse($content){
		$lines = "";
		//$content = preg_replace('/\r\n/','\n',$content);	
		
		$content = explode('\n',$content);
		// convert specific tags to HTML ones
		foreach($content as $line){
			self::$log->debug("line=$line");
			$line = str_replace("\r\n","\n",$line);
			$line = str_replace("\n\n","</p><p>",$line);
			$line = str_replace("\n","<br />\n",$line);
			$line = str_replace("</p><p>","</p>\n<p>",$line);
			foreach(self::$tags as $key=>$tag){
				if(isset($tag['callback']) && $tag['callback']!=null){
					$line = preg_replace_callback($tag['pattern'],$tag['callback'],$line);
				}else{
					$line = preg_replace($tag['pattern'],$tag['template'],$line);
				}
				self::$log->debug("tag=$key => [$line]");
			}
			$lines .=$line;
		}
		$content="<p>".$lines."</p>";
		return $content;
	}

	/**
	 * Add an Extension to the Textile Renderer.
	 * @param TextileExtension $extension an instance of the iExtention interface.
	 * @see iExtension
	 */
	private function addExtension($extension){
		self::$log->debug("add extention: ".$extension->getName()."[".print_r($extension->getData(),true)."]");
		self::$tags[$extension->getName()]=$extension->getData();
		//echo "loaded tags: <pre>".print_r(self::$tags,true)."</pre>";
	}
}
?>