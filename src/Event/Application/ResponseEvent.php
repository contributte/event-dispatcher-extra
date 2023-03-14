<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\Application;
use Nette\Application\Response;
use Symfony\Contracts\EventDispatcher\Event;

class ResponseEvent extends Event
{

	/** @var Application */
	private $application;

	/** @var Response */
	private $response;

	public function __construct(Application $application, Response $response)
	{
		$this->application = $application;
		$this->response = $response;
	}

	public function getApplication(): Application
	{
		return $this->application;
	}

	public function getResponse(): Response
	{
		return $this->response;
	}

}
