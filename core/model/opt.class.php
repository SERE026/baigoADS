<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------设置项模型-------------*/
class MODEL_OPT {

	function mdl_const($str_type) {
		$_str_content = "<?php" . PHP_EOL;
		foreach ($this->arr_const[$str_type] as $_key=>$_value) {
			if (is_numeric($_value)) {
				$_str_content .= "define(\"" . $_key . "\", " . $_value . ");" . PHP_EOL;
			} else {
				$_str_content .= "define(\"" . $_key . "\", \"" . str_replace(PHP_EOL, "|", $_value) . "\");" . PHP_EOL;
			}
		}

		if ($str_type == "base") {
			$_str_content .= "define(\"BG_SITE_SSIN\", \"" . fn_rand(6) . "\");" . PHP_EOL;
		}

		$_str_content = str_replace("||", "", $_str_content);

		$_num_size    = file_put_contents(BG_PATH_CONFIG . "opt_" . $str_type . ".inc.php", $_str_content);

		if ($_num_size > 0) {
			$_str_alert = "y060101";
		} else {
			$_str_alert = "x060101";
		}

		return array(
			"alert" => $_str_alert,
		);
	}


	function mdl_dbconfig() {
		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_HOST\", \"" . $this->dbconfigSubmit["db_host"] . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_NAME\", \"" . $this->dbconfigSubmit["db_name"] . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_PORT\", \"" . $this->dbconfigSubmit["db_port"] . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_USER\", \"" . $this->dbconfigSubmit["db_user"] . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_PASS\", \"" . $this->dbconfigSubmit["db_pass"] . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_CHARSET\", \"" . $this->dbconfigSubmit["db_charset"] . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_DB_TABLE\", \"" . $this->dbconfigSubmit["db_table"] . "\");" . PHP_EOL;

		$_num_size = file_put_contents(BG_PATH_CONFIG . "opt_dbconfig.inc.php", $_str_content);
		if ($_num_size > 0) {
			$_str_alert = "y030404";
		} else {
			$_str_alert = "x030404";
		}

		return array(
			"alert" => $_str_alert,
		);
	}


	function mdl_over() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$_str_content = "<?php" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_VER\", \"" . PRD_ADS_VER . "\");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_PUB\", " . PRD_ADS_PUB . ");" . PHP_EOL;
		$_str_content .= "define(\"BG_INSTALL_TIME\", " . time() . ");" . PHP_EOL;

		$_num_size = file_put_contents(BG_PATH_CONFIG . "is_install.php", $_str_content);
		if ($_num_size > 0) {
			$_str_alert = "y060101";
		} else {
			$_str_alert = "x060101";
		}

		return array(
			"alert" => $_str_alert,
		);
	}


	function input_dbconfig() {
		if (!fn_token("chk")) { //令牌
			return array(
				"alert" => "x030102",
			);
			exit;
		}

		$_arr_dbHost = validateStr(fn_post("db_host"), 1, 900);
		switch ($_arr_dbHost["status"]) {
			case "too_short":
				return array(
					"alert" => "x060204",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x060205",
				);
				exit;
			break;

			case "ok":
				$this->dbconfigSubmit["db_host"] = $_arr_dbHost["str"];
			break;
		}

		$_arr_dbName = validateStr(fn_post("db_name"), 1, 900);
		switch ($_arr_dbName["status"]) {
			case "too_short":
				return array(
					"alert" => "x060206",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x060207",
				);
				exit;
			break;

			case "ok":
				$this->dbconfigSubmit["db_name"] = $_arr_dbName["str"];
			break;
		}

		$_arr_dbPort = validateStr(fn_post("db_port"), 1, 900);
		switch ($_arr_dbPort["status"]) {
			case "too_short":
				return array(
					"alert" => "x060208",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x060209",
				);
				exit;
			break;

			case "ok":
				$this->dbconfigSubmit["db_port"] = $_arr_dbPort["str"];
			break;
		}

		$_arr_dbUser = validateStr(fn_post("db_user"), 1, 900);
		switch ($_arr_dbUser["status"]) {
			case "too_short":
				return array(
					"alert" => "x060210",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x060211",
				);
				exit;
			break;

			case "ok":
				$this->dbconfigSubmit["db_user"] = $_arr_dbUser["str"];
			break;
		}

		$_arr_dbPass = validateStr(fn_post("db_pass"), 1, 900);
		switch ($_arr_dbPass["status"]) {
			case "too_short":
				return array(
					"alert" => "x060212",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x060213",
				);
				exit;
			break;

			case "ok":
				$this->dbconfigSubmit["db_pass"] = $_arr_dbPass["str"];
			break;
		}

		$_arr_dbCharset = validateStr(fn_post("db_charset"), 1, 900);
		switch ($_arr_dbCharset["status"]) {
			case "too_short":
				return array(
					"alert" => "x060214",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x060215",
				);
				exit;
			break;

			case "ok":
				$this->dbconfigSubmit["db_charset"] = $_arr_dbCharset["str"];
			break;
		}

		$_arr_dbTable = validateStr(fn_post("db_table"), 1, 900);
		switch ($_arr_dbTable["status"]) {
			case "too_short":
				return array(
					"alert" => "x060216",
				);
				exit;
			break;

			case "too_long":
				return array(
					"alert" => "x060217",
				);
				exit;
			break;

			case "ok":
				$this->dbconfigSubmit["db_table"] = $_arr_dbTable["str"];
			break;
		}

		$this->dbconfigSubmit["alert"] = "ok";

		return $this->dbconfigSubmit;
	}


	function input_const($str_type) {
		$this->arr_const = fn_post("opt");

		return $this->arr_const[$str_type];
	}
}
