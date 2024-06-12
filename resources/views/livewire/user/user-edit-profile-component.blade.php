<div>
    <div class="container" style="padding: 50px 0">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="d-flex">Update Profile</h3>
                    <a href="{{ route('user.profile') }}" class="btn btn-success"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
                <div class="panel-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }} <br>
                        </div>
                    @endif
                    <form wire:submit.prevent="updateProfile">

                    <div class="col-md-4">
                        @if($newimage)
                            <img src="{{ $newimage->temporaryUrl() }}" width="100%" />
                        @elseif($image)
                            <img src="{{ asset('assets/images/profile') }}/{{ $image }}" width="100%" />
                        @else
                            <img src="https://www.kindpng.com/picc/m/24-248253_user-profile-default-image-png-clipart-png-download.png" class="" width="100%" style="margin-bottom: 1em;"/>
                        @endif
                        <input type="file" class="form-control" wire:model="newimage">
                    </div>
                    <div class="col-md-8">
                        <p><b>Nama :</b> <input type="text" class="form-control" wire:model="name"/></p>
                        <p><b>Email :</b> <input type="text" disabled class="form-control" wire:model="email"></p>
                        <p><b>Phone :</b> <input type="text" class="form-control"  wire:model="mobile"/></p>
                        <hr>
                        <p><b>Facebook :</b> <input type="text" class="form-control"  wire:model="facebook" placeholder="https://www.facebook.com/"/></p>
                        <p><b>Instagram :</b> <input type="text" class="form-control"  wire:model="instagram" placeholder="https://www.instagram.com/"/></p>
                        <p><b>Alamat :</b> <input type="text" class="form-control"  wire:model="city"/></p>
                        <p><b>Provinsi :</b> <input type="text" class="form-control"  wire:model="province"/></p>
                        <p><b>Negara :</b> <input type="text" class="form-control" wire:model="country" /></p>
                        <p><b>Kode POS :</b> <input type="text" class="form-control"  wire:model="zipcode"/></p>
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
