<div>

    <div style="min-height: 80vh; padding:30px 0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>All Slides</h3>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('admin.addhomeslider') }}" class="btn btn-success pull-right">Add New</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(Session::has('message'))
                                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                            @endif
                            <table class="table table-responsive table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Price</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sliders as $slider)   
                                    <tr>
                                        <td>{{ $slider->id }}</td>
                                        <td><img src="{{ asset('assets/images/sliders') }}/{{ $slider->image }}" width="300px" alt=""></td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ $slider->subtitle }}</td>
                                        <td>{{ $slider->price }}</td>
                                        <td>{{ $slider->link }}</td>
                                        <td>
                                            @if($slider->status == 1)
                                            <span class="badge" style="background:green; padding:.8em; cursor: pointer">
                                            Active
                                            </span>
                                            @else
                                            <span class="badge" style="background:orange; padding:.8em; cursor: pointer">
                                            Inactive
                                            </span>                                        
                                            @endif
                                        </td>
                                        <td>{{ $slider->created_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.edithomeslider', ['slide_id'=>$slider->id]) }}" class="btn btn-info"><i class="fa fa-edit"></i></a>

                                            <a href="#" wire:click.prevent="deleteSlide({{ $slider->id }})" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
