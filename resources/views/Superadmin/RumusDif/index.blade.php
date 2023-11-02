@extends('layouts.stisla')

@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Database Rumus Dif</h1>
      </div>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
          <div class="card">
              <div class="card-header">
                  <div class="col-md-8">
                      <a class="btn btn-primary" href="{{ route('rumusdif.create') }}">Tambah Data</a>
                  </div>
                  <div class="col-md-4">
        
                  </div>
              </div>
            <div class="card-body">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                      <div class="card-header">
                        <h4>Database Rumus Dif</h4>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table table-striped table-md text-center">
                            <tbody><tr>
                              <th>No</th>
                              <th>Nilai</th>
                              <th>D</th>
                              <th>I</th>
                              <th>S</th>
                              <th>C</th>
                              <th>Aksi</th>
                            </tr>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($data as $item => $rumusdif)    
                            <tr>
                              <td>{{ $data->firstItem() + $item }}</td>
                              <td style="color: orange"><b>{{ $rumusdif->nilai }}</b></td>
                              <td>{{ $rumusdif->D }}</td>
                              <td>{{ $rumusdif->I }}</td>
                              <td>{{ $rumusdif->S }}</td>
                              <td>{{ $rumusdif->C }}</td>
                              <td>
                                    <form method="POST" action="{{ route('rumusdif.destroy', $rumusdif) }}" onsubmit="return confirm('Hapus Data, Anda Yakin ?')">
                                         @method('DELETE')
                                         @csrf
                                         <a class="btn btn-icon btn-primary" href="{{ route('rumusdif.edit', $rumusdif) }}"><i class="far fa-edit"></i></a>
                                        <button class="btn btn-icon btn-danger"><i class="fas fa-times"></i></button>
                                    </form>
                            </td>
                            </tr>
                            @empty
                                
                            @endforelse
                          </tbody></table>
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
