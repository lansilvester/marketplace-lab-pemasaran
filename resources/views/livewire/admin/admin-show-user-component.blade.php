<div style="min-height: 70vh">
    <div class="container">
        <div class="panel panel-default" style="margin:3em 0">
            <div class="panel-heading">
                <h1>User Detail</h1>
                <a href="{{ route('admin.users') }}" class="btn btn-info"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ asset('assets/images/profile') }}/{{ $image }}" alt="">
                    </div>
                    <div class="col-md-9">
                        <table class="table">
                            
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                           
                                        @if ($utype == 'ADM')
                                        <span class="badge bg-primary">Admin</span>
                                        @endif
                                        @if ($utype == 'USR')
                                        <span class="badge bg-success">User</span>
                                        @endif
                                        @if ($utype == 'PNJ')
                                        <span class="badge bg-info">Penjual</span>
                                        @endif
                                        @if ($utype == 'PBN')
                                        <span class="badge bg-info">Pemasok Bahan</span>
                                        @endif
                                        @if ($utype == 'OPT')
                                        <span class="badge bg-secondary">Operator</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td>{{ $mobile }}</td>
                                </tr>
                                <tr>
                                    <th>Facebook</th>
                                    <td>
                                        @if($facebook)
                                        <a href="{{ $facebook }}" target="__blank"><i class="bi bi-facebook"></i> {{ $facebook }}</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Instagram</th>
                                    <td>
                                        @if($instagram)
                                        <a href="{{ $instagram }}" target="__blank"><i class="bi bi-instagram"></i> {{ $instagram }}</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $city }}</td>
                                </tr>
                                <tr>
                                    <th>Kode Pos</th>
                                    <td>{{ $zipcode }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $province }}</td>
                                </tr>
                                <tr>
                                    <th>Negara</th>
                                    <td>{{ $country }}</td>
                                </tr>
                                <tr>
                                    <td colspan=2><a href="{{ route('admin.edituser', ['user_id'=>$user_id]) }}" class="btn btn-success"><i class="bi bi-pen"></i> Update</a></td>
                                </tr>
                            
                        </table>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>
