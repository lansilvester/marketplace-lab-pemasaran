<main id="main" class="main-site">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">home</a></li>
                <li class="item-link"><span>Daftar Pesanan</span></li>
            </ul>
        </div>
        <div class="main-content-area">
            <div class="wrap-iten-in-cart">
                @if(Session::has('message'))
                <div class="alert alert-success">
                    <strong>Success</strong> {{ Session::get('message') }}
                </div>
                @endif
                @if(Session::has('error_message'))
                <div class="alert alert-danger">
                    <strong>Error</strong> {{ Session::get('error_message') }}
                </div>
                @endif

                @if($orders->isEmpty())
                    <div class="alert alert-warning text-center">Belum ada pesanan.</div>
                @else
                    <h3 class="box-title">Daftar Pesanan</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Foto Item</th>
                                <th>Bukti Pembayaran</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        @if($order->items->isNotEmpty())
                                        <img src="{{ asset('assets/images/products/' . $order->items[0]->product->image) }}" alt="Foto Item" width="200">
                                        @else
                                        <span>Tidak ada item</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_proof)
                                            @foreach($order->payment_proof as $proof)
                                                <img src="{{ asset('assets/images/orders/' . $proof) }}" alt="Bukti Pembayaran" width="100" style="margin-right: 5px;">
                                            @endforeach
                                        @else
                                            <span>Tidak ada bukti</span>
                                        @endif
                                    </td>

                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td>Rp. {{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @if(ucfirst($order->status) == 'Pending')
                                            <b style="background:#f2ff00; padding: .3em .6em; border-radius:.4em;"><i class="bi bi-clock-history"></i> Pending</b>
                                        @elseif(ucfirst($order->status) == 'Accepted')
                                            <b style="color:white; background:#00a54d; padding: .3em .6em; border-radius:.4em;"><i class="bi bi-check"></i> Accepted</b>
                                        @elseif(ucfirst($order->status) == 'Rejected')
                                            <b style="color:white; background:#ff0000; padding: .3em .6em; border-radius:.4em;"><i class="bi bi-check"></i> Rejected</b>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div><!--end main content area-->
    </div><!--end container-->
</main>
