<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\UI;

use Symfony\Contracts\EventDispatcher\Event;

abstract class UIEvent extends Event
{

	private ?UI $ui = null;

	/** @var Changeset<mixed> */
	private ?Changeset $changeset = null;

	public function getUi(): UI
	{
		if ($this->ui === null) {
			$this->ui = new UI();
		}

		return $this->ui;
	}

	/** @return Changeset<mixed> */
	public function getChangeset(): Changeset
	{
		if ($this->changeset === null) {
			$this->changeset = new Changeset();
		}

		return $this->changeset;
	}

}
