<div style="min-height:80vh">
    <style>
    nav{
        margin-top:50px;
    }
    nav svg{
        height: 20px;
    }
    nav .hidden{
        display: block !important;
        margin-top:3em;
    }
    .bg-success{
            background:#00a045;
        }
        .bg-primary{
            background:#0081c6;
        }
        .bg-info{
            background: #00accf;
        }
    </style>
<div class="container-fluid" style="padding: 30px">
    @if($users_unapprove->count() > 0)
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b style="font-size:1.8em; color:#444">User Off</b>
                </div>
                <div class="panel-body">
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Register sebagai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $nomor = 1;
                            @endphp
                            @forelse($users_unapprove as $user_unapprove)
                            <tr>
                                <td>{{ $nomor++ }}</td>
                                <td>{{ $user_unapprove->name }}</td>
                                <td>{{ $user_unapprove->email }}</td>
                                <td>
                                    @if ($user_unapprove->utype == 'ADM')
                                    <span class="badge bg-primary">Admin</span>
                                    @endif
                                    @if ($user_unapprove->utype == 'USR')
                                    <span class="badge bg-success">User</span>
                                    @endif
                                    @if ($user_unapprove->utype == 'PNJ')
                                    <span class="badge bg-info">Penjual</span>
                                    @endif
                                    @if ($user_unapprove->utype == 'PBN')
                                    <span class="badge bg-info">Pemasok Bahan</span>
                                    @endif
                                    @if ($user_unapprove->utype == 'OPT')
                                    <span class="badge bg-secondary">Operator</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.accuser', ['user_id'=>$user_unapprove->id]) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>

                                    {{-- <form action="{{ route('admin.usersapprove', ['user_id'=>$user_unapprove->id]) }}" method="post">
                                        <button type="submit" class="btn btn-success"><i class="bi bi-clipboard2-check"></i> Terima</button>
                                    </form> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5"><p class="text-center text-warning">Data Kosong</p></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6 p-3">
                            <b style="font-size:1.8em; color:#444">All Users</b>
                        </div>
                        <div class="col-md-6">
                            {{-- <a href="{{ route('admin.adduser') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Users</a> --}}
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    @if(Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if(Session::has('active'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('active') }}
                    </div>
                        @endif
                    <table class="table table-striped table-border table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Profile Picture</th>
                                <th>Nama</th>
                                <th>No.Telp</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach($users as $u)
                            @if($u->count() > 0)
                                <tr>
                                    <td>{{ $no++}}</td>
                                    <td>
                                        @if($u->profile->image)
                                        <img src="{{ asset('assets/images/profile') }}/{{ $u->profile->image }}" alt="" width=100></td>
                                        @else
                                        <img src="https://www.perpustakaan-bi.org/img/user/blank.png" width="100" alt="">
                                        @endif
                                        <td>{{ $u->name }}</td>
                                    <td>{{ $u->profile->mobile }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>{{ $u->created_at->format('l, d-M-Y') }} <small><i>({{ $u->created_at->diffForHumans() }})</i></small></td>
                                    <td>

                                        @if ($u->utype == 'ADM')
                                        <span class="badge bg-primary">Admin</span>
                                        @endif
                                        @if ($u->utype == 'USR')
                                        <span class="badge bg-success">User</span>
                                        @endif
                                        @if ($u->utype == 'PNJ')
                                        <span class="badge bg-info">Penjual</span>
                                        @endif
                                        @if ($u->utype == 'PBN')
                                        <span class="badge bg-info">Pemasok Bahan</span>
                                        @endif
                                        @if ($u->utype == 'OPT')
                                        <span class="badge bg-secondary">Operator</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Auth::user()->utype == 'ADM')
                                        <a href="{{ route('admin.showuser', ['user_id'=>$u->id]) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                                        <a href="{{ route('admin.edituser', ['user_id'=>$u->id]) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                        <a href="#" onclick="confirm('Are you sure want to delete this user?') || event.stopImmediatePropagation()" class="btn btn-danger" wire:click.prevent="deleteUser({{ $u->id }})"><i class="fa fa-trash"></i></a>
                                        {{-- <a href="" class="btn btn-primary"><i class="bi bi-eye"></i></a> --}}
                                        @endif
                                        @if (Auth::user()->utype !== 'ADM')
                                            @if ($u->utype == 'ADM')
                                            <a href="{{ route('admin.showuser', ['user_id'=>$u->id]) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>

                                            @endif
                                            @if($u->utype !== 'ADM')
                                            <a href="{{ route('admin.showuser', ['user_id'=>$u->id]) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('admin.edituser', ['user_id'=>$u->id]) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                            <a href="#" onclick="confirm('Are you sure want to delete this user?') || event.stopImmediatePropagation()" class="btn btn-danger" wire:click.prevent="deleteUser({{ $u->id }})"><i class="fa fa-trash"></i></a>
                                            @endif
                                        @endif

                                    </td>
                                </tr>
                            @else
                            <tr>
                                <td colspan="7" class="text-center text-warning">Data Kosong</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
