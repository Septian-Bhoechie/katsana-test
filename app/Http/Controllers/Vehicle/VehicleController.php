<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle\Trip;
use App\Models\Vehicle\Vehicle;

class VehicleController extends Controller
{

    /**
     * Show the vehicle's list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Vehicle::query();

        $data = $query->paginate(request('limit', 20));
        return view('vehicle.index', ['data' => $data]);
    }

    /**
     * Show the trips's list.
     *
     * @return \Illuminate\Http\Response
     */
    public function trip(Vehicle $vehicle)
    {
        $query = $vehicle->trips()->getQuery()->with(['start', 'end']);

        $data = $query->paginate(request('limit', 20));

        return view('vehicle.trip', ['data' => $data, 'vehicle' => $vehicle]);
    }

    /**
     * Export the trips to csv.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportTrip(Vehicle $vehicle, Trip $trip)
    {

        $filename = "trip-history.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, [
            'ID', 'Datetime', 'Latitude', 'Longitude',
            'Speed (kmh)', 'Distance (m)', 'Voltage',
        ]);

        foreach ($trip->histories as $position) {
            fputcsv($handle, [
                $position->id,
                $position->tracker_at->setTimezone('Asia/Kuala_Lumpur')->format("Y-m-d H:i:s"),
                $position->latitude,
                $position->longitude,
                $position->speed_kmh,
                $position->distance,
                $position->voltage,
            ]);
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($filename, $filename, $headers);
    }
}
