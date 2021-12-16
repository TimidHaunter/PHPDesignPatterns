<?php

declare(strict_types=1);

namespace PHPDesignPatterns\Behavioral\Observer\Tests;

use PHPDesignPatterns\Behavioral\Observer\User;
use PHPDesignPatterns\Behavioral\Observer\UserObserver;
use PHPUnit\Framework\TestCase;

class ObserverTest extends TestCase
{
    public function testChangeInUserLeadsToUserObserverBeingNotified()
    {
        $observer = new UserObserver();

        $user = new User();
        # 给 user 添加一个观察者
        $user->attach($observer);
        # user 发送了变化
        $user->changeEmail('foo@bar.com');
        $this->assertCount(1, $observer->getChangedUsers());
    }
}