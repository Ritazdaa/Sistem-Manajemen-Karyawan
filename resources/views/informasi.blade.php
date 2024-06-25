<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informasi Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Reset dan gaya dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: rgb(255, 255, 255);
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            margin-top: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Gaya untuk sidebar */
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
        .sidebar ul li.active {
            background-color: #000000;
        }

        /* Gaya untuk konten utama */
        .main-content {
            margin-left: 220px;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
            width: calc(100% - 220px);
        }
        .main-content.expanded {
            margin-left: 0;
            width: 100%;
        }
        header, footer {
            background-color: #34495e;
            color: white;
            padding: 10px;
            width: 100%;
            flex-shrink: 0;
            transition: margin-left 0.3s ease;
        }
        header.expanded {
            margin-left: 0;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
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
            display: flex;
            align-items: flex-start;
        }

        /* Gaya untuk modal */
        .detail-modal, .add-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }
        .detail-content, .add-content {
            background-color: white;
            padding: 20px;
            max-width: 600px;
            width: 80%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        .back-btn {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            margin-top: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .detail-btn-top {
            position: absolute;
            top: 20px;
            right: 20px;
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
        <header id="header">
            <nav class="navbar">
                <button class="toggle-btn" id="toggle-btn">☰</button>
                <h1>Informasi Gaji</h1>
                <div class="profile">
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </nav>
        </header>
        <main>
            <div class="container">
                <!-- Tombol Tambah -->
                <button class="btn btn-success mb-3" id="add-btn">Tambah</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Total Gaji</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n = 1;
                        @endphp
                        @foreach ($salaries as $salary)
                        <tr id="salary-{{ $salary->id }}" data-id="{{ $salary->id }}" data-nama="{{ $salary->nama }}" data-gaji-pokok="{{ $salary->gaji_pokok }}" data-tunjangan="{{ $salary->tunjangan }}" data-transport="{{ $salary->transport }}" data-lembur="{{ $salary->lembur }}">
                            <th scope="row">{{ $n }}</th>
                            <td>{{ $salary->nama }}</td>
                            <td>{{ $salary->nip }}</td>
                            <td>{{ $salary->jabatan }}</td>
                            <td>{{ $salary->gaji_pokok + $salary->tunjangan + $salary->transport + $salary->lembur }}</td>
                            <td>
                                <button class="btn btn-warning detail-btn" data-row-id="salary-{{ $salary->id }}">Detail</button> <!-- Tombol Detail berwarna kuning -->
                                <button class="btn btn-primary edit-btn" data-row-id="salary-{{ $salary->id }}">Edit</button>
                                <button class="btn btn-danger delete-btn" data-row-id="salary-{{ $salary->id }}">Hapus</button>
                            </td>
                        </tr>
                        @php
                            $n++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal Detail -->
    <div class="detail-modal" id="detail-modal">
        <div class="detail-content">
            <div class="detail-btn-top">
                <button class="btn btn-danger close-btn" id="close-detail-modal" type="button">X</button>
            </div>
            <h2>Detail Gaji</h2>
            <div class="detail-info">
                <p><strong>Nama:</strong> <span id="detail-nama"></span></p>
                <p><strong>Gaji Pokok:</strong> <span id="detail-gaji-pokok"></span></p>
                <p><strong>Tunjangan:</strong> <span id="detail-tunjangan"></span></p>
                <p><strong>Transport:</strong> <span id="detail-transport"></span></p>
                <p><strong>Lembur:</strong> <span id="detail-lembur"></span></p>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="add-modal" id="add-modal">
        <div class="add-content">
            <div class="detail-btn-top">
                <button class="btn btn-danger close-btn" id="close-add-modal" type="button">X</button>
            </div>
            <h2>Tambah Data Gaji</h2>
            <form id="add-form" method="POST" action="{{ route('informasi.gaji.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" required>
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                </div>
                <div class="mb-3">
                    <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                    <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" required>
                </div>
                <div class="mb-3">
                    <label for="tunjangan" class="form-label">Tunjangan</label>
                    <input type="number" class="form-control" id="tunjangan" name="tunjangan" required>
                </div>
                <div class="mb-3">
                    <label for="transport" class="form-label">Transport</label>
                    <input type="number" class="form-control" id="transport" name="transport" required>
                </div>
                <div class="mb-3">
                    <label for="lembur" class="form-label">Lembur</label>
                    <input type="number" class="form-control" id="lembur" name="lembur" required>
                </div>
                <button type="submit" class="btn btn-success">Tambah</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-7Dc0E/voNbLa4xZp5KPfjDcS3nsV3nyFgBGfIms/f4DvHphIqF4HGZS+Ql4DDJLHj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-tb1l0JO0aP5G1fjF8WZ2mHJLMZiCsadT0hvsUv0yJs5FefpZ/q7Sq8I1D0/w7OUs" crossorigin="anonymous"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Fungsionalitas toggle sidebar
    const toggleBtn = document.getElementById('toggle-btn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const header = document.getElementById('header');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('hide'); // Mengubah visibilitas sidebar
        mainContent.classList.toggle('expanded'); // Memperluas area konten utama saat sidebar disembunyikan
        header.classList.toggle('expanded'); // Memperluas header saat sidebar disembunyikan
    });

    // Fungsionalitas modal detail
    const detailModal = document.getElementById('detail-modal');
    const closeDetailModalBtns = document.querySelectorAll('.close-btn');
    const detailBtns = document.querySelectorAll('.detail-btn');

    detailBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const rowId = btn.getAttribute('data-row-id');
            const nama = document.getElementById(rowId).getAttribute('data-nama');
            const gajiPokok = document.getElementById(rowId).getAttribute('data-gaji-pokok');
            const tunjangan = document.getElementById(rowId).getAttribute('data-tunjangan');
            const transport = document.getElementById(rowId).getAttribute('data-transport');
            const lembur = document.getElementById(rowId).getAttribute('data-lembur');

            document.getElementById('detail-nama').textContent = nama;
            document.getElementById('detail-gaji-pokok').textContent = gajiPokok;
            document.getElementById('detail-tunjangan').textContent = tunjangan;
            document.getElementById('detail-transport').textContent = transport;
            document.getElementById('detail-lembur').textContent = lembur;

            detailModal.style.display = 'flex'; // Menampilkan modal detail
        });
    });

    closeDetailModalBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            detailModal.style.display = 'none'; // Menyembunyikan modal detail
        });
    });

    // Fungsionalitas modal tambah
    const addModal = document.getElementById('add-modal');
    const closeAddModalBtn = document.getElementById('close-add-modal');
    const addBtn = document.getElementById('add-btn');

    addBtn.addEventListener('click', () => {
        addModal.style.display = 'flex'; // Menampilkan modal tambah
    });

    closeAddModalBtn.addEventListener('click', () => {
        addModal.style.display = 'none'; // Menyembunyikan modal tambah
    });

    // Fungsionalitas tombol edit
    const editBtns = document.querySelectorAll('.edit-btn');

    editBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const rowId = btn.getAttribute('data-row-id');
            const id = document.getElementById(rowId).getAttribute('data-id');
            // Redirect ke halaman edit
            window.location.href = `/edit/${id}`; // Perbaikan URL dengan menambahkan tanda kutip kembali (`) dan /
        });
    });

    // Fungsionalitas tombol hapus
    const deleteBtns = document.querySelectorAll('.delete-btn');

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', async () => {
            const rowId = btn.getAttribute('data-row-id');
            const id = document.getElementById(rowId).getAttribute('data-id');
            const confirmation = confirm('Apakah Anda yakin ingin menghapus data ini?');

            if (confirmation) {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const response = await fetch(`/delete/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (response.ok) {
                        alert('Data berhasil dihapus');
                        document.getElementById(rowId).remove(); // Menghapus baris dari tabel
                    } else {
                        alert('Gagal menghapus data');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                }
            }
        });
    });
});

</script>

</body>
</html>