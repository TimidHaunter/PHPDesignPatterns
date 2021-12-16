<?php

abstract class Subject
{
    private $observers = [];

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

abstract class Observer
{
    abstract function update();
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

//class ConcreteObserver extends Observer
//{
//    private $name;
//    private $subject;
//
//    function __construct(ConcreteSubject $subject, $name)
//    {
//        $this->subject = $subject;
//        $this->name = $name;
//    }
//
//    public function update()
//    {
//        # 可以有其他的业务逻辑，比如操作数据库，操作邮件，操作短信
//        echo "观察者：".$this->name."的新状态是:".$this->subject->getState()."\n";
//    }
//}

class StockObserver extends Observer
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