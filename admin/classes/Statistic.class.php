<?php

class Statistic extends WorkWithData  {

	function Statistic() {

		global $cfg;

		$this->WorkWithData ();

		$this->AllowWrite = false;

		$this->fields  = $fields;
		$this->section = "statistic";
		$this->table   = $cfg[DB][Table][stats_log];
	}

	function WriteLog() {

		global $cfg, $DomainInfo, $pageData;

		if ($_SERVER['SERVER_NAME']) {

			return $this->db->query ( sprintf(
			"INSERT INTO %s (date_created, time_created, user_id, remote_addr, remote_referer, remote_host, remote_port, http_referer, http_host,
			http_user_agent, request_uri,query_string, request_method, os, session_id, domain, category) 
			VALUES (CURDATE(), CURTIME(), 0, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", 

			$cfg[DB][Table][stats_log], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_X_FORWARDED_FOR'], $_SERVER['REMOTE_HOST'], $_SERVER['REMOTE_PORT'],
			$_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING'], $_SERVER['REQUEST_METHOD'], $_ENV['OS'],
			$_REQUEST["PHPSESSID"], $DomainInfo[0][id], $pageData[page_id] ));
		}
	}

	function ShowTotalData () {

		global $cfg, $Stat;

		//#################

		/* хиты */
		$Stat[hits_all] = $this->db->getResultArray( sprintf( "SELECT COUNT(id) AS count FROM %s", $this->table ) );

		/* хиты 1 */
		$Stat[hits_1] = $this->db->getResultArray( sprintf( "SELECT COUNT(id) AS count FROM promycms_stats_log WHERE DATE_FORMAT(created, '%s') = DATE_ADD(DATE_FORMAT(NOW(),'%s'), INTERVAL 0 DAY)", '%Y-%m-%d', date("Y-m-d") ) );

		/* хиты 2 */
		$Stat[hits_2] = $this->db->getResultArray( sprintf( "SELECT COUNT(id) AS count FROM promycms_stats_log WHERE DATE_FORMAT(created, '%s') = DATE_ADD(DATE_FORMAT(NOW(),'%s'), INTERVAL -1 DAY)", '%Y-%m-%d', date("Y-m-d") ) );

		/* хиты 7 */
		$Stat[hits_7] = $this->db->getResultArray( sprintf( "SELECT COUNT(id) AS count FROM promycms_stats_log WHERE created > DATE_ADD(NOW(), INTERVAL -7 DAY)", $this->table ) );

		/* хиты 30 */
		$Stat[hits_30] = $this->db->getResultArray( sprintf( "SELECT COUNT(id) AS count FROM promycms_stats_log WHERE created > DATE_ADD(NOW(), INTERVAL -30 DAY)", $this->table ) );

		//#################

		/* хосты */
		$Stat[hosts_all] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr) AS count FROM %s ORDER BY remote_addr", $this->table ) );

		$Stat[hosts_1] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr) AS count FROM %s WHERE DATE_FORMAT(created, '%s') = DATE_ADD(DATE_FORMAT(NOW(),'%s'), INTERVAL 0 DAY) ORDER BY remote_addr", $this->table, '%Y-%m-%d', date("Y-m-d") ) );

		$Stat[hosts_2] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr) AS count FROM %s WHERE DATE_FORMAT(created, '%s') = DATE_ADD(DATE_FORMAT(NOW(),'%s'), INTERVAL -1 DAY) ORDER BY remote_addr", $this->table,'%Y-%m-%d', date("Y-m-d") ) );

		$Stat[hosts_7] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr) AS count FROM %s WHERE created > DATE_ADD(NOW(), INTERVAL -7 DAY) ORDER BY remote_addr", $this->table,'%Y-%m-%d', date("Y-m-d") ) );

		$Stat[hosts_30] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr) AS count FROM %s WHERE created > DATE_ADD(NOW(), INTERVAL -30 DAY) ORDER BY remote_addr", $this->table,'%Y-%m-%d', date("Y-m-d") ) );

		//#################

		/* поситетели */
		$Stat[visits_all] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr, remote_referer) AS count FROM %s ORDER BY remote_addr, remote_referer", $this->table ) );

		$Stat[visits_1] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr, remote_referer) AS count FROM %s WHERE DATE_FORMAT(created, '%s') = DATE_ADD(DATE_FORMAT(NOW(),'%s'), INTERVAL 0 DAY) ORDER BY remote_addr, remote_referer", $this->table, '%Y-%m-%d', date("Y-m-d") ) );

		$Stat[visits_2] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr, remote_referer) AS count FROM %s WHERE DATE_FORMAT(created, '%s') = DATE_ADD(DATE_FORMAT(NOW(),'%s'), INTERVAL -1 DAY) ORDER BY remote_addr, remote_referer", $this->table, '%Y-%m-%d', date("Y-m-d") ) );

		$Stat[visits_7] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr, remote_referer) AS count FROM %s WHERE created > DATE_ADD(NOW(), INTERVAL -7 DAY) ORDER BY remote_addr, remote_referer", $this->table ) );

		$Stat[visits_30] = $this->db->getResultArray( sprintf( "SELECT COUNT(DISTINCT remote_addr, remote_referer) AS count FROM %s WHERE created > DATE_ADD(NOW(), INTERVAL -30 DAY) ORDER BY remote_addr, remote_referer", $this->table ) );
	}

	function Traffic ($period_1, $period_2, $type) {

		global $cfg;


		$sql .= "date_created >= '".strftime("%Y-%m-%d", date2unix($period_1))."' AND date_created <='".strftime("%Y-%m-%d", date2unix($period_2))."'";

		return  $this->db->getResultArray( sprintf( "
		
		SELECT date_created, COUNT(id) AS hits, 
		COUNT(DISTINCT remote_addr) AS hosts, 
		COUNT(DISTINCT remote_addr, remote_referer) AS visits 
		FROM %s WHERE %s GROUP BY DATE_FORMAT(date_created, '%s')
		
		", $this->table,  $sql, '%d.%m.%Y' ) );
	}

	function hourly ($period_1, $period_2) {
	
		global $cfg;
		
		return $this -> db -> getResultArray ( sprintf( "
		
		SELECT DATE_FORMAT(time_created, '%s') AS date, COUNT(id) AS hits FROM %s WHERE time_created BETWEEN '00:00' AND '23:00'
		AND date_created >= '".strftime("%Y-%m-%d", date2unix($period_1))."' AND date_created <= '".strftime("%Y-%m-%d", date2unix($period_2))."'
		GROUP BY DATE_FORMAT(time_created, '%s')
		", '%H', $this->table, '%H' ) );
	}
	
	function summary ($period_1, $period_2) {
	
		global $cfg;
		
	}

	
	
	
	/*
	function StatPages ($period_1, $period_2, $type) {

	global $cfg;

	if ($period_1) {

	$sql .= "created > '".$period_1."'";

	if ($period_2) {

	$sql .= " AND created < '".$period_2."'";
	}
	} else {

	$sql .= " created > DATE_ADD(NOW(), INTERVAL -30 DAY) ";
	}

	return  $this->db->getResultArray( sprintf( "SELECT P.url, P.name, L.request_uri, COUNT(id) AS hits, COUNT(DISTINCT remote_addr) AS hosts FROM %s L INNER JOIN %s P ON P.page_id = L.category WHERE %s GROUP BY category ORDER BY hits DESC", $this->table, $cfg[DB][Table][pages], $sql ) );
	}
	*/
}

?>