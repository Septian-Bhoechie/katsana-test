<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vehicle_trips';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'vehicle_id', 'start_id', 'end_id', 'distance', 'duration', 'max_speed', 'average_speed', 'idle_duration', 'score',
    ];

    /**
     * Define `belongsTo` relationship with Person model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function start()
    {
        return $this->belongsTo(Position::class, 'start_id', 'id');
    }

    /**
     * Define `belongsTo` relationship with Person model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function end()
    {
        return $this->belongsTo(Position::class, 'end_id', 'id');
    }

    /**
     * Define belongs to many relations with roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function idles()
    {
        return $this->belongsToMany(Position::class, 'vehicle_trips_idles', 'trip_id', 'position_id');
    }

    /**
     * Define belongs to many relations with roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function histories()
    {
        return $this->belongsToMany(Position::class, 'vehicle_trips_histories', 'trip_id', 'position_id');
    }
}
