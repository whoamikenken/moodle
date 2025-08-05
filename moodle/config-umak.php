<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'pgsql';
$CFG->dblibrary = 'native';
$CFG->dbhost    = '192.168.2.223';
$CFG->dbname    = 'umak_moodle';
$CFG->dbuser    = 'root';
$CFG->dbpass    = 'Pinnacle2019013!';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => 5432,
  'dbsocket' => '',
);

$CFG->session_handler_class = '\core\session\redis';
$CFG->session_redis_host = 'redis-umak-ci.umak.svc.cluster.local'; // or use your Redis host/IP
$CFG->session_redis_port = 6379;
$CFG->session_redis_database = 0;
$CFG->session_redis_acquire_lock_timeout = 120;
$CFG->session_redis_lock_expire = 7200;
$CFG->session_redis_prefix = 'moodle_';

$CFG->reverseproxy = true;
$CFG->sslproxy = true;

if (empty($_SERVER['HTTP_HOST'])) {
  $_SERVER['HTTP_HOST'] = '127.0.0.1';
}

$CFG->wwwroot   = 'https://' . $_SERVER['HTTP_HOST'];

$CFG->dataroot  = '/var/www/html/moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
