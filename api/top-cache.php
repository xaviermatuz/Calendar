<?php class cache{

public $cache_ext; 
public $cache_time; 
public $cache_folder;
public $ignore_pages;
public $dynamic_url;
public $_ignore_status; 
public $_cache_file; 


public function __construct($cache_ext  = '.html',$cache_time = 3600,$cache_folder   = 'cache_gen/',$ignore_pages   = array(),$cache_enable=1) 
{
	  
	$this->cache_ext=$cache_ext;
	$this->cache_time=$cache_time;
	$this->cache_folder=$cache_folder;
	$this->ignore_pages=$ignore_pages;
	$this->dynamic_url    = "http://".$_SERVER['HTTP_HOST']. $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
	
      $this->_cache_file     = $this->cache_folder. md5($this->dynamic_url).$this->cache_ext; 
      $this->_ignore_status = (in_array($this->dynamic_url,$this->ignore_pages))?true:false;
if($cache_enable==1)	
{
	if (!$this->_ignore_status && file_exists($this->_cache_file) && time() - $this->cache_time < filemtime($this->_cache_file)) { //check Cache exist and it's not expired.
		ob_start('ob_gzhandler'); //Turn on output buffering, "ob_gzhandler" for the compressed page with gzip.
		readfile($this->_cache_file); //read Cache file
		echo '<!-- cached page by cache class by w3school - '.date('l jS \of F Y h:i:s A', filemtime($this->_cache_file)).', Page : '.$this->dynamic_url.' -->';
		ob_end_flush(); //Flush and turn off output buffering
		exit(); //no need to proceed further, exit the flow.
	}
}
	 //Turn on output buffering with gzip compression.
	ob_start('ob_gzhandler'); 
}


}
