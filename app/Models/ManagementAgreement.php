<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ManagementAgreement extends Model { protected $fillable=['property_client_id','property_id','reference','starts_on','ends_on','management_fee','document_path','status']; protected function casts():array{return ['starts_on'=>'date','ends_on'=>'date'];} }
