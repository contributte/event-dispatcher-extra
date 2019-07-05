# Contributte Event Dispatcher Extra

## Content

- [Setup](#setup)
- [Events list](#events-list)
- [Implementing subscriber](#subscriber)

## Setup

```bash
composer require contributte/event-dispatcher-extra
```

```yaml
extensions:
    events: Contributte\EventDispatcher\DI\EventDispatcherExtension

    # register all event bridges
    events.extra: Contributte\Events\Extra\DI\EventBridgesExtension

events.extra:
    # optionally disable these bridges
    application: false
    security: false
    latte: false
```

You can also register bridges one by one.

```yaml
extensions:
    # register only bridges of your choice
    events.application: Contributte\Events\Extra\DI\EventApplicationBridgeExtension
    events.security: Contributte\Events\Extra\DI\EventSecurityBridgeExtension
    events.latte: Contributte\Events\Extra\DI\EventLatteBridgeExtension
```

## Events list

There are several events on which you can listen to.

**Nette Application events:**

```php
use Contributte\Events\Extra\Event\Application\ErrorEvent;
use Contributte\Events\Extra\Event\Application\PresenterEvent;
use Contributte\Events\Extra\Event\Application\PresenterStartupEvent;
use Contributte\Events\Extra\Event\Application\PresenterShutdownEvent;
use Contributte\Events\Extra\Event\Application\RequestEvent;
use Contributte\Events\Extra\Event\Application\ResponseEvent;
use Contributte\Events\Extra\Event\Application\ShutdownEvent;
use Contributte\Events\Extra\Event\Application\StartupEvent;
```

**Nette Latte events:**

```php
use Contributte\Events\Extra\Event\Latte\LatteCompileEvent;
use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;
```

**Nette Security events:**

```php
use Contributte\Events\Extra\Event\Security\LoggedInEvent;
use Contributte\Events\Extra\Event\Security\LoggedOutEvent;
```

## Subscriber

```php
use Contributte\Events\Extra\Event\Application\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class LogRequestSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [RequestEvent::class => 'onLog'];
    }

    public function onLog(RequestEvent $event): void
    {
        // Do magic..
    }
    
}
```
