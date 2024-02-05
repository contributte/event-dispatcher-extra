<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\Response;
use Nette\Application\UI\Presenter;
use Symfony\Contracts\EventDispatcher\Event;

class PresenterShutdownEvent extends Event
{

	private Presenter $presenter;

	private Response $response;

	public function __construct(Presenter $presenter, Response $response)
	{
		$this->presenter = $presenter;
		$this->response = $response;
	}

	public function getPresenter(): Presenter
	{
		return $this->presenter;
	}

	public function getResponse(): Response
	{
		return $this->response;
	}

}
