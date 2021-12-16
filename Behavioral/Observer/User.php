<?php

declare(strict_types=1);

namespace PHPDesignPatterns\Behavioral\Observer;

use SplSubject;
use SplObjectStorage;
use SplObserver;

/**
 * User implements the observed object (called Subject), it maintains a list of observers and sends notifications to
 * them in case changes are made on the User object
 *
 * PHP已经定义了两个接口来帮助实现这个模式：SplObserver 和 SplSubject
 *
 * User 类继承PHP自带的观察者模式接口 Subject，创建一个数组用来维护 observers，
 * 并且在 User 对象发生变化时，发送通知给所有的 observers
 */
class User implements SplSubject
{
    private SplObjectStorage $observers;
    private $email;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function changeEmail(string $email)
    {
        # 当邮件状态发生变化时，遍历所有的观察者
        $this->email = $email;
        $this->notify();
    }

    /**
     * 遍历所有的观察者，给每一个观察者都发送消息，通过 $observer 注入进来的 update() 方法
     */
    public function notify()
    {
        /** @var SplObserver $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}