<?php
namespace App\Http\Controllers;
use App\Models\LandingSetting;
use App\Models\ServicePartner;
class LandingController extends Controller {
    public function index() {
        $defaults = ['hero_title' => 'Run every property from one clear dashboard.', 'hero_text' => 'Kwetu helps property owners and managers track properties, tenants, leases, payments, and performance without spreadsheets.'];
        try { $content = array_replace($defaults, LandingSetting::pluck('value', 'key')->all()); $partners = ServicePartner::where('is_active', true)->orderBy('sort_order')->get(); }
        catch (\Throwable) { $content = $defaults; $partners = collect([new ServicePartner(['name' => 'Pima Maji System', 'website' => 'https://pimamajisystem.com/', 'icon' => 'bi-droplet-fill', 'description' => 'Smart water management'])]); }
        return view('welcome', compact('content', 'partners'));
    }
}
