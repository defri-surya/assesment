@extends('layouts.stisla')

@section('content')
    <div class="main-content">
        <section class="section">
            {{-- <div class="section-header">
        
      </div> --}}
            <div class="row mt-5">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="col-md-8">
                                            <h5>HASIL UJIAN HOLLAND SEMUA SEKOLAH</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <form method="GET" action="{{ route('hasilalls.index') }}">
                                                <div class="input-group">
                                                    <input type="text" name="cari" class="form-control"
                                                        placeholder="Cari Nama / NISN">
                                                    <div class="input-group-btn">
                                                        <button class="btn btn-primary"><i
                                                                class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-md text-center">
                                                <tbody>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>NISN</th>
                                                        <th>Asal Sekolah</th>
                                                        <th>Tanggal TES</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @forelse ($data as $item => $hasilsemua)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $hasilsemua->nama }}</td>
                                                            <td>{{ $hasilsemua->nisn }}</td>
                                                            <td>{{ $hasilsemua->namasekolah }}</td>
                                                            <td>{{ Carbon\Carbon::parse($hasilsemua->created_at)->isoFormat('D MMMM Y') }}
                                                            </td>
                                                            <td>
                                                                <form method="POST"
                                                                    action="{{ route('hasilsemua.destroy', $hasilsemua) }}"
                                                                    onsubmit="return confirm('Hapus Data, Anda Yakin ?')">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <a class="btn btn-primary"
                                                                        href="{{ route('hasilalls.show', $hasilsemua) }}"><i
                                                                            class="fas fa-eye"></i></a>
                                                                    <button class="btn btn-icon btn-danger"><i
                                                                            class="fas fa-trash"></i></button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                    <div class="card-footer text-right">
                                        <nav class="d-inline-block">
                                            <ul class="pagination mb-0">
                                                {{ $data->links() }}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
