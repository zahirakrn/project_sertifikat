@extends('layouts.dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tabel Data /</span> <b data-aos="fade-left"
                data-aos-duration="200">Peserta</b>
        </h4>

        <!-- Bordered Table -->
        <div class="card">
            <div class="row" style="margin-top: 10px;">
                <div class="col-4">
                    <h5 class="card-header">Data Peserta Tables</h5>
                </div>

                {{-- FILTER BY TRAINING --}}
                <div class="col-4">
                    <form method="GET" action="{{ route('sertifikat.index') }}">
                        <div class="row" style="margin-left: 127px;">
                            <div class="col-md-5">
                                <select class="form-select placement-dropdown" name="id_training"
                                    style="margin-top: 16px; width: 220px; margin-left: -200px;" id="exampleSelectGender">
                                    <option value="" {{ is_null(request()->get('id_training')) ? 'selected' : '' }}>
                                        Tampilkan Semua Data</option>
                                    @foreach ($training as $data)
                                        <option value="{{ $data->id }}"
                                            {{ request()->get('id_training') == $data->id ? 'selected' : '' }}>
                                            {{ $data->nama_training }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" style=" margin-top: 16px; margin-left: -50px;"
                                    class="btn btn-info d-flex align-items-center">
                                    <i class='bx bx-filter-alt' style="margin-right: 8px;"></i>
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- EXPORT BUTTON --}}
                <div class="col-2">
                    <div class="dropdown" style="margin-top: 16px; margin-left: -50px;">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-export'></i> Export
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {{-- EXPORT TO PDF BUTTON --}}
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('export.pdf', ['id_training' => request()->get('id_training')]) }}">
                                    <i class='bx bxs-file-pdf'></i> PDF
                                </a>
                            </li>
                            {{-- EXPORT TO EXCEL BUTTON --}}
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('export.excel', ['id_training' => request()->get('id_training')]) }}">
                                    <i class='bx bxs-file-export'></i> Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- CREATE DATA --}}
                <div class="col-2">
                    <div class="mt-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" style="margin-left: -60px;"
                            data-bs-target="#modalCenter">
                            <i class='bx bx-plus-circle'></i> Add Data
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Add Data
                                            Sertifikat
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    {{-- VALIDATION --}}
                                    @if ($errors->has('email'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('sertifikat.store') }}" method="post" role="form"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-icon-default-fullname">Nama
                                                        Peserta</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i class='bx bx-user'></i></span>
                                                            <input type="text" class="form-control" id="basic-icon-default-fullname" placeholder="Enter Name"
                                                                required style="padding-left: 15px;" name="nama_penerima" aria-describedby="basic-icon-default-fullname2" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label"
                                                        for="basic-icon-default-company">Nama
                                                        Pelatihan</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2"class="input-group-text"><i class='bx bx-category'></i></span>
                                                            <select id="defaultSelect" class="form-select" required name="id_training">
                                                                <option value="">Pilih Pelatihan
                                                                </option>
                                                                @foreach ($training as $data)
                                                                    <option value="{{ $data->id }}">
                                                                        {{ $data->nama_training }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Peserta</th>
                                <th>Nama Pelatihan</th>
                                <th>Status Pelatihan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php $no=1; @endphp
                            @foreach ($sertifikat as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><b>{{ $data->nama_penerima }}</b></td>
                                    <td><b>{{ Str::limit($data->training->nama_training, 26) }}</b>
                                    </td>
                                    <td style="color: {{ $data->status ? 'green' : 'blue' }}; font-weight: bold">
                                        {{ $data->status ? 'Selesai Pelatihan' : 'Terdaftar' }}
                                    </td>
                                    <td>
                                        {{-- SHOW DATA --}}
                                        <a href="{{ route('sertifikat.show', $data->id) }}"
                                            class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                            data-bs-placement="top" data-bs-html="true" title="Show">
                                            <i class='bx bx-show-alt'></i>
                                        </a>

                                        {{-- EDIT DATA --}}
                                        <!-- Button yang nge-trigger modal -->
                                        <button type="button" class="btn btn-sm btn-primary"
                                            data-bs-target="#Edit{{ $data->id }}" data-bs-toggle="modal">
                                            <i class='bx bx-edit' data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Edit" data-bs-offset="0,4" data-bs-html="true"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="Edit{{ $data->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="EditTitle">
                                                            Edit
                                                            Data Sertifikat</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('sertifikat.update', $data->id) }}"
                                                        method="post" role="form" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Nama
                                                                        Peserta</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <span id="basic-icon-default-fullname2"
                                                                            class="input-group-text"><i
                                                                                class='bx bx-user'></i></span>
                                                                        <input
                                                                            style="font-weight: bold; padding-left: 15px;"
                                                                            type="text" id="nameWithTitle" required
                                                                            class="form-control" name="nama_penerima"
                                                                            value="{{ $data->nama_penerima }}" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Nama
                                                                        Pelatihan</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <span id="basic-icon-default-fullname2"
                                                                            class="input-group-text"><i
                                                                                class='bx bx-category'></i></span>
                                                                        <select id="defaultSelect" class="form-select"
                                                                            name="id_training">
                                                                            <option>Default
                                                                                select
                                                                            </option>
                                                                            @foreach ($training as $item)
                                                                                <option value="{{ $item->id }}"
                                                                                    {{ $item->id == $data->id_training ? 'selected' : '' }}>
                                                                                    {{ $item->nama_training }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col mb-3">
                                                                    <label for="nameWithTitle" class="form-label">Status
                                                                        Pelatihan</label>
                                                                    <div class="input-group input-group-merge">
                                                                        <span id="basic-icon-default-fullname2"
                                                                            class="input-group-text"><i
                                                                                class='bx bx-category'></i></span>
                                                                        <select id="defaultSelect" class="form-select"
                                                                            required name="status"
                                                                            aria-describedby="basic-icon-default-fullname2">
                                                                            <option value="0"
                                                                                {{ $data->status == 0 ? 'selected' : '' }}>
                                                                                Terdaftar
                                                                            </option>
                                                                            <option value="1"
                                                                                {{ $data->status == 1 ? 'selected' : '' }}>
                                                                                Selesai
                                                                                Pelatihan
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- DELETE DATA --}}
                                        <form id="deleteForm{{ $data->id }}"
                                            action="{{ route('sertifikat.destroy', $data->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger"
                                                id="deleteButton{{ $data->id }}" data-bs-toggle="tooltip"
                                                data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                title="<span>Delete</span>">
                                                <i class='bx bx-trash'></i>
                                            </button>
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
@endsection
