<?php
require_once "Parking.php";
require_once "Place.php";
require_once "Vehicle.php";
require_once "Road.php";
require_once "Dashboard.php";
require_once "Clock.php";
require_once "PiggyBank.php";
require_once "PriceCalculator.php";
require_once "ParkingTicket.php";


$clock = new Clock();
$parking = Parking::getInstance(50);
$parking->initPlaces();
$piggyBank = new PiggyBank();
$road = new Road($parking, $clock, $piggyBank);
$dashboard = new Dashboard($parking);

for ($i = 0; $i < 100; $i++) {
    $clock->tick();
    $vehicle = $road->generateRandomCar();
    $road->vehicleArrives($vehicle);
    $road->randomlyReleaseVehicle();
    $dashboard->update();

    echo "🕐 Tick actuel : " . $clock->getTick() . "\n";
    echo "💰 Tirelire : " . $piggyBank->getTotal() . "€\n";
    echo "--------------------------\n";
    sleep(1);
}
