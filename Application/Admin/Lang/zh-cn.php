<?php
$mpath = MODULE_PATH.'Lang/'.LANG_SET.'/menu_common.php';
if(file_exists($mpath)){
    require_once $mpath;
}else{
    $menu_common = array();
}
$common = array(
    'PRO_NAME'          =>  'ITskyCMS',
    'BACKER_MANAGE'     =>  '后台管理',
    'LOGIN_SUCCESS'     =>  '登录成功！',
    'LOGIN_ERROR'       =>  '用户名或密码错误！',
    'VERIFY_ERROR'      =>  '验证码错误！',
    'LOGOUT'            =>  '退出',
    'WELCOME'           =>  '欢迎光临',
    'SELECT_SKIN'       =>  '选择皮肤',
    'FIXED_NAVBAR'      =>  '固定导航条',
    'FIXED_SIDEBAR'     =>  '固定滚动条',
    'FIXED_BREADCRUMBS' =>   '固定面包屑',
    'SET_RTL'           =>  '切换到左边',
    'SET_CONTAINER'     =>  '切换窄屏',
    'HOME_INDEX'        =>  '首页',
    'MENU_LOOK'         =>  '查看',
    'SUBMIT'            =>  '保存',
    'RESET'             =>  '重置',
    'DEFAULT'           =>  '默认',
    'SUCH'              =>  '例',
    'INDEX'             =>  '查看',
    'EDIT'              =>  '编辑',
    'DELETE'            =>  '删除',
    'DEL_OK'            =>  '删除成功！',
    'DEL_ERROR'         =>  '删除失败！',
    'ORDER_OK'          =>  '排序成功！',
    'STATUS_ERROR'      =>  '状态设置失败！',
    'ADD'               =>  '添加',
    'STATUS'            =>  '状态',
    'SAVE_ERROR'        =>  '保存失败！',
    'SAVE_OK'           =>  '保存成功！',
    'ON'                =>  '开启',
    'OFF'               =>  '关闭',
    'YES'               =>  '是',
    'NO'                =>  '否',
    'FONT_INDEX'        =>  '前台主页',
    'ADD_ERROR'         =>  '数据添加失败！',
    'ADD_OK'            =>  '数据添加成功！',
    'EMPTY_DATA'        =>  '暂无数据！',


    'DOWNLOAD_FILE_NOT_EXIST'   =>  '下载文件不存在！'
);
return array_merge($common, $menu_common);