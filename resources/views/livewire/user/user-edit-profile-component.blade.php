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
                        @if ($image)
                            <button type="button" class="btn btn-danger mt-2" wire:click="deleteImage"><i class="fa fa-trash"></i> Hapus Foto</button>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label"><b>Nama:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="name" class="form-control" wire:model="name"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label"><b>Email:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="email" class="form-control" wire:model="email" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-md-2 col-form-label"><b>Phone:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="mobile" class="form-control" wire:model="mobile"/>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="facebook" class="col-md-2 col-form-label"><b>Facebook:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="facebook" class="form-control" wire:model="facebook" placeholder="https://www.facebook.com/"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="instagram" class="col-md-2 col-form-label"><b>Instagram:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="instagram" class="form-control" wire:model="instagram" placeholder="https://www.instagram.com/"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="map" class="col-md-2 col-form-label"><b>Map:</b></label>
                            <div class="col-md-10">
                                <small class="d-block mb-2">
                                    <b><a href="http://maps.google.com" target="_blank">Buka Maps <i class="fa fa-map"></i></a></b> > Pilih Titik Map > Bagikan > Sematkan Peta > Salin HTML > Paste pada kolom dibawah
                                </small>
                                <input type="text" id="map" class="form-control" wire:model="map" placeholder='<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.417195156801!2d124.88379407501361!3d1.5184910984672833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3287a06a89181dc1%3A0x2457fc5201e05955!2sPoliteknik%20Negeri%20Manado!5e0!3m2!1sid!2sid!4v1718972678819!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-md-2 col-form-label"><b>Alamat:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="city" class="form-control" wire:model="city"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="province" class="col-md-2 col-form-label"><b>Provinsi:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="province" class="form-control" wire:model="province"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="country" class="col-md-2 col-form-label"><b>Negara:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="country" class="form-control" wire:model="country"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="zipcode" class="col-md-2 col-form-label"><b>Kode POS:</b></label>
                            <div class="col-md-10">
                                <input type="text" id="zipcode" class="form-control" wire:model="zipcode"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="latlong" class="col-md-2 col-form-label text-md-right">Latitude, Longitude</label>
                            <div class="col-md-10">
                                <input id="latlong" type="text" class="form-control @error('latlong') is-invalid @enderror" name="latlong" wire:model="latlong" required placeholder="e.g. 1.6405405343317592, 125.01579373387877">
                                @error('latlong')
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
