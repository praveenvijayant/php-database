<?php
/**
 * Interface MultiQuery
 *
 * @created      13.01.2018
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2018 Smiley
 * @license      MIT
 */

namespace chillerlan\Database\Query;

interface MultiQuery extends Query{

	/**
	 * @return mixed
	 * @throws \chillerlan\Database\Query\QueryException
	 */
	public function multi(array $values = null);

	/**
	 * @return mixed
	 * @throws \chillerlan\Database\Query\QueryException
	 */
	public function callback(array $values, callable $callback);

}
