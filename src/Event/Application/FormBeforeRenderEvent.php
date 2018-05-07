<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

use Nette\Application\UI\Form;
use Symfony\Component\EventDispatcher\Event;

class FormBeforeRenderEvent extends Event
{

	public const NAME = ApplicationEvents::ON_FORM_BEFORE_RENDER;

	/** @var Form */
	private $form;

	public function __construct(Form $form)
	{
		$this->form = $form;
	}

	public function getForm(): Form
	{
		return $this->form;
	}

}
