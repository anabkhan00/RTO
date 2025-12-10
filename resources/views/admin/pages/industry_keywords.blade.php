@extends('admin.master_layout.index')

@section('content')
    <div class="p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold" style="color: #5A5A5A;">Manage Industries</h2>
            <p class="text-sm text-gray-600 mt-1">Search and save industry keywords for placement opportunities</p>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-lg border shadow-sm p-6 mb-6">
            <h3 class="text-lg font-medium mb-4" style="color: #5A5A5A;">Search Industries</h3>
            <div class="flex gap-3">
                <input type="text" id="keywordSearch" placeholder="Enter industry name (e.g., Apollo, Healthcare)" 
                       class="flex-1 border border-gray-300 rounded-md px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                <button onclick="searchIndustries()" 
                        class="px-6 py-2.5 rounded-md text-white text-sm font-medium transition-colors"
                        style="background-color: #d4af37;"
                        onmouseover="this.style.backgroundColor='#c19b2e'" 
                        onmouseout="this.style.backgroundColor='#d4af37'">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
            <div id="searchResults" class="mt-4"></div>
        </div>

        <!-- Saved Keywords Section -->
        <div class="bg-white rounded-lg border shadow-sm p-6">
            <h3 class="text-lg font-medium mb-4" style="color: #5A5A5A;">Saved Industry Keywords</h3>
            <div id="savedKeywordsList"></div>
        </div>
    </div>

    <script>
        let editingKeywordId = null;

        function searchIndustries() {
            const keyword = document.getElementById('keywordSearch').value.trim();
            if (!keyword) {
                toastr.warning('Please enter a keyword');
                return;
            }

            fetch(`/admin/industry-keywords/search?keyword=${encodeURIComponent(keyword)}`, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                const resultsDiv = document.getElementById('searchResults');
                if (data.results && data.results.length > 0) {
                    resultsDiv.innerHTML = `
                        <div class="space-y-3">
                            ${data.results.map(result => `
                                <div class="border rounded-lg p-4 hover:border-brand transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">${result}</h4>
                                            <input type="text" 
                                                   id="notes_${result.replace(/\s+/g, '_')}" 
                                                   placeholder="Add notes (optional)" 
                                                   class="mt-2 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                                        </div>
                                        <button onclick="saveKeyword('${result.replace(/'/g, "\\'")}')" 
                                                class="ml-4 px-4 py-2 rounded-md text-white text-sm font-medium"
                                                style="background-color: #d4af37;"
                                                onmouseover="this.style.backgroundColor='#c19b2e'" 
                                                onmouseout="this.style.backgroundColor='#d4af37'">
                                            <i class="fas fa-save mr-1"></i>Save
                                        </button>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                } else {
                    resultsDiv.innerHTML = '<p class="text-gray-500 text-sm">No results found</p>';
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Failed to search industries');
            });
        }

        function saveKeyword(industryName) {
            const notesInput = document.getElementById(`notes_${industryName.replace(/\s+/g, '_')}`);
            const notes = notesInput ? notesInput.value : '';

            fetch('/admin/industry-keywords', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    keyword: document.getElementById('keywordSearch').value,
                    industry_name: industryName,
                    notes: notes
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Industry keyword saved successfully');
                    loadSavedKeywords();
                    document.getElementById('searchResults').innerHTML = '';
                    document.getElementById('keywordSearch').value = '';
                } else {
                    toastr.error(data.message || 'Failed to save keyword');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Failed to save keyword');
            });
        }

        function loadSavedKeywords() {
            fetch('/admin/industry-keywords/all', {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                const listDiv = document.getElementById('savedKeywordsList');
                if (data.keywords && data.keywords.length > 0) {
                    listDiv.innerHTML = `
                        <div class="space-y-3">
                            ${data.keywords.map(kw => `
                                <div class="border rounded-lg p-4" id="keyword_${kw.id}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">${kw.industry_name}</h4>
                                            <p class="text-sm text-gray-600 mt-1">Keyword: ${kw.keyword}</p>
                                            ${kw.notes ? `<p class="text-sm text-gray-500 mt-1">${kw.notes}</p>` : ''}
                                            <p class="text-xs text-gray-400 mt-2">Saved on ${new Date(kw.created_at).toLocaleDateString()}</p>
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            <button onclick="editKeyword(${kw.id}, '${kw.industry_name.replace(/'/g, "\\'")}', '${kw.keyword.replace(/'/g, "\\'")}', '${(kw.notes || '').replace(/'/g, "\\'")}')" 
                                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteKeyword(${kw.id})" 
                                                    class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                } else {
                    listDiv.innerHTML = '<p class="text-gray-500 text-sm">No saved keywords yet</p>';
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Failed to load saved keywords');
            });
        }

        function editKeyword(id, industryName, keyword, notes) {
            const keywordDiv = document.getElementById(`keyword_${id}`);
            keywordDiv.innerHTML = `
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <input type="text" id="edit_industry_${id}" value="${industryName}" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm font-medium mb-2 focus:ring-1 focus:ring-brand focus:border-brand">
                        <input type="text" id="edit_keyword_${id}" value="${keyword}" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-2 focus:ring-1 focus:ring-brand focus:border-brand" 
                               placeholder="Keyword">
                        <textarea id="edit_notes_${id}" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand" 
                                  placeholder="Notes" rows="2">${notes}</textarea>
                    </div>
                    <div class="flex gap-2 ml-4">
                        <button onclick="updateKeyword(${id})" 
                                class="px-3 py-1.5 rounded-md text-white text-sm"
                                style="background-color: #d4af37;"
                                onmouseover="this.style.backgroundColor='#c19b2e'" 
                                onmouseout="this.style.backgroundColor='#d4af37'">
                            Save
                        </button>
                        <button onclick="loadSavedKeywords()" 
                                class="px-3 py-1.5 bg-gray-500 text-white rounded-md text-sm hover:bg-gray-600">
                            Cancel
                        </button>
                    </div>
                </div>
            `;
        }

        function updateKeyword(id) {
            const industryName = document.getElementById(`edit_industry_${id}`).value;
            const keyword = document.getElementById(`edit_keyword_${id}`).value;
            const notes = document.getElementById(`edit_notes_${id}`).value;

            fetch(`/admin/industry-keywords/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    industry_name: industryName,
                    keyword: keyword,
                    notes: notes
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Keyword updated successfully');
                    loadSavedKeywords();
                } else {
                    toastr.error('Failed to update keyword');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Failed to update keyword');
            });
        }

        function deleteKeyword(id) {
            if (!confirm('Are you sure you want to delete this keyword?')) return;

            fetch(`/admin/industry-keywords/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Keyword deleted successfully');
                    loadSavedKeywords();
                } else {
                    toastr.error('Failed to delete keyword');
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error('Failed to delete keyword');
            });
        }

        // Load saved keywords on page load
        document.addEventListener('DOMContentLoaded', loadSavedKeywords);

        // Allow search on Enter key
        document.getElementById('keywordSearch').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchIndustries();
            }
        });
    </script>
@endsection
