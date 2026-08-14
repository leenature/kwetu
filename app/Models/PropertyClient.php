<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToOrganization;
class PropertyClient extends Model { use BelongsToOrganization; protected $fillable=['organization_id','name','phone','email','portal_token','id_number','address']; public function properties(){return $this->hasMany(Property::class);} public function agreements(){return $this->hasMany(ManagementAgreement::class);} }
