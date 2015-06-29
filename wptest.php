<?php

/*
Plugin Name: Test SmartRecord in wordpress
Plugin URI: http://github.com/limikael/smartrecord
Version: 0.0.1
*/


define("WP_DEBUG",TRUE);

require_once __DIR__."/SmartRecord.php";

//print_r(SmartRecord::flattenArray(array(array(1),2)));

class RecordTest extends SmartRecord {
	public static function initialize() {
		self::field("id","integer not null auto_increment");
		self::field("sometext","varchar(255) not null");
		self::field("otherint","varchar(255) not null");
	}
}

function activate_wpar_test() {
	RecordTest::install();

	$r=new RecordTest();
	$r->sometext="hello";
	$r->save();

	$r->otherint=123;
	$r->save();

	$id=$r->id;

	$a=RecordTest::findOne($id);

	error_log("t: ".$a->sometext);

	$a=RecordTest::findOneByQuery("SELECT * FROM %t WHERE otherint=%s AND sometext=%s",123,"hello");
	error_log("found: ".$a->sometext);

	$r->delete();

	$a=RecordTest::findOne(124123432);
}

function deactivate_wpar_test() {
	//RecordTest::uninstall();
}

register_activation_hook(__FILE__,"activate_wpar_test");
register_deactivation_hook(__FILE__,"deactivate_wpar_test");