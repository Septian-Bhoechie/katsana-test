<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicle_positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'latitude', 'longitude', 'geocoding_address', 'speed', 'voltage', 'distance', 'tracker_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'tracker_at',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['speed_kmh'];

    public function getSpeedKmhAttribute()
    {
        return $this->speed ? $this->speed * 1.852 : 0;
    }
}
