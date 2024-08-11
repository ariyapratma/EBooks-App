<?php

namespace Database\Seeders;

use App\Models\Ebook;
use Illuminate\Database\Seeder;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ebook::create(['name' => 'Soal Assessment Siswa Kelas X.pdf', 'pdf_path' => 'ebooks/Soal Assessment Siswa Kelas X.pdf']);
        Ebook::create(['name' => 'Soal Assessment Siswa Kelas XI.pdf', 'pdf_path' => 'ebooks/Soal Assessment Siswa Kelas XI.pdf']);
        Ebook::create(['name' => 'Soal Assessment Siswa Kelas XII.pdf', 'pdf_path' => 'ebooks/Soal Assessment Siswa Kelas XII.pdf']);
    }
}
