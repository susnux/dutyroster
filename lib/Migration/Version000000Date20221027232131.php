<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\DutyRoster\Migration;

use Closure;
use OCP\DB\Types;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version000000Date20221027232131 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable('dutyroster')) {
			$table = $schema->createTable('dutyroster');
			$table->addColumn('id', Types::INTEGER, [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('related_to', Types::INTEGER, [
				'notnull' => false,
			]);
			$table->addColumn('organizer', Types::STRING, [
				'notnull' => true,
				'length' => 64,
			]),
			$table->addColumn('created', Types::INTEGER, [
				'notnull' => true,
				'comment' => 'unix-timestamp',
			]);
			$table->addColumn('modified', Types::INTEGER, [
				'notnull' => true,
				'comment' => 'unix-timestamp',
			]);
			$table->addColumn('title', Types::STRING, [
				'notnull' => true,
				'length' => 127
			]);
			$table->addColumn('description', Types::TEXT, [
				'notnull' => true,
				'default' => ''
			]);

			$table->setPrimaryKey(['id']);
			$table->addForeignKeyConstraint($table, ["related_to"], ["id"], ["onUpdate" => "CASCADE"]);
		}
		return $schema;
	}
}
