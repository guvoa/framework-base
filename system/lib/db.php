<?php
//DB Interface functions 2017
//-----------DB_INTERFACE_Delete--------------------------------------------------------------------
function DB_INTERFACE_Delete($table_name, $table_id, $id)
{
	return delete($table_name, $table_id . ' = ' . $id);
}
//-------------------------------------------------------------------------------
//-------DB_INTERFACE_Save------------------------------------------------------------------------
function DB_INTERFACE_Save($table, $fields = array(), $fieldIds = array())
{
	save($table, $fields, $fieldIds);
}
//-------------------------------------------------------------------------------
//---------DB_INTERFACE_LoadById----------------------------------------------------------------------
function DB_INTERFACE_LoadById($table, $tableId, $id)
{
	$extra_contidions = array();
	$extra_contidions[] = array('condition' => $tableId . '= %s', 'condition_values' => array($id));

	$reg = DB_INTERFACE_Select($table, array('*'), $extra_contidions, array(), 1, 1);
	return is_array($reg) && !empty($reg) ? $reg[0] : array();
}
//-------------------------------------------------------------------------------
//------------DB_INTERFACE_Select-------------------------------------------------------------------
function DB_INTERFACE_Select(
	$table,
	$fields = array(),
	$extraConditions,
	$order = '',
	$p = 1,
	$k = 1,
	$count = false
) {

	$limit = $k >= 0 ? (($p - 1) * $k) . ',' . $k : '';
	$order = printf_array($order['order'], $order['order_values']);
	$where = '';
	$And = false;

	foreach ($extraConditions as $extraCondition) {
		if ($And) {
			$where .= ' AND ';
		} else {
			$And = true;
		}

		$where .= ' ( ' . printf_array($extraCondition['condition'], $extraCondition['condition_values']) . ' ) ';

	}

	dbEscapeArray($fields);
	return select($table, $fields, $where, $limit, $order, $count);

}
//-------------------------------------------------------------------------------
//DATABASES General Functions
//-------------db_connect------------------------------------------------------------------
function db_connect()
{
	$link = mysqli_connect('p:' . DB_HOST, DB_USER, DB_PWD, DB_DB);
	$link->query("SET NAMES 'utf8'");
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}
	db_select($link);
	return $link;
}
//-------------------------------------------------------------------------------
//-------------printf_array------------------------------------------------------------------
function printf_array($format, $arr)
{
	//debug($format);
	//debug($arr);
	//call_user_func_array("db_escape_string", $arr);
	return sprintf($format, $arr);
}
//-------------------------------------------------------------------------------
//-------------dbEscapeArray------------------------------------------------------------------
function dbEscapeArray(&$arrItem, $escapeId = true)
{
	foreach ($arrItem as $key => $val) {
		$arrItem[db_escape_string($key)] = db_escape_string($val);
	}
}
//-------------------------------------------------------------------------------
//-----------db_escape_string--------------------------------------------------------------------
function db_escape_string($str)
{
	$link = db_connect();
	return mysqli_real_escape_string($link, $str);
}
//-------------------------------------------------------------------------------
//---------db_select----------------------------------------------------------------------
function db_select($link)
{
	mysqli_select_db($link, DB_DB);
	//mysqli_query("set names 'utf8'");
}
//-------------------------------------------------------------------------------
//--------query-----------------------------------------------------------------------
function query($sql)
{
	debug($sql);
	//die;
	$link = db_connect();
	return mysqli_query($link, $sql);
}
//-------------------------------------------------------------------------------
//---------save----------------------------------------------------------------------
function save($table, $fields = array(), $fieldIds = array())
{
	//check possible update
	$w = '';
	foreach ($fieldIds as $field => $value) {
		if (!empty($value)) {
			$w = (!empty($w) ? ' AND ' : '') . $field . ' = ' . $value;
		}
	}
	if (!empty($w)) {
		return update($table, $fields, $w);
	} else {
		return insert($table, $fields);
	}
	if (DEBUG) {
		echo mysqli_error($link);
	}
}
//-------------------------------------------------------------------------------
//----------insert---------------------------------------------------------------------
function insert($table, $fields = array())
{
	$sql = 'INSERT INTO ' . $table . ' SET ';
	$comma = false;
	foreach ($fields as $field => $value) {
		if ($comma) {
			$sql .= ',';
		} else {
			$comma = true;
		}
		//$sql .= $field . ' = CONVERT(_latin1"'.(utf8_decode($value) ).'" USING utf8) ';
		//$sql .= $field . ' = "'.$value.'" ';
		$sql .= $field . ' = "' . $value . '" ';
	}

	return query($sql);
}
//-------------------------------------------------------------------------------
//----------update---------------------------------------------------------------------
function update($table, $fields = array(), $where = '')
{
	$sql = 'UPDATE ' . $table . ' SET ';
	$comma = false;
	foreach ($fields as $field => $value) {
		if ($comma) {
			$sql .= ',';
		} else {
			$comma = true;
		}
		$sql .= $field . ' = "' . $value . '" ';
	}
	$sql .= empty($where) ? '' : ' WHERE ' . $where;

	return query($sql);
}
//-------------------------------------------------------------------------------
//----------delete---------------------------------------------------------------------
function delete($table, $where)
{
	$sql = 'DELETE FROM ' . $table;
	$sql .= empty($where) ? '' : ' WHERE ' . $where;
	return query($sql);
}
//-------------------------------------------------------------------------------
//--------select-----------------------------------------------------------------------
function select($table, $fields = array(), $where = '', $limit = '', $order = '', $count = false)
{

	$f = $count ? 'COUNT(*)' : implode(',', array_filter($fields));
	//debug($f);
	//$f_string = substr($f, 0,-1);
	$sql = 'SELECT ' . $f . ' FROM ' . $table;

	$sql .= empty($where) ? '' : ' WHERE ' . $where;
	$sql .= empty($order) ? '' : ' ORDER BY ' . $order;
	$sql .= empty($limit) || !empty($count) ? '' : ' LIMIT ' . $limit;
	//debug($where);
	//debug($sql);
	//die;
	$r = query($sql);

	$result = array();
	if ($r) {
		if ($count) {
			$re = mysqli_fetch_array($r);
			$result = $re[0];
		} else {
			while ($re = mysqli_fetch_assoc($r)) {
				$result[] = $re;
			}
		}
	} else {
		$result = $count ? 0 : array();
	}

	return $result;
}
