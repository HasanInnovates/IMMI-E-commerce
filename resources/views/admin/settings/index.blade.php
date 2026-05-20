@extends('layouts.admin')

@section('title', 'Website Settings')

@push('styles')
<style>
    .color-preview { width: 40px; height: 40px; border-radius: 4px; border: 1px solid #ddd; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Website Settings</h4>
</div>

    <div class="row g-4">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">General</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="website_name" class="form-label">Website Name</label>
                            <input type="text" id="website_name" name="website_name"
                                   class="form-control @error('website_name') is-invalid @enderror"
                                   value="{{ old('website_name', $settings['website_name'] ?? config('app.name')) }}">
                            @error('website_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hero_title" class="form-label">Hero Title</label>
                            <input type="text" id="hero_title" name="hero_title"
                                   class="form-control @error('hero_title') is-invalid @enderror"
                                   value="{{ old('hero_title', $settings['hero_title'] ?? '') }}">
                            @error('hero_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hero_subtitle" class="form-label">Hero Subtitle</label>
                            <textarea id="hero_subtitle" name="hero_subtitle" rows="2"
                                      class="form-control @error('hero_subtitle') is-invalid @enderror">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                            @error('hero_subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="footer_text" class="form-label">Footer Text</label>
                            <input type="text" id="footer_text" name="footer_text"
                                   class="form-control @error('footer_text') is-invalid @enderror"
                                   value="{{ old('footer_text', $settings['footer_text'] ?? '') }}">
                            @error('footer_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="email" id="contact_email" name="contact_email"
                                   class="form-control @error('contact_email') is-invalid @enderror"
                                   value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                            @error('contact_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contact_phone" class="form-label">Contact Phone</label>
                            <input type="text" id="contact_phone" name="contact_phone"
                                   class="form-control @error('contact_phone') is-invalid @enderror"
                                   value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                            @error('contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Social Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="facebook_url" class="form-label">Facebook URL</label>
                            <input type="url" id="facebook_url" name="facebook_url"
                                   class="form-control @error('facebook_url') is-invalid @enderror"
                                   value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}">
                            @error('facebook_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="twitter_url" class="form-label">Twitter URL</label>
                            <input type="url" id="twitter_url" name="twitter_url"
                                   class="form-control @error('twitter_url') is-invalid @enderror"
                                   value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}">
                            @error('twitter_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instagram_url" class="form-label">Instagram URL</label>
                            <input type="url" id="instagram_url" name="instagram_url"
                                   class="form-control @error('instagram_url') is-invalid @enderror"
                                   value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}">
                            @error('instagram_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Colors</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="primary_color" class="form-label">Primary Color</label>
                                <div class="input-group">
                                    <span class="input-group-text color-preview" id="primary_preview" style="background-color: {{ old('primary_color', $settings['primary_color'] ?? '#08a59b') }}"></span>
                                    <input type="text" id="primary_color" name="primary_color"
                                           class="form-control @error('primary_color') is-invalid @enderror"
                                           value="{{ old('primary_color', $settings['primary_color'] ?? '#08a59b') }}"
                                           onchange="document.getElementById('primary_preview').style.backgroundColor = this.value">
                                    @error('primary_color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="secondary_color" class="form-label">Secondary Color</label>
                                <div class="input-group">
                                    <span class="input-group-text color-preview" id="secondary_preview" style="background-color: {{ old('secondary_color', $settings['secondary_color'] ?? '#0d6efd') }}"></span>
                                    <input type="text" id="secondary_color" name="secondary_color"
                                           class="form-control @error('secondary_color') is-invalid @enderror"
                                           value="{{ old('secondary_color', $settings['secondary_color'] ?? '#0d6efd') }}"
                                           onchange="document.getElementById('secondary_preview').style.backgroundColor = this.value">
                                    @error('secondary_color') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            @php
                $imageKeys = [
                    'logo' => ['label' => 'Logo', 'style' => 'max-height:80px', 'class' => 'text-center'],
                    'favicon' => ['label' => 'Favicon', 'style' => 'max-height:32px', 'class' => 'text-center'],
                    'hero_image' => ['label' => 'Hero Image', 'style' => '', 'class' => ''],
                ];
            @endphp

            @foreach($imageKeys as $key => $meta)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">{{ $meta['label'] }}</h5>
                </div>
                <div class="card-body">
                    @if($img = website_setting_image($key))
                        <div class="mb-3 {{ $meta['class'] }}">
                            <img src="{{ $img }}" alt="{{ $meta['label'] }}"
                                 class="img-fluid" style="{{ $meta['style'] }}">
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="{{ $key }}" name="{{ $key }}"
                               class="form-control @error($key) is-invalid @enderror" accept="image/*">
                        @error($key) <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="bi bi-upload"></i> Upload
                            </button>
                            @if($img)
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="if(confirm('Delete {{ $meta['label'] }}?')){ document.getElementById('delete-{{ $key }}').submit(); }">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif
                        </div>
                    </form>

                    @if($img)
                    <form method="POST" action="{{ route('admin.settings.delete-image') }}" id="delete-{{ $key }}" class="d-none">
                        @csrf
                        <input type="hidden" name="key" value="{{ $key }}">
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection
