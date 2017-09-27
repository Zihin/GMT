<?php
/***************************************************************
 * 插件式函数定义文件
 * 
 * @author yeahoo2000@163.com 
 ***************************************************************/

/**
 * 值循环器:循环返回指定范围内的一个值
 * @param array $values 值集合
 * @param string $name 值循环器的名称  
 */
function func_cycle($values,$name='default'){
	static $cvars;
	if(!is_array($values)){
		trigger_error('func_cycle() 参数错误,$values的值应该是数组!');
	}
	if(!isset($cvars[$name]['index'])){
		$cvars[$name]['index'] = 0;
	}
	$v = $values[$cvars[$name]['index']++];
	
	if($cvars[$name]['index'] > count($values)-1){
		$cvars[$name]['index'] = 0;
	}
	return $v;
}
?>