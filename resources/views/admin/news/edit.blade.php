@extends('layouts.app')

@section('content')

        <!-- Page Content -->
        <main>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Article</h2>

                    <form id="articleForm" class="space-y-6" action="{{ route('news.update-news', encrypt($news->id)) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Row 1: Topic and Image -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Topic Field -->
                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                                    Topic
                                </label>
                                <input type="text" id="title" name="title" value="{{ old('topic', $news->title ?? '') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 outline-none"
                                    placeholder="Enter article topic">
                                @error('topic')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Upload Field -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Image
                                </label>
                                <input type="file" id="image" name="image" accept="image/*"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Show current image if exists -->
                            @if(isset($news->image) && $news->image)
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                    <img src="{{ asset('storage/newsimage/' . $news->image) }}" alt="Current image" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                                Body
                            </label>
                            <textarea id="body" name="body" rows="8" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 outline-none resize-vertical"
                                placeholder="Enter article content...">{{ old('body', $news->body ?? '') }}</textarea>
                            @error('body')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Row 4: Buttons -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6">
                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
                                Update Article
                            </button>

                            <a href="{{ route('news.news') }}"
                                class="w-full bg-gray-300 text-gray-700 py-3 px-6 rounded-lg font-medium hover:bg-gray-400 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 text-center inline-block">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Add interactive feedback for inputs
                const inputs = document.querySelectorAll('input, textarea');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('ring-2', 'ring-blue-200');
                    });

                    input.addEventListener('blur', function() {
                        this.parentElement.classList.remove('ring-2', 'ring-blue-200');
                    });
                });

                // Optional: Add image preview functionality
                document.getElementById('image').addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Create or update image preview
                            let preview = document.getElementById('imagePreview');
                            if (!preview) {
                                preview = document.createElement('img');
                                preview.id = 'imagePreview';
                                preview.className = 'w-32 h-32 object-cover rounded-lg mt-2';
                                document.querySelector('input[name="image"]').parentElement.appendChild(preview);
                            }
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                });
            </script>
        </main>

@endsection
