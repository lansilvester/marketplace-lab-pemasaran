<div style="min-height: 80vh;">
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
    </style>
    <div class="container" style="padding:30px 0">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>All cateogries</h3>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                        @endif
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Total Products</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->product->count() }}</td>
                                        <td>
                                            <a href="{{ route('admin.editcategory', ['category_slug'=>$category->slug]) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                            <a href="#" onclick="confirm('Are you sure want to delete this category?') || event.stopImmediatePropagation()" wire:click.prevent="deleteCategory({{ $category->id }})" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4">
                                        <a href="{{ route('admin.addcategory') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Category</a>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
