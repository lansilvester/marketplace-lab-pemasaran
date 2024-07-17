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
                        <p>
                            <b>Map :</b><br>
                            <small><b><a href="http://maps.google.com" target="_blank" >Buka Maps <i class="fa fa-map"></i></b></a> > Pilih Titik Map > Bagikan > Sematkan Peta > Salin HTML > Paste pada kolom dibawah</small>
                            <input type="text" class="form-control"  wire:model="map" placeholder='<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.417195156801!2d124.88379407501361!3d1.5184910984672833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3287a06a89181dc1%3A0x2457fc5201e05955!2sPoliteknik%20Negeri%20Manado!5e0!3m2!1sid!2sid!4v1718972678819!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' /></p>
                        <p><b>Alamat :</b> <input type="text" class="form-control"  wire:model="city"/></p>
                        <p><b>Provinsi :</b> <input type="text" class="form-control"  wire:model="province"/></p>
                        <p><b>Negara :</b> <input type="text" class="form-control" wire:model="country" /></p>
                        <p><b>Kode POS :</b> <input type="text" class="form-control"  wire:model="zipcode"/></p>
                        <div class="form-group row">
                            <label for="latitude" class="col-md-4 col-form-label text-md-right">Latitude</label>

                            <div class="col-md-6">
                                <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" wire:model="latitude" required>

                                @error('latitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="longitude" class="col-md-4 col-form-label text-md-right">Longitude</label>

                            <div class="col-md-6">
                                <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" wire:model="longitude" required>

                                @error('longitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info"><i class="fa fa-pencil"></i> Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
