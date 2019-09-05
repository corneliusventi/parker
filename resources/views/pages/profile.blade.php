@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="row">
        <div class="col-12 col-xl-4">
            <form action="{{ route('profile.update.photo') }}" method="POST" enctype="multipart/form-data" id="avatar-form">
                @csrf
                @method('PUT')
                <div class="d-flex justify-content-center pb-4 pt-4 mb-4 rounded bg-primary">
                    <div id="photo-preview" class="rounded-circle" style="width: 150px; height: 150px; background-image: url('{{ auth()->user()->avatar }}'); background-size: cover; background-position:center center;"></div>
                    {{-- <img id="photo-preview" class="img-fluid rounded-circle" src="{{ auth()->user()->avatar }}"> --}}
                </div>
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*" required>
                            <label id="photo-label" class="custom-file-label" for="photo">Choose Photo</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block rounded mb-4">Update</button>
            </form>
        </div>
        <div class="col-12 col-xl-8">
            <form action="{{ route('profile.update') }}" method="POST" id="profile-form">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" value="{{ $user->fullname }}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ $user->username }}">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" placeholder="New Password Confirmation">
                </div>
                <button type="submit" class="btn btn-primary btn-block rounded">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="/js/jquery.uploadPreview.min.js"></script>
    <script>
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#photo",   // Default: .image-upload
                preview_box: "#photo-preview",  // Default: .image-preview
                label_field: "#photo-label",    // Default: .image-label
                label_default: "Choose Photo",   // Default: Choose File
                label_selected: "Change Photo",  // Default: Change File
                no_label: false                 // Default: false
            });
        });
    </script>
@endpush

@if(!collect(auth()->user()->intros)->contains('profile-intro'))
    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/driver.js/dist/driver.min.css">
    @endpush

    @push('js')
        <script src="https://unpkg.com/driver.js/dist/driver.min.js"></script>
            <script>
                const profileDriver = new Driver({
                    onReset: (Element) => {
                        $.ajax({
                            data: {'intro': 'profile-intro'},
                            method: 'POST',
                            url: '{{ route('intros.store') }}',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                    }, 
                });

                // Define the steps for introduction
                profileDriver.defineSteps([
                    {
                        element: '#avatar-form',
                        popover: {
                            title: 'Avatar',
                            description: 'Change avatar',
                            position: 'auto'
                        }
                    },
                    {
                        element: '#profile-form',
                        popover: {
                            title: 'Profile',
                            description: 'Change profile & password',
                            position: 'auto'
                        }
                    },
                ]);

                setTimeout(() => {
                    profileDriver.start();
                }, 1000);

            </script>
    @endpush
@endif