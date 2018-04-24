<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

interface ApplicationEvents
{

	/**
	 * Occurs before the application loads presenter
	 */
	public const ON_STARTUP = 'nette.application.startup';

	/**
	 * Occurs before the application shuts down
	 */
	public const ON_SHUTDOWN = 'nette.application.shutdown';

	/**
	 * Occurs when a new request is ready for dispatch;
	 */
	public const ON_REQUEST = 'nette.application.request';

	/**
	 * Occurs when a presenter is created
	 */
	public const ON_PRESENTER = 'nette.application.presenter';

	/**
	 * Occurs when a new response is received
	 */
	public const ON_RESPONSE = 'nette.application.response';

	/**
	 * Occurs when an unhandled exception occurs in the application
	 */
	public const ON_ERROR = 'nette.application.error';

}
