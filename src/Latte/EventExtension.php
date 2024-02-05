<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Latte;

use Contributte\Events\Extra\Event\Latte\LatteBeforeCompileEvent;
use Contributte\Events\Extra\Event\Latte\LatteBeforeRenderEvent;
use Latte\Engine;
use Latte\Extension;
use Latte\Runtime\Template;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventExtension extends Extension
{

	public function __construct(
		private EventDispatcherInterface $dispatcher
	)
	{
	}

	public function beforeCompile(Engine $engine): void
	{
		$this->dispatcher->dispatch(new LatteBeforeCompileEvent($engine));
	}

	public function beforeRender(Template $template): void
	{
		$this->dispatcher->dispatch(new LatteBeforeRenderEvent($template));
	}

}
