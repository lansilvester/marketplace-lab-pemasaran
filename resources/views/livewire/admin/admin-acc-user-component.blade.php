<div style="min-height:70vh; margin: 3em 0;">
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>
                    User Detail
                </h2>
                <a href="{{ route('admin.users') }}" class="btn btn-info"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
            <div class="panel-body">
                <form wire:submit.prevent="updateUser" class="form-horizontal">

                <div class="form-group">
                        <div class="row">
                        <div class="col-md-2 text-right">
                            <label for="nama">Nama</label>
                        </div>
                        <div class="col-md-5">
                            <input id="nama" type="text" wire:model="name" class="form-control">
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror

                        </div>
                        </div>
                </div>
                <div class="form-group">
                        <div class="row">
                        <div class="col-md-2 text-right">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-md-5">
                            <input id="email" type="email" wire:model="email" class="form-control">
                            @error('email') <p class="text-danger">{{ $message }}</p> @enderror

                        </div>
                        </div>
                </div>
                <div class="form-group">
                        <div class="row">
                        <div class="col-md-2 text-right">
                            <label for="email">Mendaftar Sebagai</label>
                        </div>
                        <div class="col-md-5">
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
                </div>
                <div class="form-group">
                        <div class="row">
                        <div class="col-md-2 text-right">
                            <label for="status">Status</label>
                        </div>
                        <div class="col-md-5">
                            <select name="" id="status"  wire:model="status" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Non-aktif</option>
                            </select>
                            @error('utype') <p class="text-danger">{{ $message }}</p> @enderror
                            <button type="submit" class="btn btn-primary" style="margin:1em 0;"><i class="bi bi-pencil"></i> Update</button>
                        </div>
                        </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
