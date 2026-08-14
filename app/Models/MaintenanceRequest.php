<?php
namespace App\Models;
use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Model;
class MaintenanceRequest extends Model { use BelongsToOrganization; protected $fillable = ['organization_id','property_id','unit_id','tenant_id','reported_by','service_partner_id','title','description','category','priority','status','quoted_amount','scheduled_for','completed_at']; protected function casts(): array { return ['quoted_amount'=>'decimal:2','scheduled_for'=>'date','completed_at'=>'datetime']; } public function property(){return $this->belongsTo(Property::class);} public function unit(){return $this->belongsTo(Unit::class);} public function tenant(){return $this->belongsTo(Tenant::class);} public function servicePartner(){return $this->belongsTo(ServicePartner::class);} }
