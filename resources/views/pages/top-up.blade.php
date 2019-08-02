@extends('layouts.app')

@section('title', 'Top Up Wallet')

@section('content')

<ul class="nav nav-tabs nav-fill mb-3" id="tab">
    <li class="nav-item">
        <a class="nav-link {{ $mode == 'top-up' ? 'active' : '' }}" id="top-up-tab">Top Up</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $mode == 'transfer' ? 'active' : '' }}" id="transfer-tab">Transfer</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $mode == 'success' ? 'active' : '' }}" id="success-tab">Success</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade {{ $mode == 'top-up' ? 'show active' : '' }}" id="top-up" role="tabpanel"
        aria-labelledby="top-up-tab">
        <form action="{{ route('top-up.top-upping') }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="bank_name">Bank</label>
                <select id="bank_name" class="form-control" name="bank_name">
                    <option value="bca">BCA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="bank_account_number">Bank Account Number</label>
                <input id="bank_account_number" class="form-control" type="text" name="bank_account_number"
                    placeholder="Bank Account Number">
            </div>
            <div class="form-group">
                <label for="bank_account_name">Bank Account Name</label>
                <input id="bank_account_name" class="form-control" type="text" name="bank_account_name"
                    placeholder="Bank Account Name">
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <select id="amount" class="form-control" name="amount">
                    <option value="10000">Rp 10.000</option>
                    <option value="20000">Rp 20.000</option>
                    <option value="30000">Rp 30.000</option>
                    <option value="40000">Rp 40.000</option>
                    <option value="50000">Rp 50.000</option>
                    <option value="60000">Rp 60.000</option>
                    <option value="70000">Rp 70.000</option>
                    <option value="80000">Rp 80.000</option>
                    <option value="90000">Rp 90.000</option>
                    <option value="100000">Rp 100.000</option>
                </select>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Top Up</button>
        </form>
    </div>
    <div class="tab-pane fade {{ $mode == 'transfer' ? 'show active' : '' }}" id="transfer" role="tabpanel"
        aria-labelledby="transfer-tab">
        <div class="border border-primary rounded p-4 text-center">
            <h2>Rekening Tujuan</h2>
            <div class="row">
                <div class="col">
                    <h3>Bank</h3>
                    <h5>Bank Central Asia (BCA)</h5>
                </div>
                <div class="col">
                    <h3>Atas Nama</h3>
                    <h5>PT. PARKER</h5>
                </div>
                <div class="col">
                    <h3>Nomor Rekening</h3>
                    <h5>00229683606</h5>
                </div>
                @isset($topUp)
                <div class="col">
                    <h3>Nominal</h3>
                    <h5>
                        Rp {{ number_format($topUp->amount) }}
                    </h5>
                </div>
                @endisset
            </div>
        </div>
        <form action="{{ route('top-up.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row mt-4 mb-4">
                <div class="col-12 col-md-6">
                    <div id="receipt_transfer_preview" style="height:300px;" class="border border-primary rounded">
                    </div>
                </div>
                <div class="col-12-col-md-6">
                    <p>
                        Upload Receipt of Transfer
                    </p>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="receipt_transfer"
                                    name="receipt_transfer" accept="image/*" required>
                                <label id="receipt_transfer_label" class="custom-file-label"
                                    for="receipt_transfer">Choose Receipt Transfer</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block rounded">Upload</button>
        </form>
    </div>
    <div class="tab-pane fade {{ $mode == 'success' ? 'show active' : '' }}" id="success" role="tabpanel"
        aria-labelledby="success-tab">
        <div
            class="text-center h-100 d-flex flex-column justify-content-center align-items-center p-4 border border-primary rounded">
            <h2>Top Up is in Process</h2>
            <h3>Thank You</h3>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="/js/jquery.uploadPreview.min.js"></script>
<script>
    $(document).ready(function() {
        $.uploadPreview({
            input_field: "#receipt_transfer", // Default: .image-upload
            preview_box: "#receipt_transfer_preview", // Default: .image-preview
            label_field: "#receipt_transfer_label", // Default: .image-label
            label_default: "Choose Photo", // Default: Choose File
            label_selected: "Change Photo", // Default: Change File
            no_label: false // Default: false
        });
    });
</script>
@endpush