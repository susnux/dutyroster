<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Ferdinand Thiessen <rpm@fthiessen.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\DutyRoster\AppInfo;

use OCP\AppFramework\App;

class Application extends App {
	public const APP_ID = 'dutyroster';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}
}
