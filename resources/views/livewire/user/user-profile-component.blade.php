<div>
    <div class="container" style="padding: 50px 0">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Profile</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        {{-- @if ($user->profile->image)
                            <img src="{{ asset('assets/images/profile') }}/{{ $user->profile->image }}" width="100%" />
                            @else
                            <img src="{{ asset('assets/images/profile') }}/default.jpg" width="100%" />
                            @endif --}}
                        <img src="{{ asset('assets/images/profile') }}/{{ $user->profile->image }}" width="100%" />
                    </div>
                    <div class="col-md-8">
                        @if(Auth::user()->status === 0)
						<div class="alert alert-info">
                            <i class="bi bi-info-circle-fill"></i> Akun Menunggu Approvement Admin
                        </div>
                        @endif
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $user->profile->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Facebook</th>
                                <td><a href="{{ $user->profile->facebook}}" target="__blank">{{ $user->profile->facebook}}</a></td>
                            </tr>
                            <tr>
                                <th>Instagram</th>
                                <td><a href="{{ $user->profile->instagram}}" target="__blank">{{ $user->profile->instagram}}</a></td>
                            </tr>
                            <tr>
                                <th>alamat</th>
                                <td>{{ $user->profile->city}}</td>
                            </tr>
                            <tr>
                                <th>Provinsi</th>
                                <td>{{ $user->profile->province}}</td>
                            </tr>
                            <tr>
                                <th>Kode Pos</th>
                                <td>{{ $user->profile->zipcode}}</td>
                            </tr>
                            <tr>
                                <th>Negara</th>
                                <td>{{ $user->profile->country}}</td>
                            </tr>
                            <tr>
                                <th>Map</th>
                                <td>{!! $user->profile->map !!}</td>
                            </tr>
                            <tr>
                                <th>Latitude , Longitude</th>
                                <td>
                                    {!! $user->profile->latitude !!},
                                    {!! $user->profile->longitude !!}<br>
                                    <a href="https://www.google.com/maps?q={!! $user->profile->latitude !!},{!! $user->profile->longitude !!}" class="btn btn-primary" target="__blank"><i class="fa fa-map"></i> Map</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ $user->created_at->format('l, j-M-Y')}} ({{ $user->created_at->diffForHumans() }})</td>
                            </tr>
                        </table>

                        <a href="{{ route('user.editprofile') }}" class="btn btn-info pull-right"><i class="fa fa-pencil"></i> Update Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
