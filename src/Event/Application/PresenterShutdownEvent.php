<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\IResponse;
use Nette\Application\UI\Presenter;
use Symfony\Component\EventDispatcher\Event;

class PresenterShutdownEvent extends Event
{

	public const NAME = ApplicationEvents::ON_PRESENTER_SHUTDOWN;

	/** @var Presenter */
	private $presenter;

	/** @var IResponse|null */
	private $response;

	public function __construct(Presenter $presenter, ?IResponse $response = null)
	{
		$this->presenter = $presenter;
		$this->response = $response;
	}

	public function getPresenter(): Presenter
	{
		return $this->presenter;
	}

	public function getResponse(): ?IResponse
	{
		return $this->response;
	}

}
