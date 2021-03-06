<?php
$mopath = MODULE_PATH.'Lang/'.LANG_SET.'/module_info.php';
if(file_exists($mopath)){
    require_once $mopath;
}else{
    $module_info = array();
}
$cat = array(
    'ORDER'             =>  '排序',
    'NUMBER'            =>  '編號',
    'NAME'              =>  '欄目名稱',
    'MODEL'             =>  '所屬模型',
    'NAV'               =>  '導航',
    'VISIT'             =>  '訪問',
    'MANOPE'            =>  '管理操作',
    'ADD_CONTENT'       =>  '添加內容',
    'ADD_CHILDREN'      =>  '添加子欄目',
    'EDIT_CONTENT'      =>  '編輯內容',
    'SHOW'              =>  '顯示',
    'NO_SHOW'           =>  '不顯示',
    'ADD'               =>  '添加欄目',
    'BASE_SET'          =>  '基本設置',
    'SEO_SET'           =>  'SEO設置',
    'SELETE_MODULE'     =>  '模型',
    'SELETE'            =>  '請選擇',
    'PRE_CAT'           =>  '上一級欄目',
    'TOP_CAT'           =>  '作為一級欄目',
    'CAT_NAME'          =>  '欄目名稱',
    'CAT_DIR'           =>  '欄目目錄',
    'CAT_DIRS'          =>  '多欄目設置',
    'CAT_DIRS_INFO'     =>  '將以下設置應用到所有子欄目',
    'IS_NAV'            =>  '是否為導航',
    'IS_HTML'           =>  '是否生成html',
    'URL_RULE'          =>  'URL規則',
    'PAGE_ITEM'         =>  '分頁條數',
    'PAGE_ITEM_TIP'     =>  '為空時默認值為系統設置的值',
    'LIST_TPL'          =>  '列表頁模板',
    'IS_COVER_CAT'      =>  '是否為封面欄目',
    'CONTENT_TPL'       =>  '內容頁模板',
    'TYPER'             =>  '請選擇模型！',
    'OURL'              =>  '外部鏈接',
    'URL'               =>  '外部鏈接地址',
    'NAMEL'             =>  '欄目名稱長度必須為2到20個字符！',
    'DIRL'              =>  '欄目目錄長度必須為3到20個字符！',
    'DIRR'              =>  '欄目目錄包含非法字符！',
    'URLR'              =>  '鏈接地址不能為空！',
    'URLU'              =>  '鏈接地址格式不正確！',
    'URLRULEIDC'        =>  '請選擇URL規則！',
    'PAGESIZEN'         =>  '分頁條數必須為數字！',
    'SEO_TITLE'         =>  'SEO欄目標題',
    'SEO_KEYWORDS'      =>  'SEO欄目關鍵詞',
    'SEO_DESCRIPTION'   =>  'SEO欄目簡介',
    'ADD_ERROR'         =>  '欄目添加失敗！',
    'ADD_OK'            =>  '欄目添加成功！'
);
return array_merge($cat, $module_info);