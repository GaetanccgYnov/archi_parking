<?php

class Dashboard
{
    private Parking $parking;

    public function __construct(Parking $parking)
    {
        $this->parking = $parking;
    }

    public function update(): void
    {
        $vehicles = $this->parking->getParkedVehicle();

        $counts = ["moto" => 0, "voiture" => 0, "camion" => 0];

        /** @var Vehicle $v */
        foreach ($vehicles as $v) {
            $type = $v->getType();
            if (isset($counts[$type])) {
                $counts[$type]++;
            }
        }

        $total = array_sum($counts);
        $nbPlaces = $this->parking->getNbPlaces();

        echo "\033[H\033[J";
        echo "-----------------------------\n";
        echo "🌅 Moment : Jour \n";
        echo "🚗 Véhicules en circulation :\n";
        echo "🏍️ Motos : {$counts['moto']}\n";
        echo "🚙 Voitures : {$counts['voiture']}\n";
        echo "🚚 Camions : {$counts['camion']}\n";
        echo "🔢 Total : $total\n";
        echo "🅿️ Places libres : " . $this->parking->getLeftPlaces() . "/$nbPlaces\n";
        echo "-----------------------------\n";
    }
}
