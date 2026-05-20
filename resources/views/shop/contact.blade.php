@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Contact Us</li>
    </ol>
</nav>

<h4 class="fw-bold mb-4">Contact Us</h4>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Send us a Message</h5>
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" id="subject" name="subject"
                                   class="form-control @error('subject') is-invalid @enderror"
                                   value="{{ old('subject') }}" required>
                            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea id="message" name="message" rows="5"
                                      class="form-control @error('message') is-invalid @enderror"
                                      required>{{ old('message') }}</textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-send"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Get in Touch</h5>
                <div class="mb-3">
                    <small class="text-muted d-block">Email</small>
                    <span class="fw-semibold">{{ website_setting('contact_email', 'support@immi.com') }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Phone</small>
                    <span class="fw-semibold">{{ website_setting('contact_phone', '+880-XXX-XXXXXX') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
