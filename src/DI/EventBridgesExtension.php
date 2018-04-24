<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\Validators;

class EventBridgesExtension extends CompilerExtension
{

	/** @var mixed[] */
	private $defaults = [
		'application' => [],
		'security' => [],
	];

	/** @var string[] */
	private $map = [
		'application' => EventApplicationBridgeExtension::class,
		'security' => EventSecurityBridgeExtension::class,
	];

	/** @var CompilerExtension[] */
	private $passes = [];

	/**
	 * Register services
	 */
	public function loadConfiguration(): void
	{
		$config = $this->validateConfig($this->defaults, $this->config);
		foreach ($config as $bridge => $enabled) {
			// Don't register sub extension
			if ($enabled === false) continue;

			// Security check
			Validators::assertField($config, $bridge, 'array');

			// Register sub extension a.k.a CompilerPass
			$this->passes[$bridge] = new $this->map[$bridge]();
			$this->passes[$bridge]->setCompiler($this->compiler, $this->prefix($bridge));
			$this->passes[$bridge]->setConfig($this->config[$bridge] ?? []);
			$this->passes[$bridge]->loadConfiguration();
		}
	}

	/**
	 * Decorate services
	 */
	public function beforeCompile(): void
	{
		foreach ($this->passes as $pass) {
			$pass->beforeCompile();
		}
	}

	/**
	 * Decorate initialize method
	 */
	public function afterCompile(ClassType $class): void
	{
		foreach ($this->passes as $pass) {
			$pass->afterCompile($class);
		}
	}

}
