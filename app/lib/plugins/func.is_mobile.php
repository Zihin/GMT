<?php
/***************************************************************
 * 插件式函数定义文件
 *
 * @author aling
 ***************************************************************/

/**
 * 检测是mobile格式是否正确
 * @param string $mobile 手机号码
 * @return bool
 */
function func_is_mobile($mobile){
    if (preg_match('/^1[0-9]{2}[0-9]{8}$/', $mobile))
        return true;
    return false;
}
?>