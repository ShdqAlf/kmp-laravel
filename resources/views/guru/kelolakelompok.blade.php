@include('layout/head')
@include('layout/side')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="pagetitle">
        <h1>Kelola Kelompok</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Kelola Kelompok Siswa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="page-content">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Tombol Tambah Course -->
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addKelompokModal">
                                    Tambah Kelompok
                                </button>
                            </div>

                            <!-- Tabel Kelompok -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Kelompok</th>
                                        <th>Anggota</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelompokList as $kelompok)
                                    <tr>
                                        <td>{{ $kelompok->nomor_kelompok }}</td>
                                        <td>{{ $kelompok->course->name }}</td>
                                        <td>{{ implode(', ', $kelompok->users->pluck('nama')->toArray()) }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editKelompokModal" data-id="{{ $kelompok->id }}">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('kelompok.destroy', $kelompok->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelompok ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal Tambah Kelompok -->
    <div class="modal fade" id="addKelompokModal" tabindex="-1" aria-labelledby="addKelompokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('storekelompok') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course">Nama Kelompok:</label>
                            <input type="text" name="course" class="form-control" required>
                        </div>

                        <div class="form-group" id="anggota-container">
                            <label for="course">Anggota Kelompok:</label>
                            <div class="input-group">
                                <select name="anggota[]" class="form-select anggota-select" aria-label="Pilih Anggota Kelompok" multiple required>
                                    <option selected>Pilih Anggota Kelompok</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-outline-secondary" type="button" id="tambahAnggota">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Kelompok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Course -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editCourseForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course">Nama Kelompok:</label>
                            <input type="text" name="course" id="edit-course-name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="course">Anggota Kelompok:</label>
                            <!--Looping untuk anggota kelompok yang sudah ada-->
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Pilih Anggota Kelompok</option>
                                @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->nama}}</option>
                                @endforeach
                            </select>
                            <!--end looping untuk anggota kelompok-->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Menambahkan anggota baru setiap kali tombol "+" diklik
        document.getElementById('tambahAnggota').addEventListener('click', function() {
            var container = document.getElementById('anggota-container');
            var select = document.createElement('select');
            select.name = 'anggota[]';
            select.classList.add('form-select');
            select.innerHTML = `
                <option selected>Pilih Anggota Kelompok</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->nama }}</option>
                @endforeach
            `;
            container.appendChild(select);
        });
    </script>
</div>

@include('layout/foot')
</div>