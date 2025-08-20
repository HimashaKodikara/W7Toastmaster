@extends('layouts.app')

@section('content')
        <!-- Page Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <!-- Header with View All button on the right -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Add New Achivment</h2>
                    <a href="{{ route('achivements.achivements') }}">
                        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5">
                            <i class="fas fa-list mr-2"></i>
                            View All
                        </button>
                    </a>
                </div>

                <form action="{{ route('achivements.store-achivements') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Topic Field -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Achivement Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter Event Topic"
                            value="{{ old('title') }}"
                            required
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                            Achivement Description <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="body"
                            id="body"
                            rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter event description..."
                            required
                        >{{ old('body') }}</textarea>
                        @error('body')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Main Image Field -->
                    <div>
                        <label for="front_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Main Achivement Image <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="file"
                            name="front_image"
                            id="front_image"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            accept="image/*"
                            required
                        >
                        <p class="mt-1 text-sm text-gray-500">Upload the main Achivement image</p>
                        @error('front_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Enhanced Gallery Images Field -->
                    <div>
                        <label for="gallery_images" class="block text-sm font-medium text-gray-700 mb-2">
                         Images
                        </label>
                        <div class="space-y-4">
                            <!-- File input -->
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
                                <p><strong>Tips:</strong> Hold Ctrl to select multiple images, or drag and drop images here</p>

                            </div>

                            <!-- Image preview container -->
                            <div id="gallery-preview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-4 hidden">
                                <div class="text-sm font-medium text-gray-700 col-span-full mb-2">Selected Images:</div>
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
                        <a href="{{ route('gallery.gallery') }}">
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
                            <i class="fas fa-plus mr-2"></i>
                            Add New Event
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <!-- JavaScript for image preview -->
        <script>
        function previewGalleryImages(input) {
            const previewContainer = document.getElementById('gallery-preview');

            const existingPreviews = previewContainer.querySelectorAll('.image-preview-item');
            existingPreviews.forEach(item => item.remove());

            if (input.files && input.files.length > 0) {
                previewContainer.classList.remove('hidden');

                Array.from(input.files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'image-preview-item relative group';

                            previewDiv.innerHTML = `
                                <div class="aspect-square border-2 border-gray-200 rounded-lg overflow-hidden bg-gray-50 hover:border-blue-300 transition-colors">
                                    <img src="${e.target.result}"
                                         alt="Gallery preview ${index + 1}"
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                                        <span class="text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                            Image ${index + 1}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1 truncate">${file.name}</p>
                                <p class="text-xs text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                            `;

                            previewContainer.appendChild(previewDiv);
                        };

                        reader.readAsDataURL(file);
                    }
                });

                const countDiv = document.createElement('div');
                countDiv.className = 'image-preview-item col-span-full text-sm text-blue-600 font-medium mt-2 flex items-center';
                countDiv.innerHTML = `
                    <i class="fas fa-images mr-2"></i>
                    ${input.files.length} image(s) selected for upload
                `;
                previewContainer.appendChild(countDiv);
            } else {
                previewContainer.classList.add('hidden');
            }
        }

       document.addEventListener('DOMContentLoaded', function() {
            const galleryInput = document.getElementById('gallery_images');
            const inputContainer = galleryInput.parentElement;

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                inputContainer.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

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


                galleryInput.files = files;


                previewGalleryImages(galleryInput);
            }
        });
        </script>
    </div>
@endsection
