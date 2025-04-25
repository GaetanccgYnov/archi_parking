<?php
require_once "Clock.php";

class Road implements ClockObserver{
    private Parking $parking;
    private Clock $clock;
    private PiggyBank $piggyBank;
    private array $ongoingTickets = [];

    public function __construct(Parking $parking, Clock $clock, PiggyBank $piggyBank) {
        $this->parking = $parking;
        $this->clock = $clock;
        $this->piggyBank = $piggyBank;

        $this->clock->addObserver($this);
    }

    public function generateRandomCar(): Vehicle {
        global $parkedCarsCount;

        $types = ["moto", "voiture", "camion"];
        $type = $types[array_rand($types)];

        $parkedCarsCount++;
        return VehicleFactory::createVehicle($type);
    }

    public function vehicleArrives(Vehicle $vehicle): void {
        if ($this->parking->tryToPark($vehicle, $this->clock->getTick())) {
            echo "✅ Véhicule #{$vehicle->getId()} garé.\n";

            $place = $this->parking->findPlaceByVehicle($vehicle);
            if ($place) {
                $builder = new ParkingTicketBuilder();
                $builder
                    ->setVehicle($vehicle)
                    ->setPlace($place)
                    ->setEntryTick($this->clock->getTick());
                $this->ongoingTickets[$vehicle->getId()] = $builder;
            }
        } else {
            echo "❌ Parking plein ou véhicule trop grand.\n";
        }
    }

    public function onTick(int $tick): void {
        $this->randomlyReleaseVehicle();
    }

    public function randomlyReleaseVehicle(): void {
        $places = $this->parking->getPlaces();
        $occupied = array_filter($places, fn($p) => !$p->isAvailable());

        if (!empty($occupied) && rand(1, 3) === 1) {
            $randomPlace = $occupied[array_rand($occupied)];
            $exitTick = $this->clock->getTick();

            $vehicle = $randomPlace->getVehicle();
            $entryTick = $vehicle->getArrivalTick();
            $duration = $exitTick - $entryTick;

            if ($duration < 1) {
                return;
            }

            $vehicle = $randomPlace->releaseVehicle($exitTick);

            if ($vehicle) {
                $price = PriceCalculator::getPrice($vehicle, $duration);

                if (isset($this->ongoingTickets[$vehicle->getId()])) {
                    $builder = $this->ongoingTickets[$vehicle->getId()];
                    $ticket = $builder
                        ->setExitTick($exitTick)
                        ->setPrice($price)
                        ->build();

                    unset($this->ongoingTickets[$vehicle->getId()]);
                    echo $ticket . "\n";
                    $this->piggyBank->add($price);
                }

                $this->parking->releaseVehicle();
            }
        }
    }
}
