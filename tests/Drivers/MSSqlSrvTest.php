<?php
/**
 * Class MSSqlSrvTest
 *
 * @filesource   MSSqlSrvTest.php
 * @created      28.06.2017
 * @package      chillerlan\DatabaseTest\Drivers\Native
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\DatabaseTest\Drivers;

use chillerlan\Database\Drivers\MSSqlSrv;

abstract class MSSqlSrvTest extends DriverTestAbstract{

	protected $driver = MSSqlSrv::class;
	protected $envVar = 'DB_MSSQL_';

	protected $SQL_RAW_ERROR      = '';
	protected $SQL_RAW_CREATE     = 'CREATE TABLE test (id INT NOT NULL, hash VARCHAR(32) NOT NULL)';
	protected $SQL_RAW_TRUNCATE   = 'TRUNCATE TABLE test';

#	public function setUp(){$this->markTestSkipped('use the vagrant box...');}

}