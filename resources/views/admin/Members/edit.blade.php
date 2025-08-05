@extends('layouts.app')

@section('content')

        <!-- Page Content -->
        <main>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Edit Article</h2>


                    <form id="articleForm" class="space-y-6">
                        <!-- Row 1: Topic and Image -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Topic Field -->
                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700 mb-2">
                                    Topic
                                </label>
                                <input type="text" id="topic" name="topic" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 outline-none"
                                    placeholder="Enter article topic">
                            </div>


                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                    Image
                                </label>
                                <input type="file" id="image" name="image" accept="image/*"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>

                        <!-- Row 2: Body (Full Width) -->
                        <div>
                            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                                Body
                            </label>
                            <textarea id="body" name="body" rows="8" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 outline-none resize-vertical"
                                placeholder="Enter article content..." @if(isset($news->body))>{{ $news->body }}</textarea>
                        </div>

                        <!-- Row 3: Created Date and Remove Date -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Created Date Field -->
                            <div>
                                <label for="createdDate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Created Date
                                </label>
                                <input type="datetime-local" id="createdDate" name="createdDate" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 outline-none">
                            </div>

                            <!-- Remove Date Field -->
                            <div>
                                <label for="removeDate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Remove Date
                                </label>
                                <input type="datetime-local" id="removeDate" name="removeDate"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 outline-none">
                                <p class="text-sm text-gray-500 mt-1">Optional: Set when this article should be
                                    automatically removed</p>
                            </div>
                        </div>

                        <!-- Row 4: Buttons -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6">
                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
                                Create Article
                            </button>

                            <!-- Reset Button -->
                            <button type="reset"
                                class="w-full bg-gray-300 text-gray-700 py-3 px-6 rounded-lg font-medium hover:bg-gray-400 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                                Reset Form
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                // Set current date and time as default for created date
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
