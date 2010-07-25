<?php
/**
 * Textile Engine class to render textile text to HTML.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/07/24
 * @category Textile
 */
class Textile{
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
		  					array('id'=>'2','condition'=>'=','value'=>'left','template'=>'style="{float:left;}"'),
		  					array('id'=>'2','condition'=>'=','value'=>'right','template'=>'style="{float:right;}"'),
		  					array('id'=>'2','condition'=>'=','value'=>'','template'=>''),
		  					array('id'=>'3','condition'=>'copy','template'=>'id="@3"')
							)
					 ),
		'imglink'=>array( 'pattern'=>'/\{(?:imagelink\:)([^\*?!}]+)(?:\;)([^\*?!}]+)+\}/',
						 'template'=>'<a href="\2" title="\3"><img src="\1" alt="\4" /></a>',
						 'callback'=>'Textile::tagImgLink'),
		'code'=>array( 'pattern'=>'/\@([^\*]+)\@/',
					 'template'=>'<code>\1</code>',
					 'callback'=>null),
		'p'=>array( 'pattern'=>'/(?:\n)([^\*]+)\n\n/',
					 'template'=>'<p>\1</p>',
					 'callback'=>null),
		'br'=>array( 'pattern'=>'/([^\*]+)[\n]/',
					 'template'=>'\1<br />',
					 'callback'=>null),
	);


	public function Textile(){
		$diretories =dir(dirname(__FILE__)."/plugins/");
		echo "Textile::Textile() [directories:".print_r($directories,true)."]";
		foreach( $diretories as $directory){
			if (is_file($directory) && $directory != "." && $directory!=".."){
				echo $directory;
				$plugininfo = explode('.',$directory);
				$pluginName = $plugininfo[1];
				$extension = new $pluginName;
				self::addExtension($extension);
			}
		}
	}
	/**
	 * Replace options into the tag template
	 * Sample:
	 * -------
	 * - pattern: {image:path/to/image.jpg;Alt;Title;align;id}
	 * - template: <img src="\1" @0 @1 @2 @3/>
	 * - options = array(array('id'=>'0','condition'=>'copy','template'=>'alt="@1"'),
	 * 					 array('id'=>'1','condition'=>'copy','template'=>'title="@2"),
	 * 					 array('id'=>'2','condition'=>'=','value'=>'left','template'=>'style="{float:left;}"'),
	 * 					 array('id'=>'2','condition'=>'=','value'=>'right','template'=>'style="{float:right;}"'),
	 * 					 array('id'=>'2','condition'=>'=','value'=>'','template'=>''),
	 * 					 array('id'=>'3','condition'=>'copy','template'=>'id="@4")
	 *                     );
	 * then, if we have :
	 *
	 *  {image:images/cover.jpg;Cover of Game Box;Here is the cover;left;sc001}
	 *
	 * we will get :
	 *
	 *  <img src="images/cover.jpg" alt="Cover of Game Box" title="Here is the cover" style="{float:left;}" id="sc001"/>
	 *
	 * @param array $options list of options forplace holder in the template.
	 * @param string $template string cotaining place holder for parameters '@N' where N is an integer.
	 * @param array $params parameters identified into the Textile Tag with ';' separator.
	 */
	public function readOptions($options,$template,$params){
		echo "<p>params:".print_r($params,true)."</p>";
		foreach($options as $option){
			$key=$option['id'];
			echo "<p>$key:".print_r($option,true)."</p>";
			switch($option['condition']){
				case "copy":
					$template = str_replace("@".$key,str_replace("@".$key,$params[$key],$option['template']),$template);
					echo "<p>"."copie ".$option['template']."=>'".htmlentities($template)."'</p>";
					break;
				case "=":
					if($params["".$key]==$option['value']){
						$template = str_replace("@".$key,$option['template'],$template);
						echo "<p>"."égale à ".$option['value']."=>'".htmlentities($template)."'</p>";
					}
					break;
				case "!=":
					if($params["".$key]!=$option['value']){
						$template = str_replace("@".$key,$option['template'],$template);
						echo "<p>"."different de ".$option['value']."=>'".htmlentities($template)."'</p>";
					}
					break;
				case ">":
					if($params["".$key]>$option['value']){
						$template = str_replace("@".$key,$option['template'],$template);
					}
					break;
				case "<":
					if($params["".$key]<$option['value']){
						$template = str_replace("@".$key,$option['template'],$template);
					}
					break;
			}
		}
		return $template;
	}

	public function tagLink($params){
		echo "<p>Link:".print_r($params,true)."</p>";
		$tag=self::$tags['a']['template'];
		$tag= str_replace("\\1",$params[1],$tag);
		$tag= str_replace("\\2",$params[2],$tag);
		$tag= str_replace("\\3",$params[3],$tag);
		return $tag;
	}

	public function tagImg($params){
		echo "<p>image:".print_r($params,true)."</p>";
		$tag=self::$tags['img']['template'];
		$tag= str_replace("\\1",$params[1],$tag);
		//replace options by values
		$params2 = explode(';',$params[2]);
		$tag = $this->readOptions(self::$tags['img']['options'], $tag, $params2);

		return $tag;
	}
	public function tagImgLink($params){
		echo "<p>ImgLink:".print_r($params,true)."</p>";
		$tag=self::$tags['imglink']['template'];
		$tag= str_replace("\\1",$params[1],$tag);
		$tag= str_replace("\\2",$params[2],$tag);
		$tag= str_replace("\\3",$params[3],$tag);
		$tag= str_replace("\\4",$params[4],$tag);
		return $tag;
	}

	public function parse($content){
		$lines = "";
		$content = preg_replace('/\r\n/','\n',$content);
		$content = explode('\n',$content);
		// convert specific tags to HTML ones
		echo "<ul>";
		foreach($content as $line){
			echo"<li>line=<pre>$line</pre><ul>";
			foreach(self::$tags as $key=>$tag){
				if(isset($tag['callback']) && $tag['callback']!=null){
					$line = preg_replace_callback($tag['pattern'],$tag['callback'],$line);
				}else{
					$line = preg_replace($tag['pattern'],$tag['template'],$line);
				}
				echo "<li>tag=<code>$key</code> = [<pre>".htmlspecialchars($line)."</pre>]</li>";
			echo "</li>";
			}
			$lines .=$line;
			echo "</ul></li>";
		}
		echo "</ul>";
		$content=$lines;
		return $content;
	}

	/**
	 * Add an Extension to the Textile Renderer.
	 * @param TextileExtension $extension an instance of the iExtention interface.
	 * @see iExtension
	 */
	private function addExtension($extension){
		echo "add extention: ".$extension->getName();
		self::$tags[$extenstion->getName()]=$extension->getData();
	}
}
?>