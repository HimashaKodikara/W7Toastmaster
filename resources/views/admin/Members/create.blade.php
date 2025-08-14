@extends('layouts.app')

@section('content')
        <!-- Page Content -->
        <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <!-- Header with View All button on the right -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Create New Member</h2>
                    <a href="{{ route('member.member') }}">
                        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md transform hover:-translate-y-0.5">
                            <i class="fas fa-list mr-2"></i>
                            View All
                        </button>
                    </a>
                </div>

                <form action="{{ route('member.store-member') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter full name"
                            value="{{ old('name') }}"
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
                            name="testimonial"
                            id="testimonial"
                            rows="6"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter testimonial content"
                            required
                        >{{ old('testimonial') }}</textarea>
                        @error('testimonial')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Social Media Links Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media Links (Optional)</h3>

                        <!-- LinkedIn Link Field -->
                        <div class="mb-4">
                            <label for="linkedin_link" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-linkedin text-blue-600 mr-2"></i>LinkedIn Profile
                            </label>
                            <input
                                type="url"
                                name="linkedin_link"
                                id="linkedin_link"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="https://linkedin.com/in/username"
                                value="{{ old('linkedin_link') }}"
                            >
                            @error('linkedin_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Instagram Link Field (FIXED TYPO) -->
                        <div>
                            <label for="instagram_link" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram Profile
                            </label>
                            <input
                                type="url"
                                name="instergram_link"
                                id="instergram_link"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="https://instagram.com/username"
                                value="{{ old('instergram_link') }}"
                            >
                            @error('instagram_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('member.member') }}">
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
                            Create Member
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
