@extends('rto.master_layout.index')
@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-brand mb-6">Profile Settings</h2>

        <form method="POST" action="/profile" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($user->role === 'rto')
                    <div>
                        <label class="block text-sm font-medium text-brand">Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" value="{{ $user->code }}" placeholder="Enter RTO Code" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-brand">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ $user->name }}" placeholder="Enter Name" required
                        class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ $user->email }}" placeholder="Enter Email" required
                        class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Phone</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" placeholder="Enter Phone Number"
                        class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                </div>

                @if ($user->role === 'rto')
                    <div>
                        <label class="block text-sm font-medium text-brand">Contact Person <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="contact_person" value="{{ $user->contact_person }}"
                            placeholder="Enter Contact Person" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Website</label>
                        <input type="url" name="website" value="{{ $user->website }}" placeholder="Enter Website URL"
                            class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>
                @endif

                @if ($user->role === 'user')
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-brand">Address</label>
                        <textarea name="address" placeholder="Enter Address" rows="3"
                            class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200">{{ $user->address }}</textarea>
                    </div>
                @endif
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-brand mb-4">Change Password</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-brand">New Password</label>
                        <input type="password" name="password"
                            placeholder="Enter new password (leave blank to keep current)"
                            class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Confirm new password"
                            class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-8 py-3 bg-brand text-white rounded-md hover:bg-gold transition-colors">
                    Update Profile
                </button>
            </div>
        </form>

        <!-- Uploaded Documents Section -->
        @if ($user->role === 'rto' && $user->rtoDocuments->count() > 0)
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-medium text-brand mb-4">Uploaded Documents</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid gap-3">
                        @foreach ($user->rtoDocuments as $document)
                            <div class="flex items-center justify-between bg-white p-3 rounded border">
                                <div class="flex items-center gap-3">
                                    <i class="bi bi-file-earmark-text text-brand text-lg"></i>
                                    <div>
                                        <p class="font-medium text-sm text-brand">{{ $document->label }}</p>
                                        <p class="text-xs text-gray-500">{{ $document->file_name }}
                                            ({{ number_format($document->file_size / 1024, 1) }} KB)
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                                    class="text-blue-500 hover:text-blue-700">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Document Upload Section -->
        <div class="mt-8 border-t pt-6">
            <h3 class="text-lg font-medium text-brand mb-4">Upload Documents</h3>

            <form method="POST" action="/profile/documents" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div id="documentRows">
                    <div class="document-row grid grid-cols-12 gap-3 items-center mb-4">
                        <!-- Document Label -->
                        <div class="col-span-5">
                            <label class="block text-sm font-medium text-brand mb-1">Document Label</label>
                            <input type="text" name="labels[]" placeholder="Enter document label" required
                                class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft
                focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                        </div>

                        <!-- Document File -->
                        <div class="col-span-5">
                            <label class="block text-sm font-medium text-brand mb-1">Document File</label>
                            <input type="file" name="documents[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required
                                class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft
                focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                        </div>

                        <!-- Remove Button -->
                        <div class="col-span-2 flex justify-center">
                            <button type="button" onclick="removeDocumentRow(this)"
                                class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition"
                                style="display: none;">
                                <i class="bi bi-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>


                <div class="flex justify-between items-center">
                    <button type="button" onclick="addDocumentRow()"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 text-sm">
                        + Add Another Document
                    </button>

                    <button type="submit" class="px-6 py-2 bg-brand text-white rounded-md hover:bg-gold">
                        Upload Documents
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addDocumentRow() {
            const container = document.getElementById('documentRows');
            const newRow = document.createElement('div');
            newRow.className = 'document-row grid grid-cols-12 gap-3 items-center mb-4';

            newRow.innerHTML = `
            <div class="col-span-5">
                <label class="block text-sm font-medium text-brand mb-1">Document Label</label>
                <input type="text" name="labels[]" placeholder="Enter document label" required
                    class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft
                    focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
            </div>

            <div class="col-span-5">
                <label class="block text-sm font-medium text-brand mb-1">Document File</label>
                <input type="file" name="documents[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required
                    class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft
                    focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
            </div>

            <div class="col-span-2 flex justify-center">
                <button type="button" onclick="removeDocumentRow(this)"
                    class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                    <i class="bi bi-trash text-sm"></i>
                </button>
            </div>
        `;

            container.appendChild(newRow);
            updateRemoveButtons();
        }

        function removeDocumentRow(button) {
            const row = button.closest('.document-row');
            row.remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.document-row');
            rows.forEach((row, index) => {
                const removeBtn = row.querySelector('button[onclick*="removeDocumentRow"]');
                // Hide remove button for the first row only
                removeBtn.style.display = index === 0 ? 'none' : 'block';
            });
        }

        // Run on page load to hide the first button
        document.addEventListener('DOMContentLoaded', updateRemoveButtons);
    </script>
@endsection
