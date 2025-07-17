// Search suggestions functionality
$(document).ready(function() {
    console.log('Search suggestions script loaded');
    
    let searchTimeout;
    const searchInput = $('#searchInput');
    const searchSuggestions = $('#searchSuggestions');
    
    console.log('Search input element found:', searchInput.length);
    console.log('Search suggestions element found:', searchSuggestions.length);

    if (searchInput.length === 0 || searchSuggestions.length === 0) {
        console.error('Search elements not found!');
        return;
    }

    // Search suggestions
    searchInput.on('input', function() {
        const query = $(this).val().trim();
        console.log('Search input:', query);
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            searchSuggestions.hide().empty();
            return;
        }

        // Debounce search
        searchTimeout = setTimeout(function() {
            console.log('Making AJAX request for:', query);
            $.ajax({
                url: '/search/suggestions',
                method: 'GET',
                data: { q: query },
                success: function(suggestions) {
                    console.log('Received suggestions:', suggestions);
                    displaySuggestions(suggestions, query);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', xhr.responseText, status, error);
                    searchSuggestions.hide().empty();
                }
            });
        }, 300);
    });

    // Display suggestions
    function displaySuggestions(suggestions, query) {
        console.log('Display suggestions called with:', suggestions, query);
        searchSuggestions.empty();
        
        if (suggestions.length === 0) {
            console.log('No suggestions, hiding dropdown');
            searchSuggestions.hide();
            return;
        }

        console.log('Creating suggestions HTML');
        suggestions.forEach(function(suggestion) {
            const highlightedText = highlightMatch(suggestion, query);
            const isCategory = suggestion.includes('(Danh mục)');
            const cleanSuggestion = suggestion.replace(' (Danh mục)', '');
            const icon = isCategory ? 'fas fa-folder' : 'fas fa-search';
            const type = isCategory ? 'Danh mục' : 'Sản phẩm';
            
            const item = $(`
                <div class="search-suggestion-item" data-suggestion="${cleanSuggestion}">
                    <i class="${icon} suggestion-icon"></i>
                    <span class="suggestion-text">${highlightedText.replace(' (Danh mục)', '')}</span>
                    <span class="suggestion-type">${type}</span>
                </div>
            `);
            searchSuggestions.append(item);
        });

        console.log('Showing suggestions dropdown');
        searchSuggestions.show();
    }

    // Highlight matching text
    function highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<strong>$1</strong>');
    }

    // Handle suggestion click
    $(document).on('click', '.search-suggestion-item', function() {
        const suggestion = $(this).data('suggestion');
        searchInput.val(suggestion);
        searchSuggestions.hide();
        searchInput.closest('form').submit();
    });

    // Hide suggestions when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-area').length) {
            searchSuggestions.hide();
        }
    });

    // Handle keyboard navigation
    searchInput.on('keydown', function(e) {
        const items = $('.search-suggestion-item');
        const activeItem = $('.search-suggestion-item.active');
        
        if (items.length === 0) return;

        switch(e.keyCode) {
            case 38: // Up arrow
                e.preventDefault();
                if (activeItem.length === 0) {
                    items.last().addClass('active');
                } else {
                    activeItem.removeClass('active').prev().addClass('active');
                    if ($('.search-suggestion-item.active').length === 0) {
                        items.last().addClass('active');
                    }
                }
                break;
                
            case 40: // Down arrow
                e.preventDefault();
                if (activeItem.length === 0) {
                    items.first().addClass('active');
                } else {
                    activeItem.removeClass('active').next().addClass('active');
                    if ($('.search-suggestion-item.active').length === 0) {
                        items.first().addClass('active');
                    }
                }
                break;
                
            case 13: // Enter
                if (activeItem.length > 0) {
                    e.preventDefault();
                    activeItem.click();
                }
                break;
                
            case 27: // Escape
                searchSuggestions.hide();
                break;
        }
    });

    // Add active hover effect for keyboard navigation
    $(document).on('mouseenter', '.search-suggestion-item', function() {
        $('.search-suggestion-item').removeClass('active');
        $(this).addClass('active');
    });
});
