@extends('layouts.app')

@section('content')
        <!-- Page Content -->
        <main>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Achievement Details</h2>

                    <form action="{{ route('achivements.update-achivements', encrypt($achivement->id)) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Achievement Title <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title', $achivement->title ?? '') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter Achievement title"
                                required
                            >
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                                Achievement Description <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="body"
                                id="body"
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter achievement description..."
                                required
                            >{{ old('body', $achivement->body ?? '') }}</textarea>
                            @error('body')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Main Image Field -->
                        <div>
                            <label for="front_image" class="block text-sm font-medium text-gray-700 mb-2">
                                Main Achievement Image
                            </label>
                            <input
                                type="file"
                                name="front_image"
                                id="front_image"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept="image/*"
                                onchange="previewMainImage(this)"
                            >
                            <p class="mt-1 text-sm text-gray-500">Upload a new main achievement image (optional - leave empty to keep current image)</p>

                            @if(isset($achivement->front_image) && $achivement->front_image)
                                <div class="mt-3" id="current-main-image">
                                    <p class="text-sm text-gray-600 mb-2">Current Main Image:</p>
                                    <div class="relative inline-block">
                                        <img src="{{ asset('storage/achivementimage/' . $achivement->front_image) }}" alt="Current main image" class="w-48 h-32 object-cover rounded-lg shadow-sm">
                                    </div>
                                </div>
                            @endif

                            <div id="main-image-preview" class="mt-3 hidden">
                                <p class="text-sm text-gray-600 mb-2">New Main Image Preview:</p>
                                <img id="main-image-preview-img" class="w-48 h-32 object-cover rounded-lg shadow-sm" alt="Main image preview">
                            </div>

                            @error('front_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gallery Images Field -->
                        <div>
                            <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">
                                Gallery Images
                            </label>
                            <div class="space-y-4">
                                <input
                                    type="file"
                                    name="gallery_images[]"
                                    id="gallery_images"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    accept="image/*"
                                    multiple
                                    onchange="previewGalleryImages(this)"
                                >
                                <div class="text-sm text-gray-500 space-y-1">
                                    <p><strong>Tips:</strong> Hold Ctrl/Cmd to select multiple images, or drag and drop images here</p>
                                </div>

                                @if(isset($achivement->gallery_images) && is_array($achivement->gallery_images) && count($achivement->gallery_images) > 0)
                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-700 mb-3">Current Gallery Images:</p>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                            @foreach($achivement->gallery_images as $index => $galleryImage)
                                                <div class="relative group">
                                                    <div class="aspect-square border-2 border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                                                        <img src="{{ asset('storage/achivementimage/' . $galleryImage) }}"
                                                             alt="Gallery image {{ $index + 1 }}"
                                                             class="w-full h-full object-cover">
                                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                                            <span class="text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                                                Current
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            {{ count($achivement->gallery_images) }} existing gallery image(s). New images will be added to this collection.
                                        </p>
                                    </div>
                                @endif

                                <!-- New image preview container -->
                                <div id="gallery-preview" class="mt-4 hidden">
                                    <p class="text-sm font-medium text-gray-700 mb-3">New Gallery Images Preview:</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="gallery-preview-grid">
                                    </div>
                                </div>
                            </div>

                            @error('gallery_images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('gallery_images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('achivements.achivements') }}">
                                <button
                                    type="button"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Cancel
                                </button>
                            </a>
                            <button
                                type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <i class="fas fa-save mr-2"></i>
                                Update Achievement
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Preview main image
                function previewMainImage(input) {
                    const previewContainer = document.getElementById('main-image-preview');
                    const previewImg = document.getElementById('main-image-preview-img');
                    const currentImageContainer = document.getElementById('current-main-image');

                    if (input.files && input.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            previewContainer.classList.remove('hidden');

                            // Dim the current image to show it will be replaced
                            if (currentImageContainer) {
                                currentImageContainer.style.opacity = '0.5';
                            }
                        };

                        reader.readAsDataURL(input.files[0]);
                    } else {
                        previewContainer.classList.add('hidden');

                        // Restore current image opacity
                        if (currentImageContainer) {
                            currentImageContainer.style.opacity = '1';
                        }
                    }
                }

                // Preview gallery images
                function previewGalleryImages(input) {
                    const previewContainer = document.getElementById('gallery-preview');
                    const previewGrid = document.getElementById('gallery-preview-grid');

                    // Clear previous previews
                    previewGrid.innerHTML = '';

                    if (input.files && input.files.length > 0) {
                        previewContainer.classList.remove('hidden');

                        Array.from(input.files).forEach((file, index) => {
                            if (file.type.startsWith('image/')) {
                                const reader = new FileReader();

                                reader.onload = function(e) {
                                    const previewDiv = document.createElement('div');
                                    previewDiv.className = 'relative group';

                                    previewDiv.innerHTML = `
                                        <div class="aspect-square border-2 border-blue-200 rounded-lg overflow-hidden bg-gray-50 hover:border-blue-300 transition-colors">
                                            <img src="${e.target.result}"
                                                 alt="New gallery preview ${index + 1}"
                                                 class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                            </div>
                                        </div>
                                        <div class="absolute top-1 right-1 bg-blue-500 text-white px-1 py-0.5 rounded text-xs">
                                            +${index + 1}
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1 truncate">${file.name}</p>
                                        <p class="text-xs text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                    `;

                                    previewGrid.appendChild(previewDiv);
                                };

                                reader.readAsDataURL(file);
                            }
                        });

                        // Add count info
                        setTimeout(() => {
                            const countDiv = document.createElement('div');
                            countDiv.className = 'col-span-full text-sm text-blue-600 font-medium mt-2 flex items-center';
                            countDiv.innerHTML = `
                                <i class="fas fa-plus-circle mr-2"></i>
                                ${input.files.length} new image(s) will be added to the gallery
                            `;
                            previewGrid.appendChild(countDiv);
                        }, 100);
                    } else {
                        previewContainer.classList.add('hidden');
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    // Add interactive feedback for form inputs
                    const inputs = document.querySelectorAll('input, textarea');
                    inputs.forEach(input => {
                        input.addEventListener('focus', function() {
                            this.parentElement.classList.add('ring-2', 'ring-blue-200');
                        });

                        input.addEventListener('blur', function() {
                            this.parentElement.classList.remove('ring-2', 'ring-blue-200');
                        });
                    });

                    // Add drag and drop functionality for gallery images
                    const galleryInput = document.getElementById('gallery_images');
                    const inputContainer = galleryInput.parentElement;

                    // Prevent default drag behaviors
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        inputContainer.addEventListener(eventName, preventDefaults, false);
                        document.body.addEventListener(eventName, preventDefaults, false);
                    });

                    // Highlight drop area when item is dragged over it
                    ['dragenter', 'dragover'].forEach(eventName => {
                        inputContainer.addEventListener(eventName, highlight, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        inputContainer.addEventListener(eventName, unhighlight, false);
                    });

                    // Handle dropped files
                    inputContainer.addEventListener('drop', handleDrop, false);

                    function preventDefaults(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }

                    function highlight(e) {
                        inputContainer.classList.add('border-blue-400', 'bg-blue-50');
                    }

                    function unhighlight(e) {
                        inputContainer.classList.remove('border-blue-400', 'bg-blue-50');
                    }

                    function handleDrop(e) {
                        const dt = e.dataTransfer;
                        const files = dt.files;

                        // Update the file input
                        galleryInput.files = files;

                        // Trigger preview
                        previewGalleryImages(galleryInput);
                    }
                });
            </script>
        </main>
@endsection
