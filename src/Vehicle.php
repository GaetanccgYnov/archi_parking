<?php

class Vehicle {
    private static int $idCounter = 1;
    private int $id;
    private int $size;
    private string $type;
    private int $arrivalTick = 0;

    public function __construct(int $size, string $type) {
        $this->id = self::$idCounter++;
        $this->size = $size;
        $this->type = $type;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setArrivalTick(int $tick): void {
        $this->arrivalTick = $tick;
    }

    public function getArrivalTick(): int {
        return $this->arrivalTick;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getSize(): int {
        return $this->size;
    }
}

class VehicleFactory {
    public static function createVehicle(string $type): Vehicle {
        return match ($type) {
            "moto" => new Vehicle(1, "moto"),
            "voiture" => new Vehicle(2, "voiture"),
            "camion" => new Vehicle(3, "camion"),
            default => throw new InvalidArgumentException("Type de véhicule inconnu : $type"),
        };
    }
}
