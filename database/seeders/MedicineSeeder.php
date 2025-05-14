<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Illuminate\Support\Str;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar 50 obat yang biasa digunakan di klinik PMB beserta kategorinya
        $medicines = [
            // Antibiotik
            ['name' => 'Amoxicillin 500mg', 'category' => 'Antibiotik', 'price' => 5000, 'description' => 'Antibiotik untuk infeksi bakteri'],
            ['name' => 'Amoxicillin 250mg', 'category' => 'Antibiotik', 'price' => 3000, 'description' => 'Antibiotik untuk infeksi bakteri dosis rendah'],
            ['name' => 'Ampicillin 500mg', 'category' => 'Antibiotik', 'price' => 4000, 'description' => 'Antibiotik spektrum luas'],
            ['name' => 'Ciprofloxacin 500mg', 'category' => 'Antibiotik', 'price' => 7000, 'description' => 'Antibiotik golongan fluoroquinolon'],
            ['name' => 'Cefadroxil 500mg', 'category' => 'Antibiotik', 'price' => 6000, 'description' => 'Antibiotik sefalosporin generasi pertama'],
            ['name' => 'Erythromycin 500mg', 'category' => 'Antibiotik', 'price' => 5500, 'description' => 'Antibiotik golongan makrolida'],
            ['name' => 'Metronidazole 500mg', 'category' => 'Antibiotik', 'price' => 4500, 'description' => 'Antibiotik untuk infeksi anaerob'],

            // Analgesik (Pereda Nyeri)
            ['name' => 'Paracetamol 500mg', 'category' => 'Analgesik', 'price' => 2000, 'description' => 'Pereda nyeri dan antipiretik'],
            ['name' => 'Ibuprofen 400mg', 'category' => 'Analgesik', 'price' => 3500, 'description' => 'Anti-inflamasi non steroid (NSAID)'],
            ['name' => 'Asam Mefenamat 500mg', 'category' => 'Analgesik', 'price' => 3000, 'description' => 'Pereda nyeri dan anti-inflamasi'],
            ['name' => 'Diclofenac Sodium 50mg', 'category' => 'Analgesik', 'price' => 4000, 'description' => 'Anti-inflamasi kuat untuk nyeri'],
            ['name' => 'Metamizole 500mg', 'category' => 'Analgesik', 'price' => 4500, 'description' => 'Analgesik non-opioid (Antalgin)'],

            // Antipiretik (Penurun Panas)
            ['name' => 'Paracetamol Sirup 120mg/5ml', 'category' => 'Antipiretik', 'price' => 15000, 'description' => 'Penurun panas untuk anak'],
            ['name' => 'Ibuprofen Sirup 100mg/5ml', 'category' => 'Antipiretik', 'price' => 20000, 'description' => 'Penurun panas dan anti-inflamasi untuk anak'],

            // Antasida & Obat Lambung
            ['name' => 'Antasida Tablet', 'category' => 'Antasida', 'price' => 2500, 'description' => 'Menetralkan asam lambung'],
            ['name' => 'Antasida Suspensi', 'category' => 'Antasida', 'price' => 18000, 'description' => 'Menetralkan asam lambung bentuk cair'],
            ['name' => 'Ranitidine 150mg', 'category' => 'Antasida', 'price' => 3000, 'description' => 'Mengurangi produksi asam lambung'],
            ['name' => 'Omeprazole 20mg', 'category' => 'Antasida', 'price' => 5000, 'description' => 'Penghambat pompa proton (PPI)'],
            ['name' => 'Lansoprazole 30mg', 'category' => 'Antasida', 'price' => 6000, 'description' => 'Penghambat pompa proton (PPI)'],

            // Vitamin & Suplemen
            ['name' => 'Asam Folat 1mg', 'category' => 'Vitamin', 'price' => 3000, 'description' => 'Suplementasi untuk ibu hamil'],
            ['name' => 'Vitamin B Complex', 'category' => 'Vitamin', 'price' => 4000, 'description' => 'Kombinasi vitamin B'],
            ['name' => 'Vitamin C 500mg', 'category' => 'Vitamin', 'price' => 3500, 'description' => 'Meningkatkan daya tahan tubuh'],
            ['name' => 'Kalsium Laktat 500mg', 'category' => 'Vitamin', 'price' => 4500, 'description' => 'Suplementasi kalsium untuk ibu hamil dan menyusui'],
            ['name' => 'Tablet Tambah Darah (TTD)', 'category' => 'Vitamin', 'price' => 2500, 'description' => 'Mencegah dan mengatasi anemia pada ibu hamil'],
            ['name' => 'Multivitamin Prenatal', 'category' => 'Vitamin', 'price' => 7000, 'description' => 'Vitamin lengkap untuk ibu hamil'],
            ['name' => 'Vitamin D3 1000 IU', 'category' => 'Vitamin', 'price' => 6000, 'description' => 'Kesehatan tulang dan imunitas'],

            // Antialergi
            ['name' => 'Cetirizine 10mg', 'category' => 'Antihistamin', 'price' => 3500, 'description' => 'Antihistamin non-sedatif'],
            ['name' => 'Chlorpheniramine Maleate 4mg', 'category' => 'Antihistamin', 'price' => 2000, 'description' => 'Antihistamin untuk alergi (CTM)'],
            ['name' => 'Loratadine 10mg', 'category' => 'Antihistamin', 'price' => 4500, 'description' => 'Antihistamin non-sedatif'],

            // Antitusif & Ekspektoran
            ['name' => 'Ambroxol 30mg', 'category' => 'Ekspektoran', 'price' => 3500, 'description' => 'Pengencer dahak'],
            ['name' => 'Gliseril Guaiakolat 100mg', 'category' => 'Ekspektoran', 'price' => 3000, 'description' => 'Pengencer dahak (OBH)'],
            ['name' => 'Dextromethorphan 15mg', 'category' => 'Antitusif', 'price' => 3000, 'description' => 'Penekan batuk non-narkotik'],
            ['name' => 'Sirup Batuk Hitam', 'category' => 'Antitusif', 'price' => 18000, 'description' => 'Kombinasi ekspektoran dan antitusif'],

            // Antihipertensi
            ['name' => 'Captopril 25mg', 'category' => 'Antihipertensi', 'price' => 3000, 'description' => 'Obat hipertensi golongan ACE inhibitor'],
            ['name' => 'Amlodipine 10mg', 'category' => 'Antihipertensi', 'price' => 4000, 'description' => 'Obat hipertensi golongan calcium channel blocker'],
            ['name' => 'Nifedipine 10mg', 'category' => 'Antihipertensi', 'price' => 3500, 'description' => 'Calcium channel blocker untuk hipertensi'],
            ['name' => 'Methyldopa 250mg', 'category' => 'Antihipertensi', 'price' => 4500, 'description' => 'Antihipertensi untuk ibu hamil'],

            // Obat Diabetes
            ['name' => 'Metformin 500mg', 'category' => 'Antidiabetes', 'price' => 3500, 'description' => 'Menurunkan kadar gula darah'],
            ['name' => 'Glibenclamide 5mg', 'category' => 'Antidiabetes', 'price' => 3000, 'description' => 'Merangsang sekresi insulin'],

            // Obat Diare & Konstipasi
            ['name' => 'Loperamide 2mg', 'category' => 'Antidiare', 'price' => 2500, 'description' => 'Mengatasi diare akut'],
            ['name' => 'Oralit Serbuk', 'category' => 'Antidiare', 'price' => 2000, 'description' => 'Mencegah dehidrasi akibat diare'],
            ['name' => 'Attapulgite 650mg', 'category' => 'Antidiare', 'price' => 3000, 'description' => 'Absorben untuk diare'],
            ['name' => 'Lactulose Sirup', 'category' => 'Pencahar', 'price' => 25000, 'description' => 'Mengatasi konstipasi'],

            // Obat Luka & Kulit
            ['name' => 'Povidone Iodine 10%', 'category' => 'Antiseptik', 'price' => 15000, 'description' => 'Antiseptik untuk luka'],
            ['name' => 'Salep Gentamicin', 'category' => 'Obat Luar', 'price' => 12000, 'description' => 'Antibiotik topikal untuk infeksi kulit'],
            ['name' => 'Miconazole Cream', 'category' => 'Obat Luar', 'price' => 16000, 'description' => 'Antijamur topikal'],
            ['name' => 'Hydrocortisone Cream 1%', 'category' => 'Obat Luar', 'price' => 14000, 'description' => 'Antiinflamasi topikal untuk dermatitis'],
            ['name' => 'Salep Zinc Oxide', 'category' => 'Obat Luar', 'price' => 12000, 'description' => 'Untuk ruam popok dan iritasi kulit'],
            ['name' => 'Salicyl Bedak', 'category' => 'Obat Luar', 'price' => 18000, 'description' => 'Untuk penyakit kulit jamur']
        ];

        // Insert data obat ke database
        foreach ($medicines as $index => $medicine) {
            Medicine::create([
                'name' => $medicine['name'],
                'code' => 'OBT-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'description' => $medicine['description'],
                'category' => $medicine['category'],
                'stock' => rand(20, 100),
                'price' => $medicine['price'],
            ]);
        }
    }
}
