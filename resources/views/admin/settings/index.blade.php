@extends('layouts.app')

@section('title')
    @php
        $appName = config('app.name', 'HK Checklist');
        if (Storage::disk('local')->exists('settings.json')) {
            $settings = json_decode(Storage::disk('local')->get('settings.json'), true);
            $appName = $settings['app_name'] ?? $appName;
        }
    @endphp
    Settings - {{ $appName }}
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="background: var(--primary-gradient); border-radius: 20px;">
                <div class="card-body py-4 px-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="text-white mb-2 fw-bold" style="font-size: 2rem;">
                                <i class="bi bi-gear-fill me-2"></i>System Settings
                            </h1>
                            <p class="text-white mb-0" style="font-size: 1.1rem; opacity: 0.95;">
                                <i class="bi bi-sliders me-2"></i>Customize your application branding and appearance
                            </p>
                        </div>
                        <div class="text-white" style="font-size: 4rem; opacity: 0.2;">
                            <i class="bi bi-sliders2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 15px; border-left: 5px solid #38ef7d;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 15px; border-left: 5px solid #dc3545;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Error!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Application Information -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-header border-0 text-white py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0;">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-info-circle-fill me-2"></i>Application Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="app_name" class="form-label">
                                <i class="bi bi-tag-fill text-primary me-2"></i>Application Name
                            </label>
                            <input 
                                type="text" 
                                class="form-control form-control-lg" 
                                id="app_name" 
                                name="app_name" 
                                value="{{ old('app_name', $settings['app_name']) }}"
                                placeholder="e.g., Housekeeping Manager"
                                style="border-radius: 12px; font-size: 1.05rem;">
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-lightbulb me-1"></i>This name will appear in the navigation and browser title
                            </small>
                        </div>

                        <div class="alert alert-info border-0" style="border-radius: 12px; background: rgba(79, 172, 254, 0.1);">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Note:</strong> Some settings may require a page refresh to take effect.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Color Theme - DISABLED -->
            {{-- 
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-header border-0 text-white py-3" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 20px 20px 0 0;">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-palette-fill me-2"></i>Color Theme
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label for="primary_color" class="form-label">
                                <i class="bi bi-circle-fill text-primary me-2"></i>Primary Color
                            </label>
                            <div class="d-flex align-items-center gap-3">
                                <input 
                                    type="color" 
                                    class="form-control form-control-color" 
                                    id="primary_color" 
                                    name="primary_color" 
                                    value="{{ old('primary_color', $settings['primary_color']) }}"
                                    style="width: 80px; height: 60px; border-radius: 12px; cursor: pointer;">
                                <input 
                                    type="text" 
                                    class="form-control primary-color-text" 
                                    id="primary_color_text"
                                    name="primary_color_display"
                                    value="{{ old('primary_color', $settings['primary_color']) }}"
                                    readonly
                                    style="border-radius: 12px; font-family: monospace; font-size: 1.05rem;">
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-lightbulb me-1"></i>Used for buttons, headers, and primary elements
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="secondary_color" class="form-label">
                                <i class="bi bi-circle-fill text-secondary me-2"></i>Secondary Color
                            </label>
                            <div class="d-flex align-items-center gap-3">
                                <input 
                                    type="color" 
                                    class="form-control form-control-color" 
                                    id="secondary_color" 
                                    name="secondary_color" 
                                    value="{{ old('secondary_color', $settings['secondary_color']) }}"
                                    style="width: 80px; height: 60px; border-radius: 12px; cursor: pointer;">
                                <input 
                                    type="text" 
                                    class="form-control secondary-color-text" 
                                    id="secondary_color_text"
                                    name="secondary_color_display"
                                    value="{{ old('secondary_color', $settings['secondary_color']) }}"
                                    readonly
                                    style="border-radius: 12px; font-family: monospace; font-size: 1.05rem;">
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-lightbulb me-1"></i>Used for gradients and accent elements
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            --}}

            <!-- Logo Upload - DISABLED -->
            {{--
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-header border-0 text-white py-3" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 20px 20px 0 0;">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-image-fill me-2"></i>Logo
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="logo" class="form-label">
                                <i class="bi bi-upload me-2 text-success"></i>Upload Logo
                            </label>
                            <input 
                                type="file" 
                                class="form-control form-control-lg" 
                                id="logo" 
                                name="logo"
                                accept="image/png,image/jpeg,image/jpg,image/svg+xml"
                                style="border-radius: 12px;">
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-info-circle me-1"></i>Accepted formats: PNG, JPG, JPEG, SVG (Max: 2MB)
                            </small>
                        </div>

                        @if(!empty($settings['logo']))
                            <div class="mt-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-eye-fill me-2 text-primary"></i>Current Logo:
                                </label>
                                <div class="p-4 bg-light rounded-3 text-center" style="border-radius: 12px;">
                                    <img src="{{ $settings['logo'] }}" alt="Logo" style="max-width: 200px; max-height: 100px; object-fit: contain;">
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning border-0 mt-3" style="border-radius: 12px; background: rgba(246, 211, 101, 0.15);">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                No logo uploaded yet
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            --}}

            <!-- Favicon Upload -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="card-header border-0 text-white py-3" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%); border-radius: 20px 20px 0 0;">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-star-fill me-2"></i>Favicon
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="favicon" class="form-label">
                                <i class="bi bi-upload me-2 text-warning"></i>Upload Favicon
                            </label>
                            <input 
                                type="file" 
                                class="form-control form-control-lg" 
                                id="favicon" 
                                name="favicon"
                                accept="image/x-icon,image/png"
                                style="border-radius: 12px;">
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-info-circle me-1"></i>Accepted formats: ICO, PNG (Max: 512KB, Recommended: 32x32px)
                            </small>
                        </div>

                        @if(!empty($settings['favicon']))
                            <div class="mt-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-eye-fill me-2 text-primary"></i>Current Favicon:
                                </label>
                                <div class="p-4 bg-light rounded-3 text-center" style="border-radius: 12px;">
                                    <img src="{{ $settings['favicon'] }}" alt="Favicon" style="width: 32px; height: 32px;">
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning border-0 mt-3" style="border-radius: 12px; background: rgba(246, 211, 101, 0.15);">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                No favicon uploaded yet
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);">
                    <div class="card-body p-4 text-center">
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <button type="submit" class="btn btn-lg px-5 py-3 shadow-lg" style="background: var(--primary-gradient); border: none; border-radius: 15px; color: white; font-weight: 700; font-size: 1.1rem;">
                                <i class="bi bi-save-fill me-2"></i>Save Settings
                            </button>
                            
                            <button type="button" class="btn btn-lg px-5 py-3 shadow-lg" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); border: none; border-radius: 15px; color: white; font-weight: 700; font-size: 1.1rem;" onclick="confirmReset()">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>Reset to Defaults
                            </button>
                        </div>
                        <p class="text-muted mt-3 mb-0">
                            <i class="bi bi-info-circle me-1"></i>Save will update settings | Reset will restore all defaults and remove uploads
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <!-- Hidden Reset Form -->
    <form id="resetForm" action="{{ route('admin.settings.reset') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

@push('scripts')
<script>
    // Confirm reset action
    function confirmReset() {
        if (confirm('⚠️ Are you sure you want to reset all settings to defaults?\n\nThis will:\n• Reset application name\n• Reset colors to defaults\n• Delete uploaded logo\n• Delete uploaded favicon\n\nThis action cannot be undone!')) {
            document.getElementById('resetForm').submit();
        }
    }
    
    // Sync color picker with text input
    document.getElementById('primary_color').addEventListener('input', function(e) {
        document.getElementById('primary_color_text').value = e.target.value.toUpperCase();
    });
    
    document.getElementById('secondary_color').addEventListener('input', function(e) {
        document.getElementById('secondary_color_text').value = e.target.value.toUpperCase();
    });

    // Preview logo before upload
    document.getElementById('logo').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.createElement('div');
                preview.className = 'mt-3 p-4 bg-light rounded-3 text-center';
                preview.innerHTML = `
                    <label class="form-label fw-bold">
                        <i class="bi bi-eye-fill me-2 text-primary"></i>Preview:
                    </label>
                    <div>
                        <img src="${event.target.result}" alt="Logo Preview" style="max-width: 200px; max-height: 100px; object-fit: contain;">
                    </div>
                `;
                
                const existing = e.target.closest('.card-body').querySelector('.mt-3');
                if (existing) {
                    existing.remove();
                }
                e.target.closest('.card-body').appendChild(preview);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Preview favicon before upload
    document.getElementById('favicon').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.createElement('div');
                preview.className = 'mt-3 p-4 bg-light rounded-3 text-center';
                preview.innerHTML = `
                    <label class="form-label fw-bold">
                        <i class="bi bi-eye-fill me-2 text-primary"></i>Preview:
                    </label>
                    <div>
                        <img src="${event.target.result}" alt="Favicon Preview" style="width: 32px; height: 32px;">
                    </div>
                `;
                
                const existing = e.target.closest('.card-body').querySelector('.mt-3');
                if (existing) {
                    existing.remove();
                }
                e.target.closest('.card-body').appendChild(preview);
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush

@endsection
