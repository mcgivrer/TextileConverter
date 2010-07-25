<?php
/**
 * Textile Plugin interface to extend the existing bundle of Textile tags.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @version 1.0
 * @copyright 2010/07/24
 * @category Textile
 */
interface ITextilePlugin{
	public function getName();
	public function getPattern();
	public function getTemplate();
	public function getCallBack();
	public function getData();
}
?>