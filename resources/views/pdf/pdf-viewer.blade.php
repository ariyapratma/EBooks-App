<!DOCTYPE html>
<html>

<head>
    <title>{{ $ebook->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .content {
            margin: 20px 0;
            position: relative;
            height: 80vh;
            /* Adjust height to fit your layout */
        }

        .pdf-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .pdf-container iframe {
            border: none;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <h1>{{ $ebook->name }}</h1>
    <div class="content">
        <div class="pdf-container">
            <iframe src="{{ route('ebooks.pdf', $ebook->id) }}" type="application/pdf"></iframe>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent text selection and copying
            document.addEventListener('copy', function(e) {
                e.preventDefault();
                console.log('Penyalinan teks tidak diizinkan.');
            });

            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                console.log('Klik kanan tidak diizinkan.');
            });

            // Prevent download via URL
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && (e.key === 's' || e.key === 'p')) {
                    e.preventDefault();
                    console.log('Fungsi simpan dan cetak dinonaktifkan.');
                }
            });

            // Warn user if they try to switch tabs
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    alert('Anda tidak dapat beralih tab saat melihat PDF.');
                }
            });
        });
    </script>
</body>

</html>
