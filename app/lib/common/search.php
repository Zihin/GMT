<?php
/***************************************************************
 * 搜索页基类
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/
class Search extends Page{
	var $queryString;
	var $keyword_and = array ();
	var $keyword_or = array ();
	var $keyword_not = array ();
	
	function __construct(){
		parent::__construct();
		$this->parseQueryString($this->input['q']);		//解析查询关键词
	}
	function parseQueryString($qString) {
		//分析查询字符串
		$this->queryString= preg_replace('| +|', ' ', trim($qString)); //去除多余的空格
		if (!$this->queryString)
			return; //没有输入有效查询字符则返回
		$qString= ' '.$this->queryString;
		$m= array ();
		preg_match_all("! -([^ ]*)!i", $qString, $m);
		$this->keyword_not= $m[1];
		$qString= preg_replace("! -([^ ]*)!i", '', $qString);
		preg_match_all("! ([^ ]*)( or ([^ ]*)){1,}!i", $qString, $m);
		preg_match_all("! ([^ ]*) ?!i", $m[0][0], $m);
		$this->keyword_or= $m[1];
		$qString= preg_replace("! ([^ ]*)( or ([^ ]*)){1,}!i", '', $qString);
		preg_match_all("! ([^ ]*)!i", $qString, $m);
		$this->keyword_and= $m[1];
	}
	function highlight($string){
		foreach($this->keyword_and as $v){
			$string = preg_replace("!$v!", "<span style='color:#f30'>$v</span>", $string);
		}
		foreach($this->keyword_or as $v){
			$string = preg_replace("!$v!", "<span style='color:#f30'>$v</span>", $string);
		}
		return $string;
	}
}
?>