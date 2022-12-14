<?php
/**
 * Class SQLiteTest
 *
 * @created      02.11.2021
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2021 smiley
 * @license      MIT
 */

namespace chillerlan\DatabaseTest\Query;

use chillerlan\Database\Drivers\PDOSQLite;
use chillerlan\Database\ResultInterface;
use function extension_loaded;
use function json_encode;
use function md5;
use const PHP_VERSION_ID;

class SQLiteTest extends QueryTestAbstract{

	protected string $envPrefix  = 'DB_SQLITE3';
	protected string $driverFQCN = PDOSQLite::class;

	protected function setUp():void{

		if(!extension_loaded('pdo_sqlite')){
			$this::markTestSkipped('sqlite not installed');
		}

		parent::setUp();
	}

	protected function assertInsertResult(ResultInterface $result):void{
		$row = $result[0];

		if(PHP_VERSION_ID >= 80100){
			$this::assertSame(0, $row->id);
			$this::assertSame(123.456, $row->value);
			$this::assertSame(1, $row->active);
		}
		else{
			$this::assertSame('0', $row->id);
			$this::assertSame('123.456', $row->value);
			$this::assertSame('1', $row->active);
		}

		$this::assertSame('foo', $row->data);
	}

	protected function assertInsertMultiResult(ResultInterface $result):void{
		$this::assertSame(3, $result->count());

		if(PHP_VERSION_ID >= 80100){
			$this::assertSame(3, $result[2]->id);
			$this::assertSame(123.456, $result[0]->value);
			$this::assertSame(123.456789, $result[1]->value);
			$this::assertSame(0, $result[0]->active);
			$this::assertSame(1, $result[1]->active);

		}
		else{
			$this::assertSame('3', $result[2]->id);
			$this::assertSame('123.456', $result[0]->value);
			$this::assertSame('123.456789', $result[1]->value);
			$this::assertSame('0', $result[0]->active);
			$this::assertSame('1', $result[1]->active);
		}


	}

	public function testShowDatabases():void{
		$this->markTestSkipped('not supported');
	}

	public function testSelect():void{

		$this->db->insert
			->into($this::TABLE)
			->values($this->data())
			->multi();

		$q = $this->db->select
			->cols(['id' => 't1.id', 'hash' => ['t1.hash']])
			->from(['t1' => $this::TABLE])
			->offset(1)
			->limit(2)
		;

		$this::assertSame(3, $q->count()); // ignores limit/offset

		$r = $q->query();

		$this::assertSame(2, $r->count());
		$this::assertSame(2, (int)$r[0]['id']);
		$this::assertSame(md5(2), $r[0]['hash']);
		$this::assertSame(md5(3), $r[1]->id('md5'));
		$this::assertSame(md5(3), $r[1]->hash);

		$r = $this->db->select
			->cols(['hash', 'value'])
			->from([$this::TABLE])
			->where('active', 1)
			->query('hash')
		;

		if(PHP_VERSION_ID >= 80100){
			$this::assertSame(
				'{"c81e728d9d4c2f636f067f89cc14862c":{"hash":"c81e728d9d4c2f636f067f89cc14862c","value":123.456789}}',
				json_encode($r)
			);
		}
		else{
			$this::assertSame(
				'{"c81e728d9d4c2f636f067f89cc14862c":{"hash":"c81e728d9d4c2f636f067f89cc14862c","value":"123.456789"}}',
				json_encode($r)
			);
		}

		$r = $this->db->select
			->from([$this::TABLE])
			->where('id', [1, 2], 'in')
			->orderBy(['hash' => 'desc'])
			->query()
		;

		$this::assertSame('bar', $r[0]->data);
		$this::assertSame('foo', $r[1]->data);
		$this::assertTrue((bool)$r[0]->active);
		$this::assertFalse((bool)$r[1]->active);
	}

}
