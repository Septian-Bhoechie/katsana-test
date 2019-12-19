<?php

namespace App\Console\Commands;

use App\Models\Vehicle\Position;
use App\Models\Vehicle\Vehicle;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GenerateVehicleTrip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:vehicle-trip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate vehicle trip data from json file';
    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => "https://nominatim.openstreetmap.org/",
            // You can set any number of default request options.
            'timeout' => 500.0,
            'defaults' => [
                'headers' => ['Content-Type' => 'application/json'],
            ],
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $raw = file_get_contents(database_path("seeds/data/vehicle_trip_20190223.json"));
        $jsonData = json_decode($raw);
        //generate collection data from json array
        $vehicleTrips = collect($jsonData)->recursive();

        // create vehicle
        $vehicle = Vehicle::create([
            "name" => "Toyota Yaris",
            'summary_max_speed' => $jsonData->summary->max_speed,
            'summary_distance' => $jsonData->summary->distance,
            'summary_violation' => $jsonData->summary->violation,
            'duration_from' => strtotime($jsonData->duration->from),
            'duration_to' => strtotime($jsonData->duration->to),
        ]);

        $this->info("created vehicle '{$vehicle->name}'");

        foreach ($vehicleTrips->first() as $vehicleTrip) {
            $start = Position::create([
                "id" => $vehicleTrip->start->id,
                "latitude" => $vehicleTrip->start->latitude,
                "longitude" => $vehicleTrip->start->longitude,
                "tracked_at" => $vehicleTrip->start->tracked_at,
            ]);

            $this->info("created start position '{$start->id}'");

            $geocodingAddress = null;
            try {
                $res = $this->client->request('GET', 'reverse', [
                    'query' => [
                        'lat' => $vehicleTrip->end->latitude,
                        'lon' => $vehicleTrip->start->longitude,
                        'format' => 'json',
                    ],
                ]);

                $body = json_decode($res->getBody()->getContents());

                if ($res->getStatusCode() == 200) {
                    $geocodingAddress = $body->display_name;
                }
            } catch (\Exception $e) {}

            $end = Position::create([
                "id" => $vehicleTrip->end->id,
                "latitude" => $vehicleTrip->end->latitude,
                "longitude" => $vehicleTrip->end->longitude,
                "tracked_at" => $vehicleTrip->end->tracked_at,
                "geocoding_address" => $geocodingAddress,
            ]);

            $this->info("created end position '{$end->id}' with address '{$geocodingAddress}'");

            $trip = $vehicle->trips()->create([
                "id" => $vehicleTrip->id,
                'start_id' => $vehicleTrip->start->id,
                'end_id' => $vehicleTrip->end->id,
                'distance' => $vehicleTrip->distance,
                'duration' => $vehicleTrip->duration,
                'max_speed' => $vehicleTrip->max_speed,
                'average_speed' => $vehicleTrip->average_speed,
                'idle_duration' => $vehicleTrip->idle_duration,
                'score' => $vehicleTrip->score,
            ]);

            $this->info("created trip '{$trip->id}'");

            foreach ($vehicleTrip->idles as $idlePosition) {
                $idle = Position::find($idlePosition->id);

                if ($idle instanceof Position == false) {
                    $idle = Position::create([
                        "id" => $idlePosition->id,
                        "latitude" => $idlePosition->latitude,
                        "longitude" => $idlePosition->longitude,
                        "tracked_at" => $idlePosition->tracked_at,
                        'voltage' => $idlePosition->voltage,
                        'distance' => $idlePosition->distance,
                    ]);
                } else {
                    $idle->update([
                        "latitude" => $idlePosition->latitude,
                        "longitude" => $idlePosition->longitude,
                        "tracked_at" => $idlePosition->tracked_at,
                        'voltage' => $idlePosition->voltage,
                        'distance' => $idlePosition->distance,
                    ]);
                }

                $trip->idles()->attach($idlePosition->id);

                $this->info("created idle position '{$idle->id}'");
            }

            foreach ($vehicleTrip->histories as $historyPosition) {

                $history = Position::find($historyPosition->id);
                if ($history instanceof Position == false) {
                    $history = Position::create([
                        "id" => $historyPosition->id,
                        "latitude" => $historyPosition->latitude,
                        "longitude" => $historyPosition->longitude,
                        "tracked_at" => $historyPosition->tracked_at,
                        'speed' => $historyPosition->speed,
                        'voltage' => $historyPosition->voltage,
                        'distance' => $historyPosition->distance,
                    ]);
                } else {
                    $history->update([
                        "latitude" => $historyPosition->latitude,
                        "longitude" => $historyPosition->longitude,
                        "tracked_at" => $historyPosition->tracked_at,
                        'speed' => $historyPosition->speed,
                        'voltage' => $historyPosition->voltage,
                        'distance' => $historyPosition->distance,
                    ]);
                }

                $trip->histories()->attach($historyPosition->id);

                $this->info("created history position '{$history->id}'");
            }

            $this->info("------");
        }
    }
}
