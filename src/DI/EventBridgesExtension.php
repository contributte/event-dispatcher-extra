<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

/**
 * @property-read mixed[] $config
 */
class EventBridgesExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'application' => Expect::anyOf(false),
			'latte' => Expect::anyOf(false),
			'security' => Expect::anyOf(false),
		])->castTo('array');
	}

	/** @var array<string, class-string<CompilerExtension>> */
	private $map = [
		'application' => EventApplicationBridgeExtension::class,
		'latte' => EventLatteBridgeExtension::class,
		'security' => EventSecurityBridgeExtension::class,
	];

	/** @var array<string, CompilerExtension> */
	private $passes = [];

	/**
	 * Register services
	 */
	public function loadConfiguration(): void
	{
		$config = $this->config;

		/** @var false|array<mixed>|object|null $bridgeConfig */
		foreach ($config as $bridge => $bridgeConfig) {
			// Don't register sub extension
			if ($bridgeConfig === false) {
				continue;
			}

			/** @var CompilerExtension $pass */
			$pass = new $this->map[$bridge]();
			$pass->setCompiler($this->compiler, $this->prefix($bridge));

			if ($bridgeConfig !== null) {
				$pass->setConfig($bridgeConfig);
			}

			$pass->loadConfiguration();

			// Register sub extension a.k.a CompilerPass
			$this->passes[$bridge] = $pass;
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
	public function afterCompile(ClassType $class)
	{
		foreach ($this->passes as $pass) {
			$pass->afterCompile($class);
		}
	}

}
