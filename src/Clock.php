<?php
class Clock
{
    private int $tick = 0;
    private array $observers = [];

    public function tick(): void
    {
        $this->tick++;
        $this->notifyObservers();
    }

    public function getTick(): int
    {
        return $this->tick;
    }

    public function addObserver(ClockObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    private function notifyObservers(): void
    {
        foreach ($this->observers as $observer) {
            $observer->onTick($this->tick);
        }
    }

    public function removeObserver(ClockObserver $observer): void
    {
        $this->observers = array_filter($this->observers, fn($obs) => $obs !== $observer);
    }
}
interface ClockObserver
{
    public function onTick(int $tick): void;
}
