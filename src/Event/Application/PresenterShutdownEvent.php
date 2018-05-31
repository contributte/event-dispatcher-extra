<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\IPresenter;
use Nette\Application\IResponse;
use Symfony\Component\EventDispatcher\Event;

class PresenterShutdownEvent extends Event
{

	public const NAME = ApplicationEvents::ON_PRESENTER_SHUTDOWN;

	/** @var IPresenter */
	private $presenter;

	/** @var IResponse|null */
	private $response;

	public function __construct(IPresenter $presenter, ?IResponse $response = null)
	{
		$this->presenter = $presenter;
		$this->response = $response;
	}

	public function getPresenter(): IPresenter
	{
		return $this->presenter;
	}

	public function getResponse(): ?IResponse
	{
		return $this->response;
	}

}
