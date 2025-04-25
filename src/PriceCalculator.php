<?php
class PriceCalculator {
    public static function getPrice(Vehicle $vehicle, int $duration): float {
        $rates = [
            "moto" => 1.5,
            "voiture" => 2.0,
            "camion" => 3.5,
        ];

        $rate = $rates[$vehicle->getType()] ?? 2.0;
        return round($rate * $duration, 2);
    }
}
