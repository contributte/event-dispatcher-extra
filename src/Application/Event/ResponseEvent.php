<?php

namespace Contributte\Events\Extra\Application\Event;

use Contributte\Events\Extra\Application\AbstractApplicationEvent;
use Nette\Application\Application;
use Nette\Application\IResponse;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class ResponseEvent extends AbstractApplicationEvent
{

	const NAME = ApplicationEvents::ON_RESPONSE;

	/** @var Application */
	private $application;

	/** @var IResponse */
	private $response;

	/**
	 * @param Application $application
	 * @param IResponse $response
	 */
	public function __construct(Application $application, IResponse $response)
	{
		$this->application = $application;
		$this->response = $response;
	}

	/**
	 * @return Application
	 */
	public function getApplication()
	{
		return $this->application;
	}

	/**
	 * @return IResponse
	 */
	public function getResponse()
	{
		return $this->response;
	}

}
