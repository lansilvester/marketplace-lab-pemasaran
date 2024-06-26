<div>
<div class="container" style="padding:50px 0; min-height:70vh;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Manage Home Categories</h3>
                </div>
                <div class="panel-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif
                    <form class="form-horizontal" wire:submit.prevent="updateHomeCategory">
                        <div class="form-group"><label for="" class="col-md-4 control-label">Pilih Kategori</label>
                            <div class="col-md-4" wire:ignore>
                                <select wire:ignore name="categories[]" multiple="multiple" class="sel_categories form-control" wire:model="selected_categories">
                                    @foreach ($categories as $category)
                                        <option
                                        @if ($selected_categories != null)
                                            @if (in_array($category->id, $selected_categories))
                                                selected
                                            @endif
                                        @endif
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label for="" class="col-md-4 control-label">Jumlah product yang ditampilkan</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control input-md" wire:model="numberofproducts"/>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="form-group"><label for="" class="col-md-4 control-label"></label>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@push('scripts')
<script>
    
    $(document).ready(function (){
        $('.sel_categories').select2();
        $('.sel_categories').on('change',function(e){
            var data = $('.sel_categories').select2("val");
            @this.set('selected_categories',data);
        });
    });
</script>
@endpush