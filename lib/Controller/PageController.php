<?php

namespace OCA\DutyRoster\Controller;

use OCP\Util;
use OCP\IL10N;
use OCP\IRequest;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use Psr\Log\LoggerInterface;
use OCP\Calendar\IManager;
use OCP\IUserSession;

class PageController extends Controller {
	private const TEMPLATE_MAIN = 'main';

	protected $appName;

	/** @var IL10N */
	private $l10n;

	/** @var LoggerInterface */
	private $logger;

	/** @var IRequest */
	protected $request;

	protected $manager;

	protected $userSession;

	public function __construct(
		string $appName,
		IRequest $request,
		IL10N $l10n,
		LoggerInterface $logger,
		IUserSession $userSession,
		IManager $manager
	) {
		parent::__construct($appName, $request);
		$this->manager = $manager;
		$this->appName = $appName;
		$this->userSession = $userSession;

		$this->l10n = $l10n;
		$this->logger = $logger;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function index(): TemplateResponse {
		Util::addScript($this->appName, 'dutyroster-main');
		Util::addStyle($this->appName, 'dutyroster');
		return new TemplateResponse($this->appName, self::TEMPLATE_MAIN);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return TemplateResponse
	 */
	public function views(): TemplateResponse {
		return $this->index();
	}

}
