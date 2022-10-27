<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\DutyRoster\Db;

use OCP\AppFramework\Db\Entity;

/**
 * @method string getTitle()
 * @method string getOrganizer()
 * @method string getDescription()
 * @method integer getCreated()
 * @method integer getModified()
 * @method integer getRelatedTo()
 * 
 * @method void setTitle(string $value)
 * @method void setCreated(integer $value)
 * @method void setModified(integer $value)
 * @method void setOrganizer(string $value)
 * @method void setRelatedTo(integer $value)
 * @method void setDescription(string $value)
 */
class Event extends Entity {
	protected int $created;
	protected int $modified;
	protected int $relatedTo;
	protected string $title;
	protected string $organizer;
	protected string $description;

	public function __construct() {
		$this->addType('created', 'integer');
		$this->addType('modified', 'integer');
		$this->addType('relatedTo', 'integer');
	}
}
