import ajaxRequest from "./ajax-request";

/**
 * Load post views and visitors in batches
 * @param {string} viewSelector - selector for post views elements (with data-id)
 * @param {string} visitorSelector - selector for visitor elements (with data-id)
 */
export default function postViewLoader(viewSelector, visitorSelector) {
    document.addEventListener("DOMContentLoaded", () => {
        let postViewsElements = Array.from(document.querySelectorAll(viewSelector));
        let visitorElements = Array.from(document.querySelectorAll(visitorSelector));

        if (postViewsElements.length < 1 && visitorElements.length < 1) return;

        // Map of ID -> element for postViews and visitors
        const postViewsMap = {};
        postViewsElements.forEach(el => {
            const id = el.getAttribute('data-id');
            postViewsMap[id] = el;
        });

        const visitorMap = {};
        visitorElements.forEach(el => {
            const id = el.getAttribute('data-id');
            visitorMap[id] = el;
        });

        // Collect all unique IDs from both sets
        const allIds = Array.from(new Set([...Object.keys(postViewsMap), ...Object.keys(visitorMap)]));

        // Batch size
        const BATCH_SIZE = 8;

        for (let i = 0; i < allIds.length; i += BATCH_SIZE) {
            const batchIds = allIds.slice(i, i + BATCH_SIZE);

            // Align elements per batch: if no element exists for ID, put null
            const postViewsBatch = batchIds.map(id => postViewsMap[id] || null);
            const visitorBatch = batchIds.map(id => visitorMap[id] || null);

            // Send AJAX
            ajaxRequest(
                'getviews',
                {
                    ids: batchIds.join(','),
                    nonce: site_info.nonce
                },
                insertPostViews,
                [postViewsBatch, visitorBatch]
            );
        }
    }); 
}

function insertPostViews(response, postViewsElements, visitorElements) {
    // Parse string response if needed
    if (typeof response === 'string') {
        response = JSON.parse(response);
    }

    // Handle server error
    if (!response.success) {
        console.error(response.data?.message || 'Unknown AJAX error');
        return;
    }

    const data = response.data;

    if (!Array.isArray(data)) {
        console.error('Invalid data format', data);
        return;
    }

    // --- Update post views ---
    for (let i = 0; i < data.length; i++) {
        const el = postViewsElements[i];
        const stat = data[i];

        if (!el || !stat) continue;

        const numberElement = el.querySelector('.number');
        if (!numberElement) continue;

        numberElement.textContent = stat.pageviews;
        el.classList.remove('opacity-0');
    }

    // --- Update visitors ---
    for (let i = 0; i < data.length; i++) {
        const el = visitorElements[i];
        const stat = data[i];

        if (!el || !stat) continue;

        const numberElement = el.querySelector('.number');
        if (!numberElement) continue;

        numberElement.textContent = stat.visitors;
        el.classList.remove('opacity-0');
    }
}


