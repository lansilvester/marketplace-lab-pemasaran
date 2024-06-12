<div style="min-height:80vh; padding:20px 0">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                            <h3>Edit User </h3>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.users') }}" class="btn btn-success pull-right"><i class="bi bi-people"></i> All Users</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if (Session::has('message'))
                            <div class="alert alert-success">{{ Session::get('message') }}</div>
                        @endif
                        <form wire:submit.prevent="updateUser" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        @if($newimage)
                                            <img src="{{ $newimage->temporaryUrl() }}" width="100%" />
                                        @elseif($image)
                                            <img src="{{ asset('assets/images/profile') }}/{{ $image }}" width="100%" />
                                        @else    
                                            <img src="https://www.kindpng.com/picc/m/24-248253_user-profile-default-image-png-clipart-png-download.png" class="" width="100%" style="margin-bottom: 1em;"/>
                                        @endif
                                        <input type="file" class="form-control" wire:model="newimage">
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Name</label>
                                        <div class="col-md-8">
                                            <input type="text" wire:model="name" placeholder="Name" class="form-control">
                                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Email</label>
                                        <div class="col-md-8">
                                            <input type="text" wire:model="email" placeholder="Name" class="form-control">
                                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Type</label>
                                        <div class="col-md-8">
                                            <select name="" id=""  wire:model="utype" class="form-control">
                                              <option value="USR">User</option>
                                              <option value="ADM">Admin</option>
                                              <option value="PNJ">Penjual</option>
                                              <option value="PBN">Pemasok Bahan</option>
                                              <option value="OPT">Operator</option>
                                              
                                            </select>
                                            @error('utype') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Status</label>
                                        <div class="col-md-8">
                                            <select name="" id=""  wire:model="status" class="form-control">
                                                <option value="1">Aktif</option>
                                                <option value="0">Non-aktif</option>
                                            </select>
                                            @error('utype') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Phone</label>
                                        <div class="col-md-8">
                                            <input type="number" wire:model="mobile" placeholder="mobile" class="form-control">
                                            @error('mobile') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Instagram</label>
                                        <div class="col-md-8">
                                            <input type="text" wire:model="instagram" placeholder="https://instagram.com/" class="form-control">
                                            @error('instagram') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Facebook</label>
                                        <div class="col-md-8">
                                            <input type="text" wire:model="facebook" placeholder="https://facebook.com/" class="form-control">
                                            @error('facebook') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Alamat</label>
                                        <div class="col-md-8">
                                            <input type="text" wire:model="city" placeholder="Alamat" class="form-control">
                                            @error('city') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Provinsi</label>
                                        <div class="col-md-8">
                                            <input type="text" wire:model="province" placeholder="Provinsi" class="form-control">
                                            @error('province') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Negara</label>
                                        <div class="col-md-8">
                                            <input type="text" wire:model="country" placeholder="Negara" class="form-control">
                                            @error('country') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label  class="col-md-4 control-label">Kode Pos</label>
                                        <div class="col-md-8">
                                            <input type="text" wire:model="zipcode" placeholder="Kode Pos" class="form-control">
                                            @error('zipcode') <p class="text-danger">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-md-4 control-label"></label>
                                        <div class="col-md-8">
                                            <button type="submit" class="btn btn-primary"><i class="bi bi-pencil"></i> Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
