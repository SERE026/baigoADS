<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

include_once(BG_PATH_CLASS . "ajax.class.php"); //载入模板类
include_once(BG_PATH_MODEL . "log.class.php"); //载入管理帐号模型

/*-------------用户控制器-------------*/
class AJAX_LOG {

    private $adminLogged;
    private $obj_ajax;
    private $mdl_log;
    private $is_super = false;

    function __construct() { //构造函数
        $this->adminLogged    = $GLOBALS["adminLogged"]; //已登录用户信息
        $this->obj_ajax       = new CLASS_AJAX(); //获取界面类型
        $this->obj_ajax->chk_install();
        $this->log            = $this->obj_ajax->log; //初始化 AJAX 基对象
        $this->mdl_log        = new MODEL_LOG(); //设置用户模型

        if ($this->adminLogged["alert"] != "y020102") { //未登录，抛出错误信息
            $this->obj_ajax->halt_alert($this->adminLogged["alert"]);
        }

        if ($this->adminLogged["admin_type"] == "super") {
            $this->is_super = true;
        }
    }

    /*============更改用户状态============
    @arr_logId 用户 ID 数组
    @str_status 状态

    返回提示信息
    */
    function ajax_status() {
        if (!isset($this->adminLogged["admin_allow"]["log"]["edit"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x060303");
        }

        $_str_status = fn_getSafe($GLOBALS["act_post"], "txt", "");

        $_arr_logIds = $this->mdl_log->input_ids();
        if ($_arr_logIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_logIds["alert"]);
        }

        $_arr_logRow = $this->mdl_log->mdl_status($_str_status);

        $this->obj_ajax->halt_alert($_arr_logRow["alert"]);
    }

    /*============删除用户============
    @arr_logId 用户 ID 数组

    返回提示信息
    */
    function ajax_del() {
        if (!isset($this->adminLogged["admin_allow"]["log"]["del"]) && !$this->is_super) {
            $this->obj_ajax->halt_alert("x060304");
        }

        $_arr_logIds = $this->mdl_log->input_ids();
        if ($_arr_logIds["alert"] != "ok") {
            $this->obj_ajax->halt_alert($_arr_logIds["alert"]);
        }

        $_arr_logRow = $this->mdl_log->mdl_del();

        if ($_arr_logRow["alert"] == "y060104") {
            foreach ($_arr_logIds["log_ids"] as $_key=>$_value) {
                $_arr_targets[] = array(
                    "log_id" => $_value,
                );
                $_str_targets = json_encode($_arr_targets);
            }
            $_str_logRow = json_encode($_arr_logRow);

            $_arr_logData = array(
                "log_targets"        => $_str_targets,
                "log_target_type"    => "log",
                "log_title"          => $this->log["log"]["del"],
                "log_result"         => $_str_logRow,
                "log_type"           => "admin",
            );

            $this->mdl_log->mdl_submit($_arr_logData, $this->adminLogged["admin_id"]);
        }

        $this->obj_ajax->halt_alert($_arr_logRow["alert"]);
    }
}
