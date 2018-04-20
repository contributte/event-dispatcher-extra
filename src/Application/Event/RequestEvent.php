<?php

namespace Contributte\Events\Extra\Application\Event;

use Contributte\Events\Extra\Application\AbstractApplicationEvent;
use Nette\Application\Application;
use Nette\Application\Request;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class RequestEvent extends AbstractApplicationEvent
{

	const NAME = ApplicationEvents::ON_REQUEST;

	/** @var Application */
	private $application;

	/** @var Request */
	private $request;

	/**
	 * @param Application $application
	 * @param Request $request
	 */
	public function __construct(Application $application, Request $request)
	{
		$this->application = $application;
		$this->request = $request;
	}

	/**
	 * @return Application
	 */
	public function getApplication()
	{
		return $this->application;
	}

	/**
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

}
