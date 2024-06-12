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
    </style>
    <div class="container" style="padding: 30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6 p-3">
                                @if (Auth::user()->utype == 'PNJ' || Auth::user()->utype == 'PBN'  )
                                {{ Auth::user()->utype }}
                                <h3>Semua product  <span class="badge" style="font-size:1.2em; margin-left:10px">{{ Auth::user()->name }}</span></h3>
                                @else
                                <h3>Semua Product <span class="badge" style="font-size:1.2em; margin-left:10px">{{ Auth::user()->name }}</span></h3>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.addproduct') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Product</a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        {{-- For admin --}}
                    @if(Auth::user()->utype === 'ADM' || Auth::user()->utype === 'OPT')
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <table class="table table-striped table-border table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Foto</th>
                                    <th>Name</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Kategori</th>
                                    <th>Oleh</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($products as $product)
                                    @if($product->image !== 'default-product.jpg' && $product->count() !== 0)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td><img src="{{ asset('assets/images/products') }}/{{ $product->image }}" alt="" width=100></td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->stock_status }}</td>
                                        <td>@currency($product->sale_price)</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->user->name }}</td>
                                        <td>{{ $product->created_at->format('l, d-M-Y')  }} <br> <span class="badge ">{{ $product->created_at->diffForHumans() }}</span></td>
                                        <td>
                                            {{-- <a href="" class="btn btn-info"><i class="fa fa-eye"></i></a> --}}
                                            <a href="{{ route('admin.editproduct', ['product_slug'=>$product->slug]) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                            <a href="#" onclick="confirm('Are you sure want to delete this product?') || event.stopImmediatePropagation()" class="btn btn-danger" wire:click.prevent="deleteProduct({{ $product->id }})"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($product->image == 'default-product.jpg' && $product->count() == 1)
                                        <tr>
                                            <td colspan="9" class="text-center">Data Kosong</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    @endif

                    {{-- For PNJ & PBN--}}

                    @if(Auth::user()->utype === 'PNJ' || Auth::user()->utype === 'PBN')
                        @if(Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <table class="table table-striped table-border table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Foto</th>
                                    <th>Name</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Kategori</th>
                                    <th>Oleh</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($my_products as $my_product)
                                @if($my_product->image !== 'default-product.jpg' || $my_product->count() > 1)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><img src="{{ asset('assets/images/products') }}/{{ $my_product->image }}" alt="" width=100></td>
                                    <td>{{ $my_product->name }}</td>
                                    <td>{{ $my_product->stock_status }}</td>
                                    <td>@currency($my_product->sale_price)</td>
                                    <td>{{ $my_product->category->name }}</td>
                                    <td>{{ $my_product->user->name }}</td>
                                    <td>{{ $my_product->created_at->format('l, d-M-Y') }} <br> <span class="badge">{{ $my_product->created_at->diffForHumans() }}</span> </td>
                                    <td>
                                        <a href="{{ route('admin.editproduct', ['product_slug'=>$my_product->slug]) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <a href="#" onclick="confirm('Are you sure want to delete this product?') || event.stopImmediatePropagation()" class="btn btn-danger" wire:click.prevent="deleteProduct({{ $my_product->id }})"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endif
                                @if($my_product->image == 'default-product.jpg' && $my_product->count() == 0)
                                            <tr>
                                                <td colspan="9" class="text-center">Data Kosong</td>
                                            </tr>
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="8" class="text-right">Total Product</th>
                                    <td class="text-left"><b>{{ $my_products->count() }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    {{ $my_products->links() }}
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
