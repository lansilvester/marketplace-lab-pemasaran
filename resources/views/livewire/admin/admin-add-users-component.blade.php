<div style="min-height:80vh; padding:20px 0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Add User</h3>
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
                        <form wire:submit.prevent="addUser" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name</label>
                                <div class="col-md-8">
                                    <input type="text" wire:model="name" placeholder="Nama Lengkap" class="form-control">
                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-8">
                                    <input type="email" wire:model="email" placeholder="Email" class="form-control">
                                    @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-8">
                                    <input type="password" wire:model="password" placeholder="Password" class="form-control">
                                    @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Type</label>
                                <div class="col-md-8">
                                    <select wire:model="utype" class="form-control">
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
                                <label class="col-md-4 control-label">Status</label>
                                <div class="col-md-8">
                                    <select wire:model="status" class="form-control">
                                        <option value="1">Aktif</option>
                                        <option value="0">Non-aktif</option>
                                    </select>
                                    @error('status') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label"></label>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah User</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
