@extends('layouts.app')

@section('content')

        <!-- Page Content -->
        <main>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Testimonial Details</h2>


                   <form action="{{ route('testimonial.update-testimonial', encrypt($testimonial->id)) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('topic', $testimonial->name ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter full name"

                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Field -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Profile Image
                        </label>
                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            accept="image/*"
                        >
                        <p class="mt-1 text-sm text-gray-500">Upload a profile picture (optional)</p>
                        <!-- Show current image if exists -->
                            @if(isset($testimonial->image) && $testimonial->image)
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                    <img src="{{ asset('storage/testimonialimage/' . $testimonial->image) }}" alt="Current image" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Testimonial Field -->
                    <div>
                        <label for="testimonial" class="block text-sm font-medium text-gray-700 mb-2">
                            Testimonial <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="body"
                            id="body"
                            rows="6"
                             class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter testimonial content"
                            required
                        >{{ old('body', $testimonial->body ?? '') }}</textarea>
                        @error('testimonial')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('testimonial.testimonial') }}">
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
                            Update Testimonial
                        </button>
                    </div>
                </form>
                </div>
            </div>

            <script>

                document.addEventListener('DOMContentLoaded', function() {
                    const now = new Date();
                    const currentDateTime = now.toISOString().slice(0, 16);
                    document.getElementById('createdDate').value = currentDateTime;
                });

                // Form submission handler
                document.getElementById('articleForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const data = Object.fromEntries(formData.entries());

                    // Display form data (in a real app, you'd send this to a server)
                    console.log('Form submitted with data:', data);
                    alert('Article created successfully! Check the console for form data.');
                });

                // Add some interactive feedback
                const inputs = document.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('ring-2', 'ring-blue-200');
                    });

                    input.addEventListener('blur', function() {
                        this.parentElement.classList.remove('ring-2', 'ring-blue-200');
                    });
                });
            </script>
        </main>

@endsection
