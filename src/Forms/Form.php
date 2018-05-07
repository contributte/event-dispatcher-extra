<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Forms;

use Nette\Application\UI\Form as NetteForm;

class Form extends NetteForm
{

	/** @var callable[] function(Form $form); Occurs before form render */
	public $onBeforeRender = [];

	protected function beforeRender(): void
	{
		parent::beforeRender();
		$this->onBeforeRender($this);
	}

}
