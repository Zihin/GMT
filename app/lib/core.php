<?php
/***************************************************************
 * 系统核心文件
 * 
 * @author yeahoo2000@163.com
 ***************************************************************/
//动作的执行级别定义
define('ACT_OPEN', 0);			//不必登录,也无须验证权限
define('ACT_NEED_LOGIN', 1); 	//需要登录,但不用验证权限
define('ACT_NEED_AUTH', 2); 	//需要登录并验证权限

//日志类型
define('L_DEBUG',		'DEBUG');		//消息
define('L_WARNING',		'WARNING');		//警告
define('L_ERROR',		'ERROR');		//错误
define('L_DB',			'DATABASE');	//数据库出错信息

class Config {
	var $conf= array ();
	function Config() {
		global $conf;
		$this->conf= $conf;
		unset ($conf);
	}
	function & singleton() {
		static $instance;
		if (!isset ($instance)) {
			$class= __CLASS__;
			$instance= new $class ();
		}
		return $instance;
	}
	function set($key, $val) {
		$this->conf[$key]= $val;
	}
	function get($key) {
		if (is_array($key)) {
			$key1= key($key);
			$key2= $key[$key1];
			return $this->conf[$key1][$key2];
		}
		return $this->conf[$key];
	}
}

class Session {
	function Session() {
		session_save_path(VAR_DIR.'/session/'.DIR_PREFIX);
		session_cache_limiter('private, must-revalidate');
		session_start();
		if (!isset ($_SESSION['access_time'])) {
			$_SESSION['access_time']= time();
		}
	}
	function & singleton() {
		static $instance;
		if (!isset ($instance)) {
			$class= __CLASS__;
			$instance= new $class ();
		}
		return $instance;
	}
	function getGroupId() {
		return $_SESSION['user']['gid'];
	}
	function setGroupId($id) {
		$_SESSION['user']['gid']= $id;
	}
	function getUserId() {
		return $_SESSION['user']['uid'];
	}
	function setUserId($id) {
		$_SESSION['login_time']= time();
		$_SESSION['user']['uid']= $id;
	}
	function setQueryData($data) {
		$_SESSION['query_data']= $data;
	}
	/**
	 * 获得登录后跳转的URL
	 */
	function getNextTo() {
		return $_SESSION['login_to_here'];
	}
	/**
	 * 设置登录后跳转的URL
	 */
	function setNextTo($url) {
		$_SESSION['login_to_here']= $url;
	}

	/**
	 * 更新最后一次活动的时间
	 */
	function updateLastActTime() {
		$_SESSION['user']['last_action_time']= time();
	}

	/**
	 * 取得最后一次活动的时间
	 */
	function getLastActTime() {
		return $_SESSION['user']['last_action_time'];
	}

	/**
	 * 取得一个session变量值
	 * @param string $key 键名
	 * @return mixd
	 */
	function & get($key) {
		if (is_array($key)) {
			$key1= key($key);
			$key2= $key[$key1];
			return $_SESSION['data'][$key1][$key2];
		}
		return $_SESSION['data'][$key];
	}

	/**
	 * 设置和清除一个session变量
	 * 如果没有指定$val值将会把session中的$key变量清除
	 * @param string $key 键名
	 * @param mixd $var 值
	 */
	function set($key, $val= null) {
		if (empty ($val)) {
			unset ($_SESSION['data'][$key]);
			return;
		}
		$_SESSION['data'][$key]= $val;
	}

	/**
	 * 结束Session
	 */
	function end() {
		unset ($_SESSION);
		session_destroy();
	}
}
class Request {
	var $requestData= array ();

	function Request() {
		if (!get_magic_quotes_gpc()) {
			$_POST= addQuotes($_POST);
			$_FILES= addQuotes($_FILES);
		}
		$this->set('reqdata', array_merge($_POST, $_FILES));
		if(CORE_SEF_QUERY_STRING)	//是否需要使用搜索引擎友好QUERY_STRING
			$this->_parseQueryString();
		else $this->_parseQsNormal();
	}

	function & singleton() {
		static $instance;
		if (!isset ($instance)) {
			$class= __CLASS__;
			$instance= new $class ();
		}
		return $instance;
	}
	/**
	 * 取得一个变量
	 */
	function get($key) {
		if (is_array($key)) {
			$key1= key($key);
			$key2= $key[$key1];
			return $this->requestData[$key1][$key2];
		}
		return $this->requestData[$key];
	}
	/**
	 * 设置一个变量
	 */
	function set($key, $val) {
		$this->requestData[$key]= $val;
	}
	/**
	 * 解析查询字串(普通)
	 */
	function _parseQsNormal() {
		$this->requestData['reqdata']= array_merge($_GET, $this->requestData['reqdata']);
		$this->requestData['moduleName']= $_GET['mod'];
		$this->requestData['actionName']= $_GET['act'];
	}
	/**
	 * 解析查询字串(搜索引擎友好)
	 */
	function _parseQueryString() {
		$data= explode(',', $_SERVER['QUERY_STRING']);
		$reqdata= array ();
		$paras_num= count($data);
		for ($i= 2; $i < $paras_num && $i < 1000; $i += 2) {
			if ('' == $data[$i])
				continue;
			$reqdata[$data[$i]]= urldecode($data[$i +1]);
		}
		$reqdata= addQuotes($reqdata);
		$this->requestData['reqdata']= array_merge($reqdata, $this->requestData['reqdata']);
		$this->requestData['moduleName']= $data[0];
		$this->requestData['actionName']= $data[1];
	}
}

class Core {
	/**
	 * 模块调度函数(主入口)
	 */
	function run() {
		$sess= & Session :: singleton();
		$req= & Request :: singleton();
		
		//判断当前语言选择
		if($req->get(array('reqdata'=>'lang')) && in_array($req->get(array('reqdata'=>'lang')), $GLOBALS['multi_language'])){
			define('LANGUAGE', $req->get(array('reqdata'=>'lang')));
		}else if($sess->get('language')){
			define('LANGUAGE', $sess->get('language')); //使用上次的语言选择
		}else{
			define('LANGUAGE', LANGUAGE_DEFAULT); //使用默认语言
		}
		
		$sess->set('language', LANGUAGE); //保存当前会话的语言选择
		
		$module= $req->get('moduleName');
		$action= $req->get('actionName');

		if (empty ($module)) {
			$module= MODULE_DEFAULT;
		}
		if (empty ($action)) {
			$action= ACTION_DEFAULT;
		}
		$module= strtolower($module);
		$action= strtolower($action);

		define('APPROOT', MOD_DIR.'/'.DIR_PREFIX.'/'.$module.'/');
		define('CURRENT_MODULE', $module);
		define('CURRENT_ACTION', $action);
		if (!is_dir(APPROOT)) {
			if (!DEBUG) {
				Core :: redirect(SITE_URL);
			}
			Core :: raiseMsg('模块不存在');
			return false;
		}
		if (!file_exists(APPROOT.$action.'.act.php')) {
			if (!DEBUG) {
				Core :: redirect(SITE_URL);
			}
			Core :: raiseMsg('您要访问的面页不存在');
			return false;
		}
		include_once APPROOT.$action.'.act.php';
		if (!class_exists($action)) {
			trigger_error('文件中没有定义动作处理的类:'.APPROOT.$action.'.act.php');
			return false;
		}
		$thread= new $action ();
		if (!is_a($thread, 'Action')) {
			trigger_error("\"$action\"不是一个动作类:".APPROOT.$action.'.act.php');
			return false;
		}
		if (!method_exists($thread, 'process')) {
			trigger_error('没有定义动作类的执行入口:'.APPROOT.$action.'.act.php');
			return false;
		}
		if (ACT_OPEN != $thread->AuthLevel) {
			if (!strlen($sess->getUserId())) {
				$sess->setNextTo(PROTOCOL.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				//trigger_error('你还没有登录,请登录再操作...');
				Core :: redirect(Core :: getUrl('login', 'default', array('lang'=>LANGUAGE)));
				return false;
			}
			if ((time() - $sess->getLastActTime()) > IDLE_TIMEOUT) {
				$sess->end();
				Core :: raiseMsg('你已经登录超时了,请重新登录...',array('重新登录'=>Core::getUrl('login','default')),true);
				return false;
			}
			if ((ACT_NEED_AUTH == $thread->AuthLevel) && !Core :: hasPerms($module.'_'.$action)) {
				Core :: raiseMsg('对不起!你没有执行该操作的权限');
				return false;
			}
		}
		$sess->updateLastActTime();
		$thread->process();
	}

	/**
	 * 检查指定用户组是否有运行某个模块和模块的权限
	 */
	function hasPerms($perm, $gid = null) {
		if(!is_numeric($gid)){
			$gid = (int)$_SESSION['user']['gid'];
		}
		$privSet = unserialize(@file_get_contents(VAR_DIR.'/group_priv/'.DIR_PREFIX.'/gid_'.$gid));
		return @array_search($perm, $privSet) !== false ? true : false;
	}
	
	/**
	 * 生成一个影射到指定模块和动作的URL
	 * @param string $action 动作标识字串
	 * @param string $module 模块标识字串
	 * @param array $reqdata 附加到url的参数
	 * @param bool $useQueryCache 是否使用缓存中
	 * 的QueryData(被保存在SESSION中)
	 * 
	 * @return string $url URL字串
	 */
	function getUrl($action= null, $module= null, $reqdata= null, $useQueryCache= false) {
		$url= '';
		if (is_array($reqdata) && $useQueryCache && is_array($_SESSION['query_data'])) {
			$reqdata= array_merge($_SESSION['query_data'], $reqdata);
		} elseif ($useQueryCache && is_array($_SESSION['query_data'])) {
			$reqdata= stripQuotes($_SESSION['query_data']);
		}
			
		$action= $action ? $action : CURRENT_ACTION;
		$module= $module ? $module : CURRENT_MODULE;
		
		if(CORE_SEF_QUERY_STRING){
			if (is_array($reqdata)) {
				foreach ($reqdata as $k => $v) {
					$url .= ','.urlencode($k).','.urlencode($v);
				}
			}
			$url = '?'.$module.','.$action.$url;
		}else{
			if (is_array($reqdata)) {
				foreach ($reqdata as $k => $v) {
					$url .= '&'.urlencode($k).'='.urlencode($v);
				}
			}
			$url = '?mod='.$module.'&act='.$action.$url;
		}
		return PROTOCOL.'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].$url;
	}

	/**
	 * 页面重定向
	 * @param string $url url字符串
	 */
	function redirect($url) {
		header('Location:'.$url);
		exit ();
	}

	/**
	 * 输出信息到客户端,并中止程序执行
	 * @param string $msg 信息字符串
	 * @param array $links 在信息字符串下显示的链接
	 * 例:$links = array( '到a页'=>'a.html','到b页' => 'b.html');
	 * @param bool $moveToTop 如果在子Frame中,设定是否要跳出子Frame显示
	 */
	function raiseMsg($msg, $links= array (),$moveToTop = false) {
		$v= array ();
		$v['msg']= $msg;
		$v['toTop'] = !$moveToTop?'':'<script language="javascript">if(top.location !== self.location) top.location=self.location;</script>';
		if (count($links)) {
			foreach ($links as $key => $val) {
				$v['links'] .= '&nbsp;<a href="'.$val.'">'.$key.'</a>';
			}
		}

		include TPL_DIR.'/'.DIR_PREFIX.'/message.'.LANGUAGE.'.tpl';
		exit ();
	}

	/**
	 * 获得一个连接的数据库操作句柄(程序退出时会自动Close)
	 * @return object
	 */
	function getDb() {
		static $instance;
		if (!isset ($instance)) {
			include_once LIB_DIR.'/adodb/adodb.inc.php';
			include_once(LIB_DIR.'/adodb/adodb-errorhandler.inc.php');
			$cfg= Config :: singleton();
			$conf= $cfg->get('db');

			$ADODB_FETCH_MODE= ADODB_FETCH_ASSOC;

			$instance =  ADONewConnection($conf['driver']);

			if (!$instance->Connect($conf['host'], $conf['user'], $conf['passwd'], $conf['dbname'])) {
				trigger_error('数据库连接失败!');
				return false;
			}
			//在程序结束时自动断开连接,释放数据库资源
			register_shutdown_function(array ($instance, 'Close'));
			$instance->Execute("set names 'utf8'");
			//$instance->debug = true;
		}
		return $instance;
	}
	
	/**
	 * 获得一个邮件发送器操作句柄
	 * @return object
	 */
	function getMailer() {
		include_once LIB_DIR.'/phpmailer/class.phpmailer.php';
		$cfg= Config :: singleton();
		$conf= $cfg->get('smtp');
		$mailer= new PHPMailer;
		$mailer->Host = $conf['host'];
		$mailer->SMTPAuth = $conf['auth'];
		$mailer->From = $conf['from'];
		$mailer->FromName = $conf['fromname'];
		$mailer->Username = $conf['username'];
		$mailer->Password = $conf['password'];
		$mailer->IsSMTP();
		return $mailer;
	}
	/**
	 * 获得一个支付方式
	 * @return object
	 */
	function getPayment($code) {
		include_once LIB_DIR.'/payment/'.$code.'.php';
		return $mailer;
	}
}
class Object {
	function Object() {
		$args= func_get_args();
		register_shutdown_function(array (& $this, '__destruct'));
		call_user_func_array(array (& $this, '__construct'), $args);
	}
	function __construct() {
	}
	function __destruct() {
	}
}
class Action extends Object {
	var $AuthLevel= ACT_NEED_AUTH;
	var $sess;
	var $input;

	function __construct() {
		$this->sess= & Session :: singleton();
		$req = Request::singleton();
		$this->input = $req->get('reqdata');
	}
	function __destruct() {
	}
	function process() {
	}
}
class Page extends Action {
	var $cacheTime= 0;
	var $pathAppend= null;
	var $_tplFile= array ();
	var $_pagevar= array ();
	var $_contents;
	var $_cacheFile;

	function __construct() {
		parent :: __construct();
		if($this->useContentPart){
			$this->input['part'] = $this->input['part']?(int)$this->input['part']:'0';
		}
		$this->_cacheFile = cacheFilename(CURRENT_MODULE,CURRENT_ACTION,$this->input[$this->pathAppend],$this->input['part']);
		if (($this->cacheTime < 0 && file_exists($this->_cacheFile)) || (time() - @ filemtime($this->_cacheFile)) <= $this->cacheTime) {
			include $this->_cacheFile;
			//echo "<div align='center'>执行用时:".round((array_sum(explode(' ', microtime())) - sys_time_start) * 1000, 2)." ms</div>";
			exit ();
		}
	}
	function _compile($v) {
		ob_start();
		foreach ($this->_tplFile as $file) {
			if($file['absolute'])
				include $file['filename'];
			else include TPL_DIR.'/'.DIR_PREFIX.'/'.CURRENT_MODULE.'/'.$file['filename'];
		}
		$this->_contents= ob_get_contents();
		ob_end_clean();
		if (0 != $this->cacheTime) {
			wfile($this->_cacheFile, $this->_contents);
		}
	}
	function addTplFile($filename, $absPath=false, $langAuto = true) {
		if($langAuto) $filename .= '.'.LANGUAGE.'.tpl';
		$this->_tplFile[]= array(	'filename' => $filename
									,'absolute' => $absPath);
	}
	function assign($pagevar) {
		if(!is_array($pagevar)){
			return;
		}
		$this->_pagevar= $pagevar;
	}
	function fetch() {
		$this->_compile($this->_pagevar);
		return $this->_contents;
	}
	function display() {
		echo $this->fetch();
	}
}

/**
 * 得到相应模块和动作的静态缓存页的路径和文件名
 * @param string $module 模块名
 * @param string $action 动作名
 * @param string $uniqueId 如果是要根据唯一特征分别缓存成多个页面,则必须指定唯一的标识(通常可使用表主键),最大长度12位
 * @param string $part 如果是该页面分成多部份进行缓存,则要指定某一部份的编号,最大长度3位
 */
function cacheFilename($module, $action, $uniqueId = null, $part = null){
	if(strlen($uniqueId)){
		$pa = sprintf('%12s', $uniqueId);
		$pa = str_replace(' ', '_', $pa);
		$pathAppend = '/'.$pa[0].$pa[1].$pa[2].'/'.$pa[3].$pa[4].$pa[5].'/'.$pa[6].$pa[7].$pa[8].'/'.$pa[9].$pa[10].$pa[11];
		if(strlen($part)){
			$pa = sprintf('%3s', $part);
			$pa = str_replace(' ', '_', $pa);
			$pathAppend .= '/'.$pa[0].$pa[1].$pa[2];
		}
	}else $pathAppend = '';
	return VAR_DIR.'/cache/'.LANGUAGE.'/'.$module.'/'.$action.$pathAppend;
}

/**
 * 清除由某个动作生成的缓存文件
 * @param string $module 模块名
 * @param string $action 动作名
 * @param string $uniqueId 根据唯一特征清除指定的缓存文件
 */
function removeCache($module, $action, $uniqueId = null){
	if(is_array($uniqueId)){
		foreach($uniqueId as $v){
			$cacheFile = cacheFilename($module,$action,$v);
			removeFile($cacheFile);
		}
	}else {
		$cacheFile = cacheFilename($module,$action,$uniqueId);
		removeFile($cacheFile);
	}
}
?>
