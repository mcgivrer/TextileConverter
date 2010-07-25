<?php
Class ParseOptions{
	protected static $log;
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
		self::$log->debug("params:".print_r($params,true));
		if($options!=null){
			foreach($options as $option){
				$key=$option['id'];
				self::$log->debug("$key:".print_r($option,true));
				switch($option['condition']){
					case "copy":
						$template = str_replace("@".$key,str_replace("@".$key,$params[$key],$option['template']),$template);
						self::$log->debug("copy value into ".$option['template']."=>'$template'");
						break;
					case "=":
						if($params["".$key]==$option['value']){
							$template = str_replace("@".$key,$option['template'],$template);
							self::$log->debug("equal to ".$option['value']."=>'$template'");
						}
						break;
					case "!=":
						if($params["".$key]!=$option['value']){
							$template = str_replace("@".$key,$option['template'],$template);
							self::$log->debug("different of ".$option['value']."=>'$template'");
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
		}
		return $template;
	}
}
?>