<?php

/**
 * Interface Observer
 * 观察者的抽象接口
 */
interface Observer
{
    public function update(Subject $subject);
}

/**
 * Class ConcreteObserver
 * 具体的观察者类，实现 update()，依赖注入一个 Subject 类，从中可以获得其中的状态
 */
class ConcreteObserver implements Observer
{
    private $observerState = '';

    public function update(Subject $subject)
    {
        $this->observerState = $subject->getState();
        echo '执行观察者操作！当前状态：' . $this->observerState . PHP_EOL;
    }
}

/**
 * Class Subject
 * Subject 观察对象，维护一个观察者数组集合，有添加、删除、遍历数组的方法，目的是管理所有观察者
 */
class Subject
{
    private $observers = [];
    protected $stateNow = '';

    /**
     * 向集合添加观察者
     * @param Observer $observer
     */
    public function attach(Observer $observer)
    {
        array_push($this->observers, $observer);
    }

    public function detach(Observer $observer)
    {
        $position = 0;
        foreach ($this->observers as $ob)
        {
            if ($ob == $observer)
            {
                array_splice($this->observers, ($position), 1);
            }
            ++$position;
        }
    }

    public function notify()
    {
        foreach ($this->observers as $ob)
        {
            $ob->update($this);
        }
    }
}

/**
 * Class ConcreteSubject
 * Subject 实现类，只是更新了状态，在这个状态发生改变的时候，调用观察者遍历的方法进行所有观察的 update() 操作
 */
class ConcreteSubject extends Subject
{
    public function setState($state)
    {
        $this->stateNow = $state;
        $this->notify();
    }

    public function getState()
    {
        return $this->stateNow;
    }
}

// 实例化观察者
$observer = new ConcreteObserver();
$subject = new ConcreteSubject();
// 给 subject 添加观察者
$subject->attach($observer);
$subject->setState('更新');