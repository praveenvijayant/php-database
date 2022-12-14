<?php
/**
 * Class Delete
 *
 * @created      28.06.2017
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\Database\Query;

/**
 * @link https://dev.mysql.com/doc/refman/5.7/en/delete.html
 * @link https://www.postgresql.org/docs/current/static/sql-delete.html
 * @link https://msdn.microsoft.com/de-de/library/ms189835(v=sql.110).aspx
 * @link https://www.firebirdsql.org/file/documentation/reference_manuals/fblangref25-en/html/fblangref25-dml-delete.html
 * @link https://www.sqlite.org/lang_delete.html
 */
class Delete extends Statement implements Where, Limit, BindValues, Query{

	public function from(string $name):Delete{
		return $this->setName($name);
	}

	public function where($val1, $val2 = null, string $operator = null, bool $bind = null, string $join = null):Delete{
		return $this->setWhere($val1, $val2, $operator, $bind, $join);
	}

	public function openBracket(string $join = null):Delete{
		return $this->setOpenBracket($join);
	}

	public function closeBracket():Delete{
		return $this->setCloseBracket();
	}

	public function limit(int $limit):Delete{
		return $this->setLimit($limit);
	}

	public function offset(int $offset):Delete{
		return $this->setOffset($offset);
	}

	/** @inheritdoc */
	protected function getSQL():array{
		return $this->dialect->delete($this->name, $this->_getWhere());
	}

}
