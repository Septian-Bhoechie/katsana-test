@extends('master')

@section("content")
<div class="sub-title m-b-md">
    List Vehicle Trips - {{ $vehicle->name }}
</div>
<table id="tables">
    <thead>
        <tr>
            <th>Start Datetime</th>
            <th>End Datetime</th>
            <th>Locations</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $trip)
            <tr>
                <td>
                    {{ $trip->start->tracker_at }}
                </td>
                <td>
                    {{ $trip->end->tracker_at }}
                </td>
                <td>
                    {{ $trip->end->geocoding_address }}
                </td>
                <td>
                    <a href="{{ route('vehicle.trip.export', [$trip->vehicle_id, $trip->id]) }}" target="_blank">Export CSV</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No Data Found</td>
            </tr>
        @endforelse
    </tbody>
</table>
@stop
