<?php

////////////////////////////////////////////////////////////////////////////////
//
//	db_mysql.inc.php - ����� DB_Sql
//
// 	������: 1.0
//
////////////////////////////////////////////////////////////////////////////////
//
//	������������: ����� ����.
//	����� ���������� ���������: ����� ����.
//
//	���� ���������� ���������: 10 February 2006 19:53:05
//
////////////////////////////////////////////////////////////////////////////////

class DB_Sql {

	/* public: connection parameters */
	var $Host     = "";
	var $Database = "";
	var $User     = "";
	var $Password = "";

	var $Host2     = "";
	var $Database2 = "";
	var $User2     = "";
	var $Password2 = "";

	/* public: configuration parameters */
	var $Auto_Free     = 1;     ## Set to 1 for automatic mysql_free_result()
	var $Debug         = 0;     ## Set to 1 for debugging messages.
	var $Halt_On_Error = "no"; ## "yes" (halt with message), "no" (ignore errors quietly), "report" (ignore errror, but spit a warning)
	var $Seq_Table     = "db_sequence";

	/* public: result array and current row number */
	var $Record = array ();
	var $Row;

	/* public: current error number and error text */
	var $Errno = 0;
	var $Error = "";

	/* public: this is an api revision, not a CVS revision. */
	var $type     = "mysql";
	var $revision = "2.0";

	/* private: link and query handles */
	var $Link_ID   = 0;
	var $Query_ID  = 0;
	var $Select_DB = false;


	/* public: constructor */
	function DB_Sql ( $query = "" ) {

		$this->query ( $query );

	}

	/* public: some trivial reporting */
	function link_id () {

		return $this->Link_ID;

	}

	function query_id () {

		return $this->Query_ID;

	}

	function last_id () {

		return mysql_insert_id ( $this->Link_ID );

	}

	/* public: connection management */
	function connect ( $Database = "", $Host = "", $User = "", $Password = "" ) {

		/* Handle defaults */
		if ( "" == $Database )
			$Database = $this->Database;

		if ( "" == $Host )
			$Host = $this->Host;

		if ( "" == $User )
			$User = $this->User;

		if ( "" == $Password )
			$Password = $this->Password;

		/* establish connection, select database */
		if ( 0 == $this->Link_ID ) {

			$this->Link_ID = mysql_connect ( $Host, $User, $Password );
		
			if ( $this->Link_ID ) {

				$this->Select_DB = @mysql_select_db ( $Database, $this->Link_ID );
			}

			if ( !$this->Link_ID or !$this->Select_DB ) {

				$Host     = $this->Host2;
				$User     = $this->User2;
				$Password = $this->Password2;
				$Database = $this->Database2;

				$this->Link_ID = mysql_connect ( $Host, $User, $Password );

				if ( !$this->Link_ID ) {

					$this->halt ( "connect($Host, $User, \$Password) failed." );

					return 0;

				} else {

					$this->Select_DB = @mysql_select_db ( $Database, $this->Link_ID );

					if ( !$this->Select_DB ) {

						$this->halt ( "cannot use database " . $Database );

						return 0;

					}

				}

			}

		}
		mysql_query("SET NAMES cp1251");
		return $this->Link_ID;

	}

	/* public: discard the query result */
	function free () {

		@mysql_free_result ( $this->Query_ID );
		$this->Query_ID = 0;

	}

	/* public: perform a query */
	function query ( $Query_String ) {

		/* No empty queries, please, since PHP4 chokes on them. */
		if ( $Query_String == "" )
			/* The empty query string is passed on from the constructor,
			* when calling the class without a query, e.g. in situations
			* like these: '$db = new DB_Sql_Subclass;'
			*/
			return 0;

		if ( !$this->connect () ) {

			return 0; /* we already complained in connect() about that. */

		}

		# New query, discard previous result.
		if ( $this->Query_ID ) {

			$this->free ();

		}

		if ( $this->Debug ) {

			printf ( "Debug: query = %s<br>\n", $Query_String );

		}

		$this->Query_ID = @mysql_query ( $Query_String, $this->Link_ID );
		$this->Row   = 0;
		$this->Errno = mysql_errno ();
		$this->Error = mysql_error ();

		if ( !$this->Query_ID ) {

			$this->halt ( "Invalid SQL: " . $Query_String );

		}

		# Will return nada if it fails. That's fine.
		return $this->Query_ID;

	}

	/* public: walk result set */
	function next_record () {

		if ( !$this->Query_ID ) {

			$this->halt ( "next_record called with no query pending." );

			return 0;

		}

		$this->Record = @mysql_fetch_assoc ( $this->Query_ID );
		$this->Row   += 1;
		$this->Errno  = mysql_errno ();
		$this->Error  = mysql_error ();

		$stat = is_array ( $this->Record );

		if ( !$stat and $this->Auto_Free ) {

			$this->free ();

		}

		return $stat;

	}

	/* public: position in result set */
	function seek ( $pos = 0 ) {

		$status = @mysql_data_seek ( $this->Query_ID, $pos );

		if ( $status )
			$this->Row = $pos;
		else {

			$this->halt ( "seek($pos) failed: result has " . $this->num_rows () . " rows." );

			/* half assed attempt to save the day,
			* but do not consider this documented or even
			* desireable behaviour.
			*/
			@mysql_data_seek ( $this->Query_ID, $this->num_rows () );
			$this->Row = $this->num_rows ();

			return 0;

		}

		return 1;

	}

	/* public: table locking */
	function lock ( $table, $mode = "write" ) {

		$query = "LOCK TABLES ";

		if ( is_array ( $table ) ) {

			while ( list ( $key, $value ) = each ( $table ) ) {

				if ( !is_int ( $key ) ) {

					// texts key are "read", "read local", "write", "low priority write"
					$query .= "$value $key, ";

				} else {

					$query .= "$value $mode, ";

				}

			}

			$query = substr ( $query, 0, -2 );

		} else {

			$query .= "$table $mode";

		}

		$res = $this->query ( $query );

		if ( !$res ) {

			$this->halt ( "lock() failed." );

			return 0;

		}

		return $res;

	}

	function unlock () {

		$res = $this->query ( "UNLOCK TABLES" );

		if ( !$res ) {

			$this->halt ( "UNLOCK() failed." );

		}

		return $res;

	}

	/* public: evaluate the result (size, width) */
	function affected_rows () {

		return @mysql_affected_rows ( $this->Link_ID );

	}

	function num_rows () {

		return @mysql_num_rows ( $this->Query_ID );

	}

	function num_fields () {

		return @mysql_num_fields ( $this->Query_ID );

	}

	/* public: shorthand notation */
	function nf () {

		return $this->num_rows ();

	}

	function f ( $Name ) {

		if ( isset ( $this->Record[$Name] ) ) {

			return $this->Record[$Name];

		}

	}

	/* public: sequence numbers */
	function nextid ( $seq_name ) {

		$this->connect ();

		if ( $this->lock ( $this->Seq_Table ) ) {

			/* get sequence number (locked) and increment */
			$q  = sprintf ( "select nextid from %s where seq_name = '%s'", $this->Seq_Table, $seq_name );
			$id  = @mysql_query ( $q, $this->Link_ID );
			$res = @mysql_fetch_array ( $id );

			/* No current value, make one */
			if ( !is_array ( $res ) ) {

				$currentid = 0;
				$q = sprintf ( "insert into %s values('%s', %s)", $this->Seq_Table, $seq_name, $currentid );
				$id = @mysql_query ( $q, $this->Link_ID );

			} else {

				$currentid = $res["nextid"];

			}

			$nextid = $currentid + 1;
			$q = sprintf ( "update %s set nextid = '%s' where seq_name = '%s'", $this->Seq_Table, $nextid, $seq_name );
			$id = @mysql_query ( $q, $this->Link_ID );
			$this->unlock ();

		} else {

			$this->halt ( "cannot lock " . $this->Seq_Table . " - has it been created?" );
			return 0;

		}

		return $nextid;

	}

	/* public: return table metadata */
	function metadata ( $table = "", $full = false ) {

		$count = 0;
		$id    = 0;
		$res   = array ();

		/*
		 * Due to compatibility problems with Table we changed the behavior
		 * of metadata();
		 * depending on $full, metadata returns the following values:
		 *
		 * - full is false (default):
		 * $result[]:
		 *   [0]["table"]  table name
		 *   [0]["name"]   field name
		 *   [0]["type"]   field type
		 *   [0]["len"]    field length
		 *   [0]["flags"]  field flags
		 *
		 * - full is true
		 * $result[]:
		 *   ["num_fields"] number of metadata records
		 *   [0]["table"]  table name
		 *   [0]["name"]   field name
		 *   [0]["type"]   field type
		 *   [0]["len"]    field length
		 *   [0]["flags"]  field flags
		 *   ["meta"][field name]  index of field named "field name"
		 *   This last one could be used if you have a field name, but no index.
		 *   Test:  if (isset($result['meta']['myfield'])) { ...
		 */

		// if no $table specified, assume that we are working with a query
		// result
		if ( $table ) {

			$this->connect ();
			$id = @mysql_list_fields ( $this->Database, $table );
			if ( !$id ) {

				$this->halt ( "Metadata query failed." );
				return false;

			}

		} else {

			$id = $this->Query_ID;
			if ( !$id ) {

				$this->halt ( "No query specified." );
				return false;

			}

		}

		$count = @mysql_num_fields ( $id );

		// made this IF due to performance (one if is faster than $count if's)
		if ( !$full ) {

			for ( $i = 0; $i < $count; $i++ ) {

				$res[$i]["table"] = @mysql_field_table ( $id, $i );
				$res[$i]["name"]  = @mysql_field_name  ( $id, $i );
				$res[$i]["type"]  = @mysql_field_type  ( $id, $i );
				$res[$i]["len"]   = @mysql_field_len   ( $id, $i );
				$res[$i]["flags"] = @mysql_field_flags ( $id, $i );

			}

		} else { // full

			$res["num_fields"] = $count;

			for ( $i = 0; $i < $count; $i++ ) {

				$res[$i]["table"] = @mysql_field_table ( $id, $i );
				$res[$i]["name"]  = @mysql_field_name  ( $id, $i );
				$res[$i]["type"]  = @mysql_field_type  ( $id, $i );
				$res[$i]["len"]   = @mysql_field_len   ( $id, $i );
				$res[$i]["flags"] = @mysql_field_flags ( $id, $i );
				$res["meta"][$res[$i]["name"]] = $i;

			}

		}

		// free the result only if we were called on a table
		if ( $table ) {

			@mysql_free_result ( $id );

		}

		return $res;

	}

	/* public: find available table names */
	function table_names () {

		$this->connect ();
		$h = @mysql_query ( "SHOW TABLES", $this->Link_ID );
		$i = 0;

		while ( $info = @mysql_fetch_row ( $h ) ) {

			$return[$i]["table_name"]      = $info[0];
			$return[$i]["tablespace_name"] = $this->Database;
			$return[$i]["database"]        = $this->Database;
			$i++;

		}

		@mysql_free_result ( $h );

		return $return;

	}

	/* private: error handling */
	function halt ( $msg ) {

		$this->Error = @mysql_error ( $this->Link_ID );
		$this->Errno = @mysql_errno ( $this->Link_ID );

		if ( $this->Halt_On_Error == "no" )
			return;

		$this->haltmsg ( $msg );

		if ( $this->Halt_On_Error != "report" )
			die ( "Session halted." );

	}

	function haltmsg ( $msg ) {

		printf ( "<b>Database error:</b> %s<br>\n", $msg );
		printf ( "<b>MySQL Error</b>: %s (%s)<br>\n", $this->Errno, $this->Error );

	}

	function getResultArray ( $Query_String ) {

		if ( $Query_String == "" )
			return 0;

		$i = -1;
		$this->query ( $Query_String );
		while ( $this->next_record () ) {

			$i++;

			while ( list ( $key, $val ) = each ( $this->Record ) )
				$records[$i][$key] = $val;

		}

		return $records;

	}

}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
//	����� ���������� � ������������ �����.
if ( ERROR_PRINT_INCLUDE_FILENAME != 0 )
	echo "Class DB_Sql (file " . basename ( __FILE__ ) . ")<br>";
////////////////////////////////////////////////////////////////////////////////

?>