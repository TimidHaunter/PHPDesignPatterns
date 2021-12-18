<?php

/**
 * 场景：同事都在摸鱼，想让前台秘书帮忙放风，如果领导来了，就在微信群中@所有人，告知一下。大家就会接着认真工作了。
 * 前台秘书就是 [Subject]，改变它的状态就是发现领导来视察了，通知就是在微信群里说一声，[Observer] 就是摸鱼的同事。
 * 有不同的摸鱼同事，有在工位看视频的[seeVideoObserver]，有在看股票的[StockObserver]，有在楼下抽烟的[SmokeObserver]，需要不同的方式提醒他们。
 */

abstract class Subject
{
    private $observers = [];

    # 注入观察者对象，需要把它放在待通知列表里
    public function attach(Observer $observer)
    {
        array_push($this->observers, $observer);
    }

    public function detatch($observer)
    {
        foreach ($this->observers as $key => $value) {
            if ($observer === $value) {
                unset($this->observers[$key]);
            }
        }
    }

    /**
     * 遍历所有的观察者
     * 并且去通知他们
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }
}

class ConcreteSubject extends Subject
{
    private $subjectState;

    public function setState($state)
    {
        $this->subjectState = $state;
    }

    public function getState()
    {
        return $this->subjectState;
    }
}

abstract class Observer
{
    abstract function update();
}

class StockObserver extends Observer
{
    private $name;
    private $subject;

    /**
     * 注入 ConcreteSubject 观察的目标对象，需要调用它的 getState() 方法
     */
    function __construct(ConcreteSubject $subject, $name)
    {
        $this->subject = $subject;
        $this->name = $name;
    }

    public function update()
    {
        # 给所有的炒股的发微信通知
        echo "给观察者：".$this->name.'发微信，并且告诉他们'.$this->subject->getState().PHP_EOL;
    }
}

class SeeVideoObserver extends Observer
{
    private $name;
    private $subject;

    function __construct(ConcreteSubject $subject, $name)
    {
        $this->subject = $subject;
        $this->name = $name;
    }

    public function update()
    {
        # 给所有的看视频的发QQ通知
        echo "给观察者：".$this->name.'发QQ，并且告诉他们'.$this->subject->getState().PHP_EOL;
    }
}

class SmokeObserver extends Observer
{
    private $name;
    private $subject;

    function __construct(ConcreteSubject $subject, $name)
    {
        $this->subject = $subject;
        $this->name = $name;
    }

    public function update()
    {
        # 给所有的抽烟的打电话通知
        echo "给观察者：".$this->name.'打电话，并且告诉他们'.$this->subject->getState().PHP_EOL;
    }
}

$s = new ConcreteSubject();
# Subject 和 Observer 相互依赖
$StockObserver = new StockObserver($s, "yintian");
$s->attach($StockObserver);

$SeeVideoObserver = new SeeVideoObserver($s, "xuxu");
$s->attach($SeeVideoObserver);

$SmokeObserver = new SmokeObserver($s, "feifei");
$s->attach($SmokeObserver);
$s->attach(new SmokeObserver($s, "xiaokun"));


//$z = new ConcreteObserver($s, "zenghu");
//$s->attach($z);
//$s->detatch($z);

$s->setState('boss coming!');
$s->notify();