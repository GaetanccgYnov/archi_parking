<?php
class PiggyBank {
    private float $total = 0.0;

    public function add(float $amount): void {
        $this->total += $amount;
    }

    public function getTotal(): float {
        return round($this->total, 2);
    }
}
