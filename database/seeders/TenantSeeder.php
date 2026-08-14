<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = [

            ['John Kamau','30123456','0712345001','john.kamau@gmail.com','Male'],
            ['Mary Wanjiku','30123457','0712345002','mary.wanjiku@gmail.com','Female'],
            ['Brian Otieno','30123458','0712345003','brian.otieno@gmail.com','Male'],
            ['Faith Njeri','30123459','0712345004','faith.njeri@gmail.com','Female'],
            ['Kevin Kiptoo','30123460','0712345005','kevin.kiptoo@gmail.com','Male'],
            ['Grace Achieng','30123461','0712345006','grace.achieng@gmail.com','Female'],
            ['Samuel Mwangi','30123462','0712345007','samuel.mwangi@gmail.com','Male'],
            ['Mercy Chebet','30123463','0712345008','mercy.chebet@gmail.com','Female'],
            ['Peter Kariuki','30123464','0712345009','peter.kariuki@gmail.com','Male'],
            ['Lilian Atieno','30123465','0712345010','lilian.atieno@gmail.com','Female'],
            ['David Mutua','30123466','0712345011','david.mutua@gmail.com','Male'],
            ['Esther Nyambura','30123467','0712345012','esther.nyambura@gmail.com','Female'],
            ['Joseph Maina','30123468','0712345013','joseph.maina@gmail.com','Male'],
            ['Alice Wairimu','30123469','0712345014','alice.wairimu@gmail.com','Female'],
            ['James Ochieng','30123470','0712345015','james.ochieng@gmail.com','Male'],
            ['Purity Jepkosgei','30123471','0712345016','purity.jepkosgei@gmail.com','Female'],
            ['Daniel Kibet','30123472','0712345017','daniel.kibet@gmail.com','Male'],
            ['Ann Muthoni','30123473','0712345018','ann.muthoni@gmail.com','Female'],
            ['Chris Odhiambo','30123474','0712345019','chris.odhiambo@gmail.com','Male'],
            ['Lucy Waithera','30123475','0712345020','lucy.waithera@gmail.com','Female'],
            ['George Kimani','30123476','0712345021','george.kimani@gmail.com','Male'],
            ['Diana Cherono','30123477','0712345022','diana.cherono@gmail.com','Female'],
            ['Eric Musyoka','30123478','0712345023','eric.musyoka@gmail.com','Male'],

        ];

        foreach ($tenants as $tenant) {

            Tenant::create([

                'organization_id' => 1,

                'full_name' => $tenant[0],

                'id_number' => $tenant[1],

                'phone' => $tenant[2],

                'email' => $tenant[3],

                'gender' => $tenant[4],

                'date_of_birth' => now()->subYears(rand(24,55))->subDays(rand(1,365)),

                'occupation' => 'Business',

                'employer' => 'Self Employed',

                'emergency_contact_name' => 'Next of Kin',

                'emergency_contact_phone' => '0799000000',

                'relationship' => 'Sibling',

                'notes' => null,

                'created_at' => now(),

                'updated_at' => now(),

            ]);

        }
    }
}