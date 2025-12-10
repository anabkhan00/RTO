@extends('admin.master_layout.index')

@section('title', 'Create Placement Opportunity')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-medium text-gray-800 mb-1">Create Placement Opportunity</h1>
            <p class="text-sm text-gray-500">Add a new industry placement opportunity</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border p-6">
            <form action="{{ route('admin.placement-opportunities.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Industry</label>
                    <select name="industry_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-brand focus:border-brand" required>
                        <option value="">Select Industry</option>
                        @foreach($industries as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Placement Slots</label>
                    <input type="number" name="total_slots" min="1" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-brand focus:border-brand" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Requirements (Optional)</label>
                    <textarea name="requirements" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-1 focus:ring-brand focus:border-brand" placeholder="Describe any specific requirements for this placement..."></textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="submit" class="bg-brand text-white px-4 py-2 rounded-md hover:bg-gold transition-colors">
                        Create Opportunity
                    </button>
                    <a href="{{ route('admin.placement-opportunities') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
