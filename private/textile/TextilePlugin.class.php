<?php
/**
 * Textile Plugin class to extend the existing bundle of Textile tags.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/07/24
 * @category Textile
 */
abstract class TextilePlugin implements ITextilePlugin{
	/**
	 * data for this Textile Plugin
	 * @var array
	 */
	private $_data=array(
				'name'=>__CLASS__,
				'pattern'=>"",
				'template'=>"",
				'callback'=>"");

	public function __construct(){
		self::$_data['callback']=__CLASS__."::render";
		self::$_data['name']=self::getName();
		self::$_data['pattern']=self::getPattern();
		self::$_data['template']=self::getTemplate();
		self::$_data['callback']=self::getCallBack();
	}
	public abstract function getName();
	public abstract function getPattern();
	public abstract function getTemplate();
	public abstract function getCallBack();
	public abstract function getData();
	public abstract function render(){

	}
}
?>