<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\Application;
use Nette\Application\IResponse;
use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{

	public const NAME = self::class;

	/** @var Application */
	private $application;

	/** @var IResponse */
	private $response;

	public function __construct(Application $application, IResponse $response)
	{
		$this->application = $application;
		$this->response = $response;
	}

	public function getApplication(): Application
	{
		return $this->application;
	}

	public function getResponse(): IResponse
	{
		return $this->response;
	}

}
