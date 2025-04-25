<?php

class ParkingTicket {
    private int $id;
    private int $entryTick;
    private int $exitTick;
    private Vehicle $vehicle;
    private Place $place;
    private float $price;

    public function __construct(
        int $id,
        int $entryTick,
        int $exitTick,
        Vehicle $vehicle,
        Place $place,
        float $price
    ) {
        $this->id = $id;
        $this->entryTick = $entryTick;
        $this->exitTick = $exitTick;
        $this->vehicle = $vehicle;
        $this->place = $place;
        $this->price = $price;
    }

    public function __toString(): string {
        return "🎫 Ticket #$this->id | Véhicule #{$this->vehicle->getId()} | " .
            "Entrée: $this->entryTick | Sortie: $this->exitTick | Prix: $this->price €";
    }
}

class ParkingTicketBuilder {
    private static int $nextId = 1;
    private int $entryTick;
    private int $exitTick;
    private Vehicle $vehicle;
    private Place $place;
    private float $price;

    public function setEntryTick(int $tick): self {
        $this->entryTick = $tick;
        return $this;
    }

    public function setExitTick(int $tick): self {
        $this->exitTick = $tick;
        return $this;
    }

    public function setVehicle(Vehicle $vehicle): self {
        $this->vehicle = $vehicle;
        return $this;
    }

    public function setPlace(Place $place): self {
        $this->place = $place;
        return $this;
    }

    public function setPrice(float $price): self {
        $this->price = $price;
        return $this;
    }

    public function build(): ParkingTicket {
        return new ParkingTicket(
            self::$nextId++,
            $this->entryTick,
            $this->exitTick,
            $this->vehicle,
            $this->place,
            $this->price
        );
    }
}
