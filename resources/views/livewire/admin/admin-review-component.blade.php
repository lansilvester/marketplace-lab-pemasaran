<div>
    <main class="container" style="20px 0">
        <div class="row" style="margin-top:3em">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Reviews</h3></div>
                    <div class="panel-body">
                        <table class="table table-border table-hover">
                            <tr>
                                <thead>
                                    <th>No</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Nama Product</th>
                                    <th>Reviewer</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    
                                    {{-- $popular_products = Review::select('product_id')->distinct('rating','product_id')->where('rating','>',3)->limit(3)->get(); --}}

                                    @forelse($all_reviews as $review)
                                    <tr>
                                        
                                        <td>{{ $review->reviews_id }}</td>
                                        <td>{{ $review->reviews_rating }}</td>
                                        <td>{{ $review->reviews_comment }}</td>
                                        <td>{{ $review->products_name }}</td>
                                        <td>{{ $review->user_name }}</td>
                                        <td>{{ $review->reviews_created_at }}</td>
                                        {{-- <td>{{ $review->product->name }}</td>
                                        <td>{{ $review->product->user->name }}</td>
                                        <td>{{ $review->user->name }}</td> --}}
                                        {{-- <td>{{ $review->created_at }}<br><span class="badge">{{ $review->created_at->diffForHumans() }}</span></td> --}}
                                        <td>
                                            <a href="#" onclick="confirm('Are you sure want to delete this review?') || event.stopImmediatePropagation()" class="btn btn-danger" wire:click.prevent="deleteReview({{ $review->reviews_id }})"><i class="fa fa-trash"></i></a>
                                          
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-warning">Belum ada review</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </tr>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </main>
</div>
