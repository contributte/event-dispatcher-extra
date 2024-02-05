<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Latte;

use Latte\Runtime\Template;
use Symfony\Contracts\EventDispatcher\Event;

class LatteBeforeRenderEvent extends Event
{

	private Template $template;

	public function __construct(Template $template)
	{
		$this->template = $template;
	}

	public function getTemplate(): Template
	{
		return $this->template;
	}

}
