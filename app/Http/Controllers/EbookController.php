<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    // Menampilkan daftar eBook
    public function index()
    {
        $ebooks = Ebook::all();
        return view('dashboard', compact('ebooks'));
    }

    // Menampilkan form untuk menambahkan eBook baru
    public function create()
    {
        return view('ebooks.create');
    }

    // Menyimpan eBook baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pdf' => 'required|mimes:pdf|max:10000',
        ]);

        try {
            $pdfPath = $request->file('pdf')->store('ebooks', 'public');

            Ebook::create([
                'name' => $request->name,
                'pdf_path' => $pdfPath,
            ]);

            return redirect()->route('dashboard')->with('success', 'eBook berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan eBook.');
        }
    }

    // Menampilkan eBook
    public function show(Ebook $ebook)
    {
        return view('ebooks.show', compact('ebook'));
    }

    // Menampilkan form untuk mengedit eBook
    public function edit(Ebook $ebook)
    {
        return view('ebooks.edit', compact('ebook'));
    }

    // Memperbarui eBook
    public function update(Request $request, Ebook $ebook)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pdf' => 'nullable|mimes:pdf|max:10000',
        ]);

        try {
            if ($request->hasFile('pdf')) {
                // Hapus PDF lama
                Storage::delete('public/' . $ebook->pdf_path);

                // Simpan PDF baru
                $pdfPath = $request->file('pdf')->store('ebooks', 'public');
                $ebook->update([
                    'name' => $request->name,
                    'pdf_path' => $pdfPath,
                ]);
            } else {
                $ebook->update([
                    'name' => $request->name,
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'eBook berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui eBook.');
        }
    }

    // Menghapus eBook
    public function destroy(Ebook $ebook)
    {
        try {
            Storage::delete('public/' . $ebook->pdf_path);
            $ebook->delete();
            return redirect()->route('dashboard')->with('success', 'eBook berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus eBook.');
        }
    }

    // Menampilkan PDF
    public function showPdf($id)
    {
        $ebook = Ebook::findOrFail($id);
        $pdfPath = storage_path('app/public/' . $ebook->pdf_path);

        if (!file_exists($pdfPath)) {
            abort(404, 'File not found.');
        }

        return response()->file($pdfPath);
    }


    public function generatePdfWithSecurity($id)
    {
        $ebook = Ebook::findOrFail($id);

        // Inisialisasi Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Render view ke dalam HTML
        $html = view('pdf.pdf-viewer', ['ebook' => $ebook])->render();

        // Load HTML ke Dompdf
        $dompdf->loadHtml($html);

        // Render PDF (optional: atur ukuran dan orientasi)
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Menyimpan PDF ke file sementara
        $pdfFilePath = storage_path('app/public/temp.pdf');
        file_put_contents($pdfFilePath, $dompdf->output());

        // Mengatur PDF untuk ditampilkan tanpa download
        return response()->file($pdfFilePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="ebook.pdf"',
        ]);
    }
}
