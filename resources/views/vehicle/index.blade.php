@extends('master')

@section("content")
<div class="sub-title m-b-md">
    List Vehicles
</div>
<table id="tables">
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>summary_max_speed</th>
            <th>summary_distance</th>
            <th>summary_violation</th>
            <th>duration_from</th>
            <th>duration_to</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $vehicle)
            <tr>
                <td>
                    {{ $vehicle->id }}
                </td>
                <td>
                    {{ $vehicle->name }}
                </td>
                <td>
                    {{ $vehicle->summary_max_speed }}
                </td>
                <td>
                    {{ $vehicle->summary_distance }}
                </td>
                <td>
                    {{ $vehicle->summary_violation }}
                </td>
                <td>
                    {{ $vehicle->duration_from->setTimezone('Asia/Kuala_Lumpur') }}
                </td>
                <td>
                    {{ $vehicle->duration_to->setTimezone('Asia/Kuala_Lumpur') }}
                </td>
                <td>
                    <a href="{{ route('vehicle.trip', $vehicle->id) }}">Trips Detail</a>
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
