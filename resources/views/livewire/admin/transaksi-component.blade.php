<main id="main" class="main-site">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="/" class="link">Home</a></li>
                <li class="item-link"><span>Daftar Transaksi</span></li>
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

                @if($transactions->isEmpty())
                    <div class="alert alert-warning text-center">Belum ada transaksi.</div>
                @else
                    <h3 class="box-title">
                        <i class="bi bi-shop"></i>
                         &nbsp; Daftar Transaksi <i>{{ Auth::user()->name }}</i>
                    </h3>

                    @php
                        $statuses = ['pending', 'accepted', 'rejected'];
                    @endphp

                    @foreach($statuses as $status)
                    <div style="padding:1em; margin-bottom:1em;border-radius:1em; box-shadow:3px 2px 4px 2px rgba(0, 0, 0, 0.074)">
                        <h4>{{ ucfirst($status) }} Transactions</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Pembeli</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th>Foto Item</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions->where('status', $status) as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->user->name }}</td>
                                        <td>Rp. {{ number_format($transaction->total, 2) }}</td>
                                        <td>{{ $transaction->created_at }}<br><span class="badge">{{ $transaction->created_at->diffForHumans() }}</span></td>
                                        <td>
                                            @foreach ($transaction->items as $item)
                                                <img src="{{ asset('assets/images/products/' . $item->product->image) }}" alt="Foto Item" width="50">
                                            @endforeach
                                        </td>
                                        <td>
                                            @if ($transaction->payment_proof)
                                                @php
                                                    $paymentProofs = json_decode($transaction->payment_proof);
                                                @endphp
                                                @if (is_array($paymentProofs))
                                                    @foreach ($paymentProofs as $proof)
                                                        <img src="{{ asset('assets/images/orders/' . $proof) }}" alt="Bukti Pembayaran" width="50" class="payment-proof">
                                                    @endforeach
                                                @else
                                                    <span>Tidak ada bukti yang valid</span>
                                                @endif
                                            @else
                                                <span>Tidak ada bukti</span>
                                            @endif
                                        </td>
                                        <td>
                                            <select wire:change="updateStatus({{ $transaction->id }}, $event.target.value)" class="form-control">
                                                <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="accepted" {{ $transaction->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                <option value="rejected" {{ $transaction->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>

    <!-- Modal Bootstrap untuk menampilkan gambar lebih besar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid" alt="Bukti Pembayaran">
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Tambahkan JavaScript untuk menangani klik pada gambar dan menampilkan modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentProofs = document.querySelectorAll('.payment-proof');
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        const modalImage = document.getElementById('modalImage');

        paymentProofs.forEach(image => {
            image.addEventListener('click', function () {
                modalImage.src = this.src;
                modal.show();
            });
        });
    });
</script>
