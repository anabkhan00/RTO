@extends('admin.master_layout.index')
@section('page-title', 'Profile')
@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-brand mb-6">Profile Settings</h2>

        <form method="POST" action="/profile" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                <div>
                    <label class="block text-sm font-medium text-brand">Role</label>
                    <input type="text" value="{{ ucfirst($user->role) }}" readonly
                        class="w-full border border-gray-300 bg-gray-100 text-sm rounded-md p-3" />
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-brand mb-4">Change Password</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-brand">New Password</label>
                        <input type="password" name="password" placeholder="Enter new password (leave blank to keep current)"
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
    </div>
@endsection
