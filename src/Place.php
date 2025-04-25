<?php

class Place {
    private ?Vehicle $vehicle = null;
    private float $basePrice;
    private int $maxSize;
    private ?Parking $parking = null;

    private int $arrivalTick = 0;

    public function __construct(float $basePrice = 2.0, int $maxSize = 5, ?Parking $parking = null) {
        $this->vehicle = null;
        $this->basePrice = $basePrice;
        $this->maxSize = $maxSize;
        $this->parking = $parking;
    }


    public function parkVehicle(Vehicle $vehicle, int $tick): void {
        $this->vehicle = $vehicle;
        $this->arrivalTick = $tick;
        $vehicle->setArrivalTick($tick);
    }

    public function releaseVehicle(int $currentTick): ?Vehicle {
        $vehicle = $this->vehicle;
        if ($vehicle) {
            $duration = $currentTick - $vehicle->getArrivalTick();
            echo "⏱️ Véhicule #{$vehicle->getId()} est resté $duration ticks.\n";
        }
        $this->vehicle = null;
        return $vehicle;
    }

    public function getVehicle(): ?Vehicle {
        return $this->vehicle;
    }

    public function isAvailable(): bool {
        return $this->vehicle === null;
    }

    public function getMaxSize(): int {
        return $this->maxSize;
    }

    public function getBasePrice(): float {
        return $this->basePrice;
    }
}
