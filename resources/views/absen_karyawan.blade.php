<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absen Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: rgb(255, 255, 255);
        }
        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            transition: transform 0.3s ease;
            transform: translateX(0);
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
        }
        .sidebar.hide {
            transform: translateX(-100%);
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            flex-grow: 1;
        }
        .sidebar ul li {
            margin: 15px 0;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
        }
        .main-content {
            margin-left: 220px;
            flex: 1;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }
        .main-content.expanded {
            margin-left: 0;
        }
        header, footer {
            background-color: #34495e;
            color: white;
            padding: 10px;
            width: 100%;
            flex-shrink: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        .profile a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
        }
        main {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .sidebar ul li:hover {
            background-color: #34495e; /* Warna latar belakang saat di-hover */
        }
        /* CSS untuk popup */
        .popup {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 300px;
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2>Presensiku</h2>
        <ul>
        <li><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li><a href="{{ route('dashboard.showDataPengguna') }}">Data Pengguna</a></li>
            <li><a href="{{ route('dashboard.absenKaryawan') }}">Absen</a></li>
            <li><a href="{{ route('riwayat_absen.index') }}">Riwayat Absen</a></li>
            <li><a href="{{ route('profil.show') }}">Profil</a></li>
            <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
            <li><a href="{{ route('informasi.gaji') }}">Informasi</a></li>
        </ul>
        <div class="logout">
            <a href="{{ route('login.logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <div class="main-content" id="main-content">
    <header>
            <nav class="navbar">
                <button class="toggle-btn" id="toggle-btn">☰</button>
                <h1>Absen Karyawan</h1>
                <div class="profile">
                @if(Auth::check())
                        <span>{{ Auth::user()->name }}</span>
                    @else
                        <span>Guest</span>
                    @endif
                </div>
            </nav>
        </header>

        <main>
            <div class="container mt-3">
                <div class="row">
                    <div class="col-md-10">
                        <h1>Form Absen Karyawan</h1>
                        
                        <form id="absenForm" action="{{ route('absen.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Input form -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" value="{{ Auth::user()->nip }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ Auth::user()->jabatan }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto Bukti Absen</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="location_name" class="form-label">Nama Lokasi</label>
                                <input type="text" class="form-control" id="location_name" name="location_name" readonly>
                            </div>
                            <button type="button" id="get-location" class="btn btn-primary">Ambil Lokasi</button>
                            <button type="submit" class="btn btn-primary">Absen</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Tambahkan div untuk popup di luar main-content -->
    <div id="popupContainer"></div>

    <!-- JavaScript dan script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        document.getElementById('get-location').addEventListener('click', function() {
            getLocation();
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            getAddress(position.coords.latitude, position.coords.longitude);
        }

        function getAddress(latitude, longitude) {
            const api_key = 'a6a9b3503db844559fbbf58354441e39'; // Ganti dengan API Key Anda
            const url = https://api.opencagedata.com/geocode/v1/json?key=${api_key}&q=${latitude}+${longitude}&pretty=1&no_annotations=1;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Tambahkan ini untuk melihat respons dari API di konsol
                    if (data.results.length > 0) {
                        const address = data.results[0].formatted;
                        document.getElementById('location_name').value = address;
                    } else {
                        console.error('No results found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching geolocation data:', error);
                });
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    console.error("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.error("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    console.error("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    console.error("An unknown error occurred.");
                    break;
            }
        }

        // Menampilkan popup sukses setelah absen berhasil di atas konten utama
        function showSuccessMessage() {
            // Buat elemen div untuk popup
            const popup = document.createElement('div');
            popup.className = 'popup alert alert-success';
            popup.textContent = 'Selamat! Anda berhasil absen';

            // Tambahkan elemen popup ke dalam popupContainer
            const popupContainer = document.getElementById('popupContainer');
            popupContainer.appendChild(popup);

            // Hapus popup setelah beberapa detik (opsional)
            setTimeout(() => {
                popup.remove();
            }, 3000); // Hapus popup setelah 3 detik
        }

        // Event listener untuk form absen
        document.getElementById('absenForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Hindari pengiriman form default

            // Lakukan pengiriman form (di sini, asumsikan berhasil)
            // Misalnya, simulasikan pengiriman data dengan timeout
            setTimeout(() => {
                // Tampilkan popup sukses di atas konten utama
                showSuccessMessage();
                // Atau, jika Anda memiliki akses ke respon server,
                // Anda dapat menampilkan popup setelah menerima respons berhasil.
                document.getElementById('absenForm').submit();
            }, 1000); // Tunggu 1 detik sebelum menampilkan popup (opsional)
        });
    </script>
</body>
</html>