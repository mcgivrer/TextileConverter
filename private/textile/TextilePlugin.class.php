<?php
/**
 * Textile Plugin class to extend the existing bundle of Textile tags.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/07/24
 * @category Textile
 */
abstract class TextilePlugin extends ParseOptions{

	/**
	 * data for this Textile Plugin
	 * @var array
	 */
	protected $_data=array(
				'name'=>__CLASS__,
				'pattern'=>"",
				'template'=>"",
				'callback'=>"",
				'options'=>null);

	public function TextilePlugin(){
		self::$log = new Logger(__CLASS__);
		$this->_data['callback']=__CLASS__."::render";
		$this->_data['name']=$this->getName();
		$this->_data['pattern']=$this->getPattern();
		$this->_data['template']=$this->getTemplate();
		$this->_data['callback']=$this->getCallBack();
		$this->_data['options']=$this->getOptions();
	}
	public abstract function getName();
	public abstract function getPattern();
	public abstract function getTemplate();
	public abstract function getOptions();
	public function getData(){
		return $this->_data;
	}
	public function getCallBack(){
		return __CLASS__."::render";
	}
	public function render($params){
		$tag=$this->_data['template'];
		for($i=1;$i<legnth($params);$i++){
			$tag= str_replace("\\$i",$params[$i],$tag);
		}
		//replace options by values
		if(isset($this->_data['options']) && $this->_data['options']!=null){
			$params2 = explode(';',$params[2]);
			$tag = $this->readOptions($this->_data['options'], $tag, $params2);
		}
		return $tag;
	}
}
?>