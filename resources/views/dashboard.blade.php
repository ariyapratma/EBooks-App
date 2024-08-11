<x-app-layout>
    <x-slot name="header">
        @if (session('success'))
            <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Daftar eBook</h3>
                <a href="{{ route('ebooks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah eBook</a>
                <table class="min-w-full bg-white border mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama eBook</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ebooks as $ebook)
                            <tr>
                                <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 border">{{ $ebook->name }}</td>
                                <td class="px-4 py-2 border text-center">
                                    <a href="{{ route('ebooks.view', $ebook->id) }}"
                                        class="text-blue-500 hover:underline"
                                        onclick="showPDF('{{ route('ebooks.view', $ebook->id) }}')">Lihat</a>
                                    <a href="{{ route('ebooks.edit', $ebook->id) }}"
                                        class="text-green-500 hover:underline ml-2">Edit</a>
                                    <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST"
                                        class="inline" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Elemen untuk menampilkan PDF -->
                <div id="pdfViewer" class="mt-6">
                    <iframe id="pdfFrame" src="" width="100%" height="600px" style="border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showPDF(pdfUrl) {
            document.getElementById('pdfFrame').src = pdfUrl;
        }

        function confirmDelete(event) {
            event.preventDefault(); // Prevent form submission by default

            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah Anda yakin ingin menghapus eBook ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Submit the form if confirmed
                }
            });
        }

        // Listener untuk perubahan visibility tab
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                Swal.fire({
                    title: 'Perhatian',
                    text: 'Anda sedang mencoba untuk berpindah tab. Apakah Anda yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Tetap di Tab Ini',
                    cancelButtonText: 'Pindah Tab'
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        // Mengalihkan kembali ke tab PDF jika tombol batal ditekan
                        document.querySelector('#pdfFrame').contentWindow.focus();
                    }
                });
            }
        });
    </script>
</x-app-layout>
