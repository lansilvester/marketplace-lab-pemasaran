<div>
    <div class="container" style="padding: 30px 0; min-height: 80vh">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Edit Category</h3>
                            <a href="{{ route('admin.categories') }}" class="btn btn-primary"><i class="fa fa-eye"></i> All Category</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif
                    <form action="" class="form-horizontal" wire:submit.prevent="updateCategory">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="" class="control-label">Category Name</label>
                                <input type="text" placeholder="Category name" wire:model="name" wire:keyup="generateslug" class="form-control input-md">
                                @error('name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Category Slug</label>
                                <input type="text"  placeholder="Category slug" wire:model="slug" class="disabled form-control input-md" disabled>
                                @error('slug')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Update</button>
                            </div>
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
