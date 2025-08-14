@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 text-center">
                    {{ $contact_us ? 'Update Contact Information' : 'Add Contact Information' }}
                </h2>
            </div>

            <!-- Display Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ $contact_us ? route('contact-us.update', encrypt($contact_us->id)) : route('contact-us.store-contact') }}"
                  method="POST"
                  class="space-y-6">
                @csrf
                @if($contact_us)
                    @method('PUT')
                @endif

                <!-- Address Field -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="address"
                        id="address"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror"
                        placeholder="Enter your complete address"
                        required
                    >{{ old('address', $contact_us->address ?? '') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $contact_us->email ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                        placeholder="Enter your email address"
                        required
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="tel"
                        name="phone"
                        id="phone"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                        placeholder="Enter your phone number"
                        value="{{ old('phone', $contact_us->phone ?? '') }}"
                        required
                    >
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Social Media Links Section -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media Links (Optional)</h3>

                    <!-- LinkedIn Link -->
                    <div class="mb-4">
                        <label for="linkedin_link" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-linkedin text-blue-600 mr-2"></i>LinkedIn Profile
                        </label>
                        <input
                            type="url"
                            name="linkedin_link"
                            id="linkedin_link"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('linkedin_link') border-red-500 @enderror"
                            placeholder="https://linkedin.com/in/your-profile"
                            value="{{ old('linkedin_link', $contact_us->linkedin_link ?? '') }}"
                        >
                        @error('linkedin_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instagram Link -->
                    <div class="mb-4">
                        <label for="instergram_link" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram Profile
                        </label>
                        <input
                            type="url"
                            name="instergram_link"
                            id="instergram_link"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('instergram_link') border-red-500 @enderror"
                            placeholder="https://instagram.com/your-profile"
                            value="{{ old('instergram_link', $contact_us->instergram_link ?? '') }}"
                        >
                        @error('instergram_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Facebook Link -->
                    <div>
                        <label for="facebook_link" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fab fa-facebook text-blue-800 mr-2"></i>Facebook Profile
                        </label>
                        <input
                            type="url"
                            name="facebook_link"
                            id="facebook_link"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('facebook_link') border-red-500 @enderror"
                            placeholder="https://facebook.com/your-profile"
                            value="{{ old('facebook_link', $contact_us->facebook_link ?? '') }}"
                        >
                        @error('facebook_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('contact-us.contact-us') }}">

                    </a>
                    <button
                        type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        <i class="fas fa-paper-plane mr-2"></i>
                        {{ $contact_us ? 'Update Contact Information' : 'Submit Contact Information' }}
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
