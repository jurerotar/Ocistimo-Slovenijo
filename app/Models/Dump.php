<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;


class Dump extends Model
{
    use SoftDeletes;

    protected $hidden = [
        'user_id',
        'deleted_at',
        'volume_id',
        'terrain_id',
        'access_id',
    ];

    protected $casts = [
        'dangerous' => 'boolean',
        'cleared' => 'boolean',
        'urgent' => 'boolean',
    ];


//    protected $appends = [
//        'volume',
//        'terrain',
//        'access',
//        'geodetic',
//        'trash_types'
//    ];


    // Relationships

    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function trashType(): HasOne
    {
        return $this->HasOne(TrashType::class);
    }

    public function estimatedTrashVolume(): HasOne
    {
        return $this->hasOne(EstimatedTrashVolume::class);
    }

    public function terrain(): BelongsTo
    {
        return $this->belongsTo(Terrain::class);
    }

    public function access(): BelongsTo
    {
        return $this->belongsTo(Access::class);
    }

    public function volume(): BelongsTo
    {
        return $this->belongsTo(Volume::class);
    }

    public function region(): HasOneThrough
    {
        return $this->hasOneThrough(Region::class, Location::class, 'dump_id', 'id', null, 'region_id');
    }

    public function municipality(): HasOneThrough
    {
        return $this->hasOneThrough(Municipality::class, Location::class, 'dump_id', 'id', null, 'municipality_id');
    }

    public function cadastralMunicipality(): HasOneThrough
    {
        return $this->hasOneThrough(CadastralMunicipality::class, Location::class, 'dump_id', 'id', null, 'cadastral_id');
    }

    // Attributes

//    public function getVolumeAttribute(): string
//    {
//        return $this->volume()->value('text');
//    }
//
//    public function getTerrainAttribute(): string
//    {
//        return $this->terrain()->value('type');
//    }
//
//    public function getAccessAttribute(): string
//    {
//        return $this->access()->value('type');
//    }
//
//    public function getGeodeticAttribute(): array
//    {
//        $cadastralMunicipality = $this->cadastralMunicipality()->first();
//        $region = $this->region()->first();
//        $municipality = $this->municipality()->first();
//        $location = $this->location()->first();
//        return [
//            'region_id' => $region->id,
//            'region' => $region->name,
//            'municipality_id' => $municipality->id,
//            'municipality' => $municipality->name,
//            'cadastral_municipality_id' => $cadastralMunicipality->id,
//            'cadastral_municipality' => $cadastralMunicipality->name,
//            'portion' => $location->value('portion'),
//            'coordinates' => [
//                'wgs84' => [
//                    'latitude' => $location->wgs84_latitude,
//                    'longitude' => $location->wgs84_langitude
//                ]
//            ]
//        ];
//    }

}
