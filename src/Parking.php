<?php

class Parking {
    private int $nbPlaces;
    private int $nbLeftPlaces;
    private array $places;
    private static ?Parking $instance = null;

    private function __construct(int $nbPlaces = 30) {
        $this->nbPlaces = $nbPlaces;
        $this->nbLeftPlaces = $nbPlaces;
        $this->places = [];
    }

    public static function getInstance(int $nbPlaces = 30): Parking {
        if (self::$instance === null) {
            self::$instance = new Parking($nbPlaces);
        }
        return self::$instance;
    }

    public function initPlaces(): void {
        for ($i = 0; $i < $this->nbPlaces; $i++) {
            $maxSize = rand(1, 3);
            $basePrice = match ($maxSize) {
                1 => 1.5,
                2 => 2.0,
                3 => 3.0,
            };
            $this->places[] = new Place($basePrice, $maxSize, $this);
        }
    }

    public function tryToPark(Vehicle $vehicle, $tick): bool {
        foreach ($this->places as $place) {
            if ($place->isAvailable() && $vehicle->getSize() <= $place->getMaxSize()) {
                $place->parkVehicle($vehicle, $tick);
                $this->nbLeftPlaces--;
                return true;
            }
        }
        return false;
    }

    public function findPlaceByVehicle(Vehicle $vehicle): ?Place {
        foreach ($this->places as $place) {
            if ($place->getVehicle() && $place->getVehicle()->getId() === $vehicle->getId()) {
                return $place;
            }
        }
        return null;
    }

    public function getLeftPlaces(): int {
        return $this->nbLeftPlaces;
    }

    public function getParkedVehicle(): array {
        $parked = [];
        foreach ($this->places as $place) {
            if (!$place->isAvailable()) {
                $parked[] = $place->getVehicle();
            }
        }
        return $parked;
    }

    public function getPlaces(): array {
        return $this->places;
    }

    public function getNbPlaces(): int {
        return $this->nbPlaces;
    }

    public function releaseVehicle(): int {
        return ++$this->nbLeftPlaces;
    }

    private function __clone()
    {
        // Prevent cloning
    }
    public function __wakeup()
    {
        // Prevent unserializing
    }
}
