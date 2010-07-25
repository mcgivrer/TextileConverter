<?php

set_error_handler("Logger::errorHandler");


/**
 * A simple but powerfull Logger Class for PHP application.
 * @author Frederic Delorme<frederic.delorme@gmail.com>
 * @copyright 2010/07/25
 * @version 1.0
 */
class Logger{
	/**
	 * Default log file path.
	 * @var String
	 */
	private $logpath="../log";
	
	/**
	 * Default log file name.
	 * @var String
	 */
	private $logfile="webapplog.txt";
	
	/**
	 * Default log level.
	 * @var String
	 */
	private $loglevel="DEBUG,INFO,WARN,ERROR,FATAL";
	/**
	 * Initialize Log file (if it not already exists).
	 */
	public function __construct(){
		if(!file_exists(dirname(__FILE__)."/".$this->logpath)){
			mkdir(dirname(__FILE__)."/".$this->logpath);
		}
		$log = fopen(dirname(__FILE__)."/".$this->logpath."/".$this->logfile, "a+");
		fclose($log);
	}
	/**
	 * Write a message on the log file.
	 * Enter description here ...
	 * @param String $level can be DEBUG, INFO, WARN, ERROR or FATAL
	 * @param String $message the message (text) to be output to log file.
	 * @throws Exception and exception can be raised in case of file unwritable.
	 */	
	protected function writeMessage($level,$message){
		$log = fopen(dirname(__FILE__)."/".$this->logpath."/".$this->logfile, "a+");
		if($log && strstr($this->loglevel,$level)!=false){
			fprintf($log, "%s-%s: %s\n",date("Y/M/d-h:i:s"), $level,$message);
			fclose($log);
		}else{
			throw new Exception("Error while trying to write the log trace on '".dirname(__FILE__).$this->logpath."/".$this->logfile."'");
		}
	}
	
	/**
	 * Set a different trace level.
	 * sample: INFO,WARN,ERROR,FATAL.
	 * @param String $log Must list in uppercase, coma separated, the list of level to be output to log file.
	 */
	public function setLogTraceLevel($log){
		$this->loglevel = $log;
	}
	
	/**
	 * Send a Debug message to trace.
	 * @param String $message a text message to output in DEBUG level to log file.
	 */
	public function debug($message){
		$this->writeMessage("DEBUG", $message);
	}
	/**
	 * Send an Info message to trace.
	 * @param String $message a text message to output in INFO level to log file.
	 */
	public function info($message){
		$this->writeMessage("INFO", $message);
	}
	/**
	 * Send a Warn message to trace.
	 * @param String $message a text message to output in WARN level to log file.
	 */
	public function warn($message){
		$this->writeMessage("WARN", $message);
	}
	/**
	 * Send a Error message to trace.
	 * @param String $message a text message to output in ERROR level to log file.
	 */
	public function error($message){
		$this->writeMessage("ERROR", $message);
	}
	/**
	 * Send a Fatal message to trace.
	 * @param String $message a text message to output in FATAL level to log file.
	 */
	public function fatal($message){
		$this->writeMessage("FATAL", $message);
	}
	
	public function errorHandler($errno, $errstr,$errfile,$errline,$errcontext){
		$log = new Logger(__CLASS__);
		$log->error("error no: $errno - $errstr, in file $errfile line $errline");
		
	}
}
?>