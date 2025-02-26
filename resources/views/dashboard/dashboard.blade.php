@extends('layouts.presensi')
@section('content')
<div class="section" id="user-section">
    <div id="user-detail">
        <div class="avatar">
            @if (!empty(Auth::guard('karyawan')->user()->foto))
            @php
            $path = Storage::url('uploads/karyawan/'.Auth::guard('karyawan')->user()->foto);
            @endphp
            <img src="{{ url($path) }}" alt="avatar" class="imaged w64" style="height: 60px;">
            @else
            <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
            @endif
        </div>
        <div id="user-info">
            <h2 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h2>
            <span id="user-role">Head of IT</span>
        </div>
    </div>
</div>

<div class="section" id="menu-section">
    <div class="card">
        <div class="card-body text-center">
            <div class="list-menu">
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="green" style="font-size: 40px;">
                            <ion-icon name="person-sharp"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Profil</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="danger" style="font-size: 40px;">
                            <ion-icon name="calendar-number"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Cuti</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="warning" style="font-size: 40px;">
                            <ion-icon name="document-text"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Histori</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="orange" style="font-size: 40px;">
                            <ion-icon name="location"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        Lokasi
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section mt-2" id="presence-section">
    <div class="todaypresence">
        <div class="row">
            <div class="col-6">
                <div class="card gradasigreen">
                    <div class="card-body py-3">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                @if ($presensiharini != null)
                                @php
                                $path = Storage::url('uploads/absensi/'.$presensiharini->foto_in);
                                @endphp                        
                                <img src="{{ url($path)}}" alt="foto masuk" class="imaged w64"> 
                                @else
                                <ion-icon name="camera" class="py-2"></ion-icon>
                                @endif
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle pb-1">Masuk</h4>
                                <span>{{ $presensiharini != null ? $presensiharini->jam_in : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card gradasired">
                    <div class="card-body py-3">
                        <div class="presencecontent">
                            <div class="iconpresence">
                            @if ($presensiharini != null && $presensiharini->jam_out != null)
                                @php
                                $path = Storage::url('uploads/absensi/'.$presensiharini->foto_out);
                                @endphp                        
                                <img src="{{ url($path)}}" alt="foto masuk" class="imaged w64"> 
                            @else
                                <ion-icon name="camera" class="py-2"></ion-icon>
                            @endif
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle pb-1">Pulang</h4>
                                <span>{{ $presensiharini != null && $presensiharini->jam_out != null  ? $presensiharini->jam_out : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rekappresence">
        <!-- <div id="chartdiv"></div> -->
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="presencecontent">
                            <div class="iconpresence primary">
                                <ion-icon name="man-outline" class="text-primary"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Hadir</h4>
                                <span class="rekappresencedetail">{{ $rekappresensi->jmlhadir }} Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="presencecontent">
                            <div class="iconpresence green">
                                <ion-icon name="document-text-outline" class="text-success"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Izin</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="presencecontent">
                            <div class="iconpresence warning">
                                <ion-icon name="medkit-outline" class="text-warning"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Sakit</h4>
                                <span class="rekappresencedetail">0 Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="presencecontent">
                            <div class="iconpresence danger">
                                <ion-icon name="alarm-outline" class="text-danger"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Telat</h4>
                                <span class="rekappresencedetail">{{ $rekappresensi->jmlterlambat }} Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="presencetab mt-2">
        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        Bulan Ini
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                        Leaderboard
                    </a>
                </li>
            </ul> 
        </div>
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ( $historibulanini as $historiabsensi)
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="calendar-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>{{ date("d-m-Y", strtotime($historiabsensi->tgl_presensi)) }}</div>
                                <span class="badge badge-success">{{$historiabsensi->jam_in}}</span>
                                <span class="badge badge-danger">{{ $historiabsensi != null && $historiabsensi->jam_out != null  ? $historiabsensi->jam_out : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                    <li>
                        <div class="item">
                            <div class="icon-box bg-secondary">
                                <ion-icon name="videocam-outline" role="img" class="md hydrated"
                                    aria-label="videocam outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>Videos</div>
                                <span class="text-muted">None</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ($leaderboard as $listleaderboard )
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    <b>{{ $listleaderboard->nama_lengkap }}</b><br>
                                    <small class="text-muted">{{ $listleaderboard->jabatan }}</small>
                                </div>
                                <span class="badge {{ $listleaderboard->jam_in < '08:00' ? 'bg-success' : 'bg-danger' }}">{{ $listleaderboard->jam_in }}</span>
                            </div>
                        </div>
                    </li>

                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection