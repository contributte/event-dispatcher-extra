<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Application;

interface ApplicationEvents
{

	/**
	 * Occurs before the application loads presenter
	 */
	public const ON_STARTUP = StartupEvent::NAME;

	/**
	 * Occurs before the application shuts down
	 */
	public const ON_SHUTDOWN = ShutdownEvent::NAME;

	/**
	 * Occurs when a new request is ready for dispatch;
	 */
	public const ON_REQUEST = RequestEvent::NAME;

	/**
	 * Occurs when a presenter is created
	 */
	public const ON_PRESENTER = PresenterEvent::NAME;

	/**
	 * Occurs when a presenter is starting
	 */
	public const ON_PRESENTER_STARTUP = PresenterStartupEvent::NAME;

	/**
	 * Occurs when a presenter is shutting down
	 */
	public const ON_PRESENTER_SHUTDOWN = PresenterShutdownEvent::NAME;

	/**
	 * Occurs when a new response is received
	 */
	public const ON_RESPONSE = ResponseEvent::NAME;

	/**
	 * Occurs when an unhandled exception occurs in the application
	 */
	public const ON_ERROR = ErrorEvent::NAME;

}
