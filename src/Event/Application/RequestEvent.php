<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\Application;
use Nette\Application\Request;
use Symfony\Contracts\EventDispatcher\Event;

class RequestEvent extends Event
{

	private Application $application;

	private Request $request;

	public function __construct(Application $application, Request $request)
	{
		$this->application = $application;
		$this->request = $request;
	}

	public function getApplication(): Application
	{
		return $this->application;
	}

	public function getRequest(): Request
	{
		return $this->request;
	}

}
