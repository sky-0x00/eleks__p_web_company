<?php

////////////////////////////////////////////////////////////////////////////////
//
//	local.inc.php - дочерние классы, подстраивающиеся под локальную систему
//
// 	Версия: 1.0
//
////////////////////////////////////////////////////////////////////////////////
//	Наследник класса DB_Sql.

class SYS_DB extends DB_Sql {

	function SYS_DB () {

		global $cfg;

		$this->Host     = $cfg[DB][Host];
		$this->Database = $cfg[DB][Name];
		$this->User     = $cfg[DB][User];
		$this->Password = $cfg[DB][Pass];
		$this->Debug    = $cfg[DB][debug];        
	}

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//	Наследник класса Session.
class SYS_Session extends Session {
}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//	Наследник класса Auth.
class SYS_Auth extends Auth {

	var $database_class = "SYS_DB";

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//	Наследник класса User.
class SYS_User extends User {

	var $database_class = "SYS_DB";

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//	Наследник класса Smarty.
if ( class_exists ( "Smarty" ) ) {

	class Smarty_Site extends Smarty {

		function Smarty_Site () {

			global $cfg;

			$this->left_delimiter  = "{#";
			$this->right_delimiter = "#}";
			$this->template_dir    = $cfg[PATH][skins][tpl];
			$this->compile_dir     = $cfg[PATH][cache] . "/smarty/site/templates_c/";
			$this->config_dir      = $cfg[PATH][cache] . "/smarty/site/configs/";
			$this->cache_dir       = $cfg[PATH][cache] . "/smarty/site/cache/";

			if ( function_exists ( "_toSmarty_Extension" ) )
			_toSmarty_Extension ( &$this );

		}

	}

	class Smarty_Admin extends Smarty {

		function Smarty_Admin () {

			global $cfg;

			$this->left_delimiter  = "{#";
			$this->right_delimiter = "#}";
			$this->template_dir    = $cfg[PATH][skins][tpl];
			$this->compile_dir     = $cfg[PATH][cache] . "/smarty/admin/templates_c/";
			$this->config_dir      = $cfg[PATH][cache] . "/smarty/admin/configs/";
			$this->cache_dir       = $cfg[PATH][cache] . "/smarty/admin/cache/";

			if ( function_exists ( "_toSmarty_Extension" ) )
			_toSmarty_Extension ( &$this );

		}

	}

}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
//	Вывод информации о подключенном файле.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
echo "Local settings (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>