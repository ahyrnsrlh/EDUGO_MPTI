/**
 * YouTube Helper Functions
 * Utility functions for handling YouTube URLs and video IDs
 */

/**
 * Extract YouTube video ID from various URL formats
 * @param {string} url - YouTube URL
 * @returns {string|null} - Video ID or null if not found
 */
function extractYouTubeVideoID(url) {
    if (!url) return null;

    // YouTube URL patterns
    const patterns = [
        // Standard watch URL: https://www.youtube.com/watch?v=VIDEO_ID
        /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/,
        // Embed URL: https://www.youtube.com/embed/VIDEO_ID
        /(?:https?:\/\/)?(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/,
        // Short URL: https://youtu.be/VIDEO_ID
        /(?:https?:\/\/)?youtu\.be\/([a-zA-Z0-9_-]{11})/,
        // Old video URL: https://www.youtube.com/v/VIDEO_ID
        /(?:https?:\/\/)?(?:www\.)?youtube\.com\/v\/([a-zA-Z0-9_-]{11})/,
    ];

    for (let pattern of patterns) {
        const match = url.match(pattern);
        if (match && match[1]) {
            return match[1];
        }
    }

    return null;
}

/**
 * Generate YouTube embed URL from video ID
 * @param {string} videoId - YouTube video ID
 * @param {object} options - Additional options
 * @returns {string} - Embed URL
 */
function generateYouTubeEmbedUrl(videoId, options = {}) {
    const baseUrl = "https://www.youtube.com/embed/";
    const params = new URLSearchParams();

    // Default parameters for better embedding
    params.set("rel", "0"); // Don't show related videos
    params.set("showinfo", "0"); // Don't show info
    params.set("modestbranding", "1"); // Modest branding

    // Add custom parameters
    if (options.autoplay) params.set("autoplay", "1");
    if (options.mute) params.set("mute", "1");
    if (options.start) params.set("start", options.start);
    if (options.end) params.set("end", options.end);

    return `${baseUrl}${videoId}?${params.toString()}`;
}

/**
 * Convert any YouTube URL to embed format
 * @param {string} url - Any YouTube URL
 * @param {object} options - Additional options
 * @returns {string|null} - Embed URL or null if invalid
 */
function convertToYouTubeEmbed(url, options = {}) {
    const videoId = extractYouTubeVideoID(url);
    if (!videoId) return null;

    return generateYouTubeEmbedUrl(videoId, options);
}

/**
 * Validate YouTube URL
 * @param {string} url - URL to validate
 * @returns {boolean} - True if valid YouTube URL
 */
function isValidYouTubeUrl(url) {
    return extractYouTubeVideoID(url) !== null;
}

/**
 * Create responsive YouTube iframe
 * @param {string} videoId - YouTube video ID
 * @param {object} options - Options for iframe
 * @returns {string} - HTML iframe string
 */
function createYouTubeIframe(videoId, options = {}) {
    const embedUrl = generateYouTubeEmbedUrl(videoId, options.params || {});
    const title = options.title || "YouTube video";
    const className = options.className || "w-100 h-100";

    return `
        <div class="ratio ratio-16x9">
            <iframe 
                src="${embedUrl}" 
                title="${title}"
                class="${className}"
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                allowfullscreen>
            </iframe>
        </div>
    `;
}

// Export functions for module systems (if needed)
if (typeof module !== "undefined" && module.exports) {
    module.exports = {
        extractYouTubeVideoID,
        generateYouTubeEmbedUrl,
        convertToYouTubeEmbed,
        isValidYouTubeUrl,
        createYouTubeIframe,
    };
}
