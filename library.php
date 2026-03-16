<?php
defined( 'ABSPATH' ) || exit;

/* ---------------------------------------------------------
FRAMES
----------------------------------------------------------- */

// Get frame Tags
function palleon_get_frame_tags(){
    $tags = apply_filters('palleonframeTags',array(
        'grunge' => array(esc_html__('Grunge', 'palleon'), 12),
        'grunge-square' => array(esc_html__('Grunge - Square', 'palleon'), 6),
        'business' => array(esc_html__('Business', 'palleon'), 8),
        'bohemian' => array(esc_html__('Bohemian', 'palleon'), 10),
        'abstract' => array(esc_html__('Abstract', 'palleon'), 7),
        'floral' => array(esc_html__('Floral', 'palleon'), 5),
        'neon' => array(esc_html__('Neon', 'palleon'), 4),
        'winter' => array(esc_html__('Winter', 'palleon'), 3),
        'halloween' => array(esc_html__('Halloween', 'palleon'), 2),
        'cute' => array(esc_html__('Cute', 'palleon'), 7),
        'watercolor' => array(esc_html__('Watercolor', 'palleon'), 3),
        'love' => array(esc_html__('Love', 'palleon'), 2),
        'others' => array(esc_html__('Others', 'palleon'), 1),
    ));
    return $tags;
}

/* ---------------------------------------------------------
ELEMENTS
----------------------------------------------------------- */

// Get Element Tags
function palleon_get_element_tags(){
    $tags = apply_filters('palleonElementTags',array(
        'ink-brush-strokes' => array(esc_html__('Ink Brush Strokes', 'palleon'), 21, 'dark', 'no'),
        'abstract-shapes' => array(esc_html__('Abstract Shapes', 'palleon'), 52, 'dark', 'no'),
        'geometric-shapes' => array(esc_html__('Geometric Shapes', 'palleon'), 21, 'light', 'no'),
        'hand-drawn-shapes' => array(esc_html__('Hand Drawn Shapes', 'palleon'), 26, 'light', 'no'),
        'ribbons' => array(esc_html__('Ribbons', 'palleon'), 23, 'dark', 'no'),
        'moon-shapes' => array(esc_html__('Moon Shapes', 'palleon'), 15, 'dark', 'no'),
        'arrows' => array(esc_html__('Arrows', 'palleon'), 31, 'dark', 'no'),
        'thunderbolts' => array(esc_html__('Thunderbolts', 'palleon'), 22, 'light', 'no'),
        'hand-drawn-dividers' => array(esc_html__('Hand Drawn Dividers', 'palleon'), 30, 'light', 'no'),
        'dividers' => array(esc_html__('Dividers', 'palleon'), 25, 'light', 'no'),
        'quote' => array(esc_html__('Quote', 'palleon'), 12, 'light', 'no'),
        'speech-bubbles' => array(esc_html__('Speech Bubbles', 'palleon'), 41, 'dark', 'no'),
        'clouds' => array(esc_html__('Clouds', 'palleon'), 41, 'dark', 'no'),
        'weather' => array(esc_html__('Weather', 'palleon'), 71, 'light', 'no'),
        'social-media' => array(esc_html__('Social Media', 'palleon'), 55, 'light', 'no'),
        'payment' => array(esc_html__('Payment', 'palleon'), 80, 'light', 'no'),
        'crypto' => array(esc_html__('Crypto Currency', 'palleon'), 56, 'light', 'no'),
        'avatars' => array(esc_html__('Avatars', 'palleon'), 25, 'light', 'no'),
        'people' => array(esc_html__('People', 'palleon'), 43, 'light', 'no'),
        'trees' => array(esc_html__('Trees', 'palleon'), 24, 'light', 'yes'),
        'animals' => array(esc_html__('Animals', 'palleon'), 48, 'light', 'yes'),
        'vehicles' => array(esc_html__('Vehicles', 'palleon'), 16, 'light', 'yes'),
        'weapons' => array(esc_html__('Weapons', 'palleon'), 25, 'light', 'no'),
        'gifts' => array(esc_html__('Gifts', 'palleon'), 16, 'dark', 'no'),
    ));
    return $tags;
}

/* ---------------------------------------------------------
ILLUSTRATIONS
----------------------------------------------------------- */

function palleon_get_illustrations(){
    $illustrations = array('3d-modeling', '404-page-not-found', 'a-better-world', 'a-day-at-the-park', 'a-day-off', 'a-moment-to-relax', 'about-me', 'about-us-page', 'absorbed-in', 'abstract', 'accept-request', 'accept-tasks', 'access-account', 'access-denied', 'account', 'active-support', 'add-color', 'add-document', 'add-files', 'add-friends', 'add-information', 'add-notes', 'add-post', 'add-tasks', 'address', 'adjustments', 'advanced-customization', 'adventure-map', 'adventure', 'agree', 'agreement', 'ai-voice-interface', 'air-support', 'aircraft', 'alert', 'all-the-data', 'among-nature', 'amusement-park', 'analysis', 'analytics', 'analyze', 'animating', 'annotation', 'anonymous-feedback', 'apartment-rent', 'app-data', 'app-installation', 'app-wireframe', 'application', 'applications', 'appreciate-it', 'apps notifications', 'apps-2', 'apps', 'around-the-world', 'art-lover', 'art-thinking', 'art', 'articles', 'artificial-intelligence', 'artist', 'ask-me-anything', 'asset-selection', 'astronaut', 'at-home', 'at-the-park', 'at-work', 'athletes-training', 'attached-file', 'audio-conversation', 'audio-player', 'augmented-reality', 'authentication', 'autumn', 'baby', 'back-home', 'balloons', 'barbecue', 'barista', 'basketball', 'beach-day', 'bear-market', 'beer', 'before-dawn', 'begin-chat', 'best-place', 'bibliophile', 'biking', 'birthday-cake', 'birthday-girl', 'bitcoin-digital-currency', 'bitcoin-p2p', 'bitcoin', 'blank-canvas', 'blog-post', 'blog', 'blogging', 'blooming', 'body-text', 'book-lover', 'book-reading', 'booked', 'booking', 'bookmarks', 'books', 'bookshelves', 'both-sides', 'brainstorming', 'breakfast', 'breaking-obstacles', 'browser-stats', 'browsing-online', 'browsing', 'buddies', 'build-wireframe', 'build-your-home', 'building-blocks', 'building-websites', 'building', 'bull-market', 'bus-stop', 'business-analytics', 'business-chat', 'business-deal', 'business-decisions', 'business-man', 'business-plan', 'business-shop', 'business-woman-2', 'businessman', 'button-style', 'buy-house', 'by-the-road', 'cabin', 'calculator', 'calling', 'camera', 'campfire', 'camping', 'cancel', 'candidate', 'car-repair', 'card-postal', 'career-development', 'cat', 'celebration', 'certificate', 'certification', 'character-drawing', 'charts', 'chat', 'chatting-2', 'chatting', 'check-boxes', 'checking-boxes', 'checklist', 'chilling', 'choice', 'choose-card', 'choose-color', 'choose', 'choosing-house', 'chore-list', 'christmas-mode', 'circuit-board', 'circuit', 'city-driver', 'city-girl', 'city-life', 'clean-up', 'close-tab', 'cloud-docs', 'cloud-files', 'cloud-hosting', 'cloud-sync', 'cms', 'co-workers', 'co-working', 'code-inspection', 'code-review', 'code-thinking', 'code-typing', 'coding', 'coffee-break', 'coffee-time', 'coffee-with-friends', 'cohort-analysis', 'collab', 'collaborating', 'collaboration', 'collaborators', 'collecting', 'collection', 'color-palette', 'color-schemes', 'coming-home', 'community', 'complete-design', 'complete-task', 'completed-steps', 'completed-tasks', 'completed', 'completing', 'completion-progress', 'compose-music', 'composition', 'computer-apps', 'conceptual-idea', 'conference-call', 'conference-speaker', 'conference', 'confidential-letter', 'confirm', 'confirmation', 'confirmed', 'connected-world', 'connected', 'connecting-teams', 'connection', 'contact-us', 'content-creator', 'content-structure', 'content-team', 'content', 'contract', 'contrast', 'control-panel', 'conversation', 'convert', 'cookie-love', 'cooking', 'coolness', 'counting-stars', 'country-side', 'couple-love', 'couple', 'create', 'creation-process', 'creation', 'creative-draft', 'creative-experiment', 'creative-process', 'creative-team', 'creative-thinking', 'creative-woman', 'creativity', 'credit-card-payment', 'credit-card-payments', 'credit-card', 'crypto-bitcoin-flowers', 'crypto-portfolio', 'current-location', 'customer-survey', 'dark-analytics', 'dashboard', 'data-points', 'data-processing', 'data-report', 'data-trends', 'data', 'date-night', 'date-picker', 'deconstructed', 'decorate-christmas-tree', 'deliveries', 'delivery-address', 'delivery-truck', 'delivery', 'departing', 'design-components', 'design-data', 'design-feedback', 'design-inspiration', 'design-notes', 'design-objectives', 'design-process', 'design-sprint', 'design-stats', 'design-team', 'design', 'designer-girl', 'designer-life', 'designer-mindset', 'designer', 'destination', 'destinations', 'detailed-analysis', 'detailed-examination', 'detailed-information', 'details', 'dev-focus', 'dev-productivity', 'develop-app', 'developer-activity', 'development', 'devices', 'diary', 'diet', 'different-love', 'digital-artwork', 'digital-nomad', 'discoverable', 'doctors', 'dog', 'domain-names', 'done-checking', 'done', 'download', 'drag', 'dream-world', 'dreamer', 'dring-coffee', 'drone-delivery', 'drone-surveillance', 'dropdown-menu', 'duplicate', 'eating-together', 'edit-photo', 'editable', 'education', 'educator', 'eiffel-tower', 'election-day', 'electricity', 'elements', 'emails', 'empty-cart', 'empty-street', 'empty', 'energizer', 'engineering-team', 'enter', 'envelope', 'environmental-study', 'escaping', 'ether', 'ethereum', 'events', 'everyday-design', 'everyday-life', 'everywhere-together', 'exams', 'exciting-news', 'expecting', 'experience-design', 'experts', 'explore', 'exploring', 'export-files', 'factory', 'fall', 'family', 'fans', 'farm-girl', 'farming', 'fashion-blogging', 'fashion-photoshoot', 'fast-loading', 'favorite-post', 'favorite', 'favourite-item', 'features-overview', 'feedback', 'feeling-of-joy', 'feeling-proud', 'female-avatar', 'file-analysis', 'file-bundle', 'file-manager', 'file-searching', 'file-sync', 'file-synchronization', 'filing-system', 'fill-in', 'filter', 'finance', 'financial-data', 'find-the-message', 'fingerprint-login', 'finish-line', 'fireworks', 'firmware', 'fitness-stats', 'fitting-piece-2', 'fitting-pieces', 'fixing-bugs', 'floating', 'flowers', 'flying-drone', 'folder-files', 'folder', 'followers', 'following', 'font', 'for-sale', 'forgot-password', 'forming-ideas', 'forms', 'founding-team', 'freelancer', 'friends', 'fun-moments', 'functions', 'futuristic-interface', 'game-world', 'gaming', 'gardening', 'genius', 'getting-coffee', 'gift-box', 'gift-card', 'gift', 'gifts', 'goals', 'going-offline', 'going-up', 'golden-gate-bridge', 'golf', 'gone-shopping', 'good-doggy', 'good-team', 'grades', 'grand-slam', 'gravitas', 'greek-freak', 'grid-design', 'groceries', 'group-chat', 'group-hangout', 'group-selfie', 'group-video', 'growth-analytics', 'growth-curve', 'hacker-mind', 'hacker-mindset', 'halloween', 'hamburger', 'hang-out', 'happy-announcement', 'happy-birthday', 'happy-feeling', 'happy-music', 'happy-new-year', 'happy-news', 'happy-women-day', 'happy', 'having-fun', 'healthy-habit', 'healthy-lifestyle', 'healthy-options', 'heatmap', 'heavy-box', 'hello', 'helpful-sign', 'high-five', 'hiking', 'hire', 'hologram', 'home-cinema', 'home-run', 'home-screen', 'home-settings', 'hooked', 'hot-beverage', 'house-searching', 'ice-cream', 'icon-design', 'ideas-flow', 'ideas', 'ideation', 'image-focus', 'image-folder', 'image-options', 'image-post', 'image-upload', 'image-viewer', 'images', 'imagination', 'in-love', 'in-no-time', 'in-progress', 'in-real-life', 'in-sync', 'in-the-office', 'in-the-zone', 'in-thought', 'inbox-cleanup', 'indoor-bike', 'influencer', 'information-tab', 'injured', 'innovative', 'insert-block', 'insert', 'inspection', 'inspiration', 'instant-analysis', 'instant-information', 'instant-support', 'intense-feeling', 'interior-design', 'internet-on-the-go', 'interview', 'into-the-night', 'invest', 'investing', 'investment-data', 'investment', 'investor-update', 'jagging', 'jewelleries', 'job-hunt', 'job-offers', 'join', 'journey', 'joyride', 'junior-soccer', 'just-browsing', 'key-points', 'knowledge', 'landing-page', 'landing', 'landscape-mode', 'landscape-photographer', 'late-at-night', 'launch-day', 'launching', 'learning-sketching', 'learning', 'light-the-fire', 'lightbulb-moment', 'like-dislike', 'like-post', 'link', 'live-collaboration', 'live-photo', 'living', 'load-more', 'location-search', 'location-tracking', 'logic', 'login', 'logo-design', 'lost', 'love-is-in-the-air', 'love-it', 'loving-it', 'loving-story', 'mail', 'mailbox', 'maintenance', 'make-it-rain', 'maker-launch', 'making-art', 'male-avatar', 'manage-chats', 'map-dark', 'map', 'marketing', 'mathematics', 'media-player', 'medical-care', 'medical-research', 'meditating', 'meditation', 'meet-the-team', 'meeting', 'mello', 'memory-storage', 'mention', 'message-sent', 'messaging-2', 'messaging-app', 'messaging-fun', 'messaging', 'messenger', 'metrics', 'mic-drop', 'min-map', 'mindfulness', 'mobila-marketing', 'mobile-analystics', 'mobile-analytics', 'mobile-app-layout', 'mobile-application', 'mobile-apps', 'mobile-browsers', 'mobile-content', 'mobile-development', 'mobile-devices', 'mobile-encryption', 'mobile-feed', 'mobile-images', 'mobile-inbox', 'mobile-interface', 'mobile-life', 'mobile-messages', 'mobile-pay', 'mobile-payments', 'mobile-photos', 'mobile-posts-2', 'mobile-posts', 'mobile-profile', 'mobile-prototyping', 'mobile-search', 'mobile-site', 'mobile-testing', 'mobile-user', 'mobile-ux', 'mobile-web', 'mobile-wireframe', 'modern-art', 'modern-design', 'modern-life', 'modern-professional', 'modern-woman', 'moment-to-remember', 'moments', 'monthly-users', 'moonlight', 'mornings', 'movie-night', 'moving-forward', 'moving', 'multitasking', 'my-answer', 'my-app', 'my-code-snippets', 'my-current-location', 'my-documents', 'my-feed', 'my-files', 'my-location', 'my-notifications', 'my-password', 'my-personal-files', 'my-universe', 'my-website', 'nakamoto', 'nature-benefits', 'nature-fun', 'nature-on-screen', 'nature', 'navigation', 'navigator', 'neighbors', 'new-entries', 'new-ideas', 'new-message', 'new-notifications', 'new-year-2025', 'newsletter', 'newspaper', 'next-option', 'next-tasks', 'no-data', 'not-found', 'note-list', 'notebook-2', 'notebook', 'noted', 'notes', 'notifications', 'notify', 'nuxt-js', 'off-road', 'office-snack', 'omega', 'on-the-office', 'on-the-way', 'onboarding', 'online-ad', 'online-art', 'online-article', 'online-articles', 'online-banking', 'online-calendar', 'online-chat', 'online-collaboration', 'online-connection', 'online-cv', 'online-dating', 'online-discussion', 'online-everywhere', 'online-groceries', 'online-information', 'online-learning', 'online-media', 'online-message', 'online-messaging', 'online-organizer', 'online-party', 'online-payments', 'online-posts', 'online-reading', 'online-resume', 'online-shopping', 'online-stats', 'online-test', 'online-transactions', 'online-video', 'online-wishes', 'online-world', 'online', 'open-notes', 'open-source', 'opened-tabs', 'opened', 'opinion', 'optimize-image', 'options', 'order-a-car', 'order-confirmed', 'order-delivered', 'order-flowers', 'order-ride', 'ordinary-day', 'organize-photos', 'organize-resume', 'organizing-projects', 'os-upgrade', 'our-neighborhood', 'our-solution', 'outdoor-adventure', 'outdoor-party', 'outdoors', 'outer-space', 'pair-programming', 'pancakes', 'partying', 'passing-by', 'pay-online', 'payments', 'pen-tool', 'people-search', 'people', 'performance-overview', 'persentages', 'personal-data', 'personal-documents', 'personal-email', 'personal-file', 'personal-finance', 'personal-goals', 'personal-info', 'personal-information', 'personal-notebook', 'personal-opinions', 'personal-settings', 'personal-site', 'personal-text', 'personal-trainer', 'personal-training', 'personal-website', 'personalization', 'pet-adoption', 'phone-call', 'photo-album', 'photo-session', 'photo-sharing', 'photo', 'photocopy', 'photograph', 'photos', 'pic-profile', 'picture', 'pie-chart', 'pie-graph', 'pilates', 'pitching', 'placeholders', 'plain-credit-card', 'play-time', 'playful-cat', 'playing-cards', 'playing-fetch', 'playing-golf', 'playlist', 'pleasant-surprise', 'podcast-audience', 'podcast-listener', 'podcast', 'polaroid', 'portfolio-feedback', 'portfolio-update', 'portfolio-website', 'portfolio', 'positive-attitude', 'post-2', 'post-online', 'post', 'posting-photo', 'posts', 'powerful-superhero', 'predictive-analytics', 'preferences-popup', 'preferences', 'presentation', 'press-play', 'pride', 'prioritise', 'private-data', 'process', 'processing-thoughts', 'processing', 'product-explainer', 'product-iteration', 'product-photography', 'product-teardown', 'product-tour', 'professional-card', 'professor', 'profile-data', 'profile-details', 'profile-image', 'profile-pic', 'profile', 'programmer', 'programming', 'progress-data', 'progress-indicator', 'progress-overview', 'progressive-app', 'project-complete', 'project-completed', 'project-feedback', 'project-team', 'projections', 'prototyping-process', 'proud-coder', 'proud-self', 'public-discussion', 'publish-article', 'publish-new-post', 'publishing-post', 'pull-request', 'pumpkin', 'pure-love', 'push-notifications', 'quality-time', 'questions', 'quick-chat', 'quiet-street', 'quiet-town', 'quitting-time', 'quiz', 'random-thoughts', 'react', 'read-notes', 'reading-2', 'reading-time', 'reading', 'ready-for-waves', 'ready-to-print', 'real-time-analytics', 'real-time-collaboration', 'real-time-sync', 'receipt', 'recording', 'redesign-feedback', 'referral', 'refreshing-beverage', 'regain-focus', 'relaunch-day', 'relaxation', 'relaxed-reading', 'relaxing-at-home', 'relaxing-walk', 'reminder', 'reminders', 'remote-meeting', 'remotely', 'report', 'researching', 'respond', 'responsive', 'result', 'revenue', 'review', 'reviewed-docs', 'reviews', 'ride-a-bicycle', 'right-direction', 'right-places', 'road-sign', 'romantic-getaway', 'runner-start', 'running-wild', 'santa-visit', 'save-to-bookmarks', 'schedule', 'science', 'scientist', 'scooter', 'screen-time', 'scrum-board', 'search-app', 'search-engines', 'search', 'searching', 'season-change', 'secure-files', 'secure-login', 'secure-server', 'security-on', 'security', 'segment-analysis', 'segment', 'segmentation', 'select-house', 'select-option-2', 'select-option', 'selected-box', 'selected-options', 'selecting-team', 'selecting', 'selection-2', 'selection', 'selfie', 'send-gift', 'sentiment-analysis', 'server-cluster', 'server-push', 'server-status', 'services', 'set-preferences', 'settings-tab', 'settings', 'setup-analytics', 'setup-wizard', 'share-link', 'share-online', 'share-your-opinion', 'shared-goals', 'shared-workspace', 'sharing-articles', 'sharing-knowledge', 'shopping-app', 'shopping-bags', 'shopping', 'short-bio', 'showing-support', 'sign-in', 'sign-up-2', 'sign-up', 'signal-searching', 'site-content', 'site-stats', 'skateboard', 'slider', 'small-town', 'smart-home', 'smart-resize', 'smartphone', 'smartwatch', 'smiley-face', 'snap-the-moment', 'snow-fun', 'snow-games', 'snow-globe', 'snowman', 'social-bio', 'social-dashboard', 'social-distancing', 'social-expert', 'social-friends', 'social-girl', 'social-growth', 'social-ideas', 'social-influencer', 'social-interaction', 'social-life', 'social-media', 'social-networking', 'social-notifications', 'social-post', 'social-serenity', 'social-share', 'social-sharing', 'social-strategy', 'social-thinking', 'social-update', 'social-user', 'software-engineer', 'solution-mindset', 'sorting-thoughts', 'source-code', 'special-event', 'specs', 'speech-to-text', 'speed-test', 'split-testing', 'spooky-self', 'spread-love', 'spreadsheet', 'spreadsheets', 'stand-out', 'starlink', 'starry-window', 'stars', 'start-building', 'startup-life', 'static-website', 'statistic-chart', 'statistics', 'step-to-the-sun', 'stepping-up', 'steps', 'stock-prices', 'stranded-traveler', 'street-food', 'stripe-payments', 'studying', 'subscriber', 'subscriptions', 'suburbs', 'success-factors', 'successful-purchase', 'summer', 'sunlight', 'sunny-day', 'super-thank-you', 'super-woman', 'surfer', 'surveillance', 'survey', 'swatches', 'sweet-home', 'swing', 'swipe-options', 'swipe-profiles', 'swipe', 'switches', 'sync-files', 'sync', 'take-away-coffee', 'take-out-boxes', 'taking-notes', 'taking-selfie', 'target', 'task-list', 'task', 'tasks', 'tasting', 'teacher', 'teaching', 'team-chat', 'team-collaboration', 'team-effort', 'team-goals', 'team-page', 'team-sheet', 'team-spirit', 'team-up', 'team-work', 'team', 'teamwork', 'terms', 'testimonials', 'text-field', 'text-files', 'texting', 'the-world-is-mine', 'things-to-say', 'thought-process', 'thoughts', 'through-the-desert', 'through-the-park', 'through-the-window', 'throw-away', 'throw-down', 'time-management', 'timeline', 'to-do-list', 'to-do', 'to-the-moon', 'together', 'tourist-map', 'town', 'transfer-files', 'transfer-money', 'travel-booking', 'travel-mode', 'travel-plans', 'travelers', 'traveling', 'tree-swing', 'trends', 'trendy-interface', 'trip', 'tutor', 'tutorial-video', 'tweetstorm', 'two-factor-authentication', 'typewriter', 'unexpected-friends', 'unicorn', 'unlock', 'up-to-date', 'update', 'updated-resume', 'updates', 'upgrade', 'upload-image', 'upload', 'uploading', 'upvote', 'urban-design', 'usability-testing', 'user-flow', 'users-per-minute', 'vault', 'verified', 'version-control', 'video-call', 'video-files', 'video-game-night', 'video-games', 'video-influencer', 'video-streaming', 'video-tutorial', 'videographer', 'vintage', 'virtual-assistant', 'virtual-reality', 'visionary-technology', 'visual-data', 'visualization', 'voice-assistant', 'voice-interface', 'void', 'voting', 'vr-chat', 'wait-in-line', 'Waiting-for-you', 'walk-dreaming', 'walk-in-the-city', 'walking-around', 'walking-in-rain', 'walking-outside', 'walking-together', 'walking', 'wall-post', 'wallet', 'wandering-mind', 'warning', 'wash-hands', 'watch-app', 'watch-application', 'watch-notification', 'weather-app', 'weather-notification', 'weather', 'web-browsing', 'web-developer', 'web-development', 'web-devices', 'web-search', 'web-shopping', 'website-2', 'website-builder', 'website-setup', 'website', 'wedding', 'welcome-cats', 'welcome', 'welcoming', 'well-done', 'wilderness', 'window-shopping', 'windows', 'windy-day', 'wine-tasting', 'winners', 'winter-activities', 'winter-magic', 'winter-road', 'winter-skating', 'winter-walk', 'wireframing', 'wishlist', 'with-love', 'woman', 'work-chat', 'work-from-anywhere', 'work-in-progress', 'work-time', 'work-together', 'working-from-anywhere', 'working-late', 'working-out', 'working-remotely', 'working', 'world', 'writer', 'writing-down-ideas', 'xmas-snowman', 'yacht', 'yoga', 'youtube-tutorial', 'zoom-in');
    shuffle($illustrations);
    return $illustrations;
}

/* ---------------------------------------------------------
TEMPLATES
----------------------------------------------------------- */

// Get Template Tags
function palleon_get_template_tags(){
    $tags = apply_filters('palleonTemplateTags',array(
        'blog-banners' => esc_html__('Blog Banners', 'palleon') . ' (' . palleon_get_tag_count('blog-banners') . ')',
        'banner-ads' => esc_html__('Banner Ads', 'palleon') . ' (' . palleon_get_tag_count('banner-ads') . ')',
        'collage' => esc_html__('Collage', 'palleon') . ' (' . palleon_get_tag_count('collage') . ')',
        'quote' => esc_html__('Quote', 'palleon') . ' (' . palleon_get_tag_count('quote') . ')',
        'medium-rectangle' => esc_html__('Medium Rectangle Ads', 'palleon') . ' (' . palleon_get_tag_count('medium-rectangle') . ')',
        'leaderboard' => esc_html__('Leaderboard Ads', 'palleon') . ' (' . palleon_get_tag_count('leaderboard') . ')',
        'billboard' => esc_html__('Billboard Ads', 'palleon') . ' (' . palleon_get_tag_count('billboard') . ')',
        'facebook-ads' => esc_html__('Facebook Ads', 'palleon') . ' (' . palleon_get_tag_count('facebook-ads') . ')',
        'instagram-post' => esc_html__('Instagram Post', 'palleon') . ' (' . palleon_get_tag_count('instagram-post') . ')',
        'facebook-post' => esc_html__('Facebook Post', 'palleon') . ' (' . palleon_get_tag_count('facebook-post') . ')',
        'twitter-post' => esc_html__('Twitter Post', 'palleon') . ' (' . palleon_get_tag_count('twitter-post') . ')',
        'youtube-thumbnail' => esc_html__('Youtube Thumbnail', 'palleon') . ' (' . palleon_get_tag_count('youtube-thumbnail') . ')',
    ));
    return $tags;
}

// Get Template Count
function palleon_get_template_count(){
    $get_templates = palleon_get_templates(false);
    return count($get_templates);
}

// Get Tag Count
function palleon_get_tag_count($tag){
    $get_tags = palleon_get_templates($tag);
    return count($get_tags);
}

// Get Templates
function palleon_get_templates($tag){
    $random =  PalleonSettings::get_option('template_order', 'new');
    $templates = palleon_templates();
    if ($random == 'random') {
        shuffle($templates);
    } else if ($random == 'new') {
        $templates = array_reverse($templates);
    }
    if ($tag) {
        $filteredArray = array();
        foreach($templates as $template) {
            if (in_array($tag, $template[4])) {
                $filteredArray[] = $template;
            }
        }
        return $filteredArray;
    } else {
        return $templates;
    }
}

// Templates Array
function palleon_templates(){
    $img_url = PALLEON_SOURCE_URL . 'templates/img/';
    $json_url = PALLEON_SOURCE_URL . 'templates/json/';

    $templates = apply_filters('palleonTemplates',array(
        array("t-1", esc_html__( 'Sale Banner - Instagram Post - Discount Offer - Square - 1080x1080px', 'palleon' ), $img_url . "1.jpg", $json_url . "1.json", array('banner-ads', 'instagram-post'), 'free', $img_url . "1-large.jpg"),
        array("t-2", esc_html__( "Valentine's Day - Instagram Post - Square - 1080x1080px", 'palleon' ), $img_url . "2.jpg", $json_url . "2.json", array('instagram-post'), 'free', $img_url . "2-large.jpg"),
        array("t-3", esc_html__( "Quote - 800x600px", 'palleon' ), $img_url . "3.jpg", $json_url . "3.json", array('quote'), 'free', $img_url . "3-large.jpg"),
        array("t-4", esc_html__( "Quote - 900x600px", 'palleon' ), $img_url . "4.jpg", $json_url . "4.json", array('quote'), 'free', $img_url . "4-large.jpg"),
        array("t-5", esc_html__( "App Banner - 2000x1300px", 'palleon' ), $img_url . "5.jpg", $json_url . "5.json", array('banner-ads'), 'free', $img_url . "5-large.jpg"),
        array("t-6", esc_html__( "Fitness Banner - Medium Rectangle - 300x250px", 'palleon' ), $img_url . "6.jpg", $json_url . "6.json", array('banner-ads','medium-rectangle'), 'free', $img_url . "6-large.jpg"),
        array("t-7", esc_html__( "Fitness Banner - Medium Rectangle - 300x250px", 'palleon' ), $img_url . "7.jpg", $json_url . "7.json", array('banner-ads','medium-rectangle'), 'free', $img_url . "7-large.jpg"),
        array("t-8", esc_html__( "Digital Agency Banner - Leaderboard - 728x90px", 'palleon' ), $img_url . "8.jpg", $json_url . "8.json", array('banner-ads','leaderboard'), 'free', $img_url . "8-large.jpg"),
        array("t-9", esc_html__( "Pet Shop Banner - Billboard - 970x250px", 'palleon' ), $img_url . "9.jpg", $json_url . "9.json", array('banner-ads','billboard'), 'free', $img_url . "9-large.jpg"),
        array("t-10", esc_html__( "Summer Sale - Facebook Ad - 1200x628px", 'palleon' ), $img_url . "10.jpg", $json_url . "10.json", array('banner-ads','facebook-ads'), 'free', $img_url . "10-large.jpg"),
        array("t-11", esc_html__( "Sale Banner - Facebook Ad - 1200x628px", 'palleon' ), $img_url . "11.jpg", $json_url . "11.json", array('banner-ads','facebook-ads'), 'free', $img_url . "11-large.jpg"),
        array("t-12", esc_html__( "Christmas Sale - Instagram Post - Square - 1080x1080px", 'palleon' ), $img_url . "12.jpg", $json_url . "12.json", array('instagram-post'), 'free', $img_url . "12-large.jpg"),
        array("t-13", esc_html__( "Business Facebook Post - 940x788px", 'palleon' ), $img_url . "13.jpg", $json_url . "13.json", array('facebook-post'), 'free', $img_url . "13-large.jpg"),
        array("t-14", esc_html__( "Trending Music Video - Youtube Thumbnail - 1280x720px", 'palleon' ), $img_url . "14.jpg", $json_url . "14.json", array('youtube-thumbnail'), 'free', $img_url . "14-large.jpg"),
        array("t-15", esc_html__( "Youtube Video Thumbnail - 1280x720px", 'palleon' ), $img_url . "15.jpg", $json_url . "15.json", array('youtube-thumbnail'), 'free', $img_url . "15-large.jpg"),
        array("t-16", esc_html__( "Collage - 3 Photos - 2000x2000px", 'palleon' ), $img_url . "16.jpg", $json_url . "16.json", array('collage'), 'free', $img_url . "16-large.jpg"),
        array("t-17", esc_html__( "Kids Style Collage - 2 Photos - 2000x1300px", 'palleon' ), $img_url . "17.jpg", $json_url . "17.json", array('collage'), 'free', $img_url . "17-large.jpg"),
        array("t-18", esc_html__( "Kids Style Collage - 2 Photos - 2000x2000px", 'palleon' ), $img_url . "18.jpg", $json_url . "18.json", array('collage'), 'free', $img_url . "18-large.jpg"),
        array("t-19", esc_html__( "Stylish Collage - 3 Photos - 2000x2000px", 'palleon' ), $img_url . "19.jpg", $json_url . "19.json", array('collage'), 'free', $img_url . "19-large.jpg"),
        array("t-20", esc_html__( "Modern Collage - 2 Photos - 2000x1300px", 'palleon' ), $img_url . "20.jpg", $json_url . "20.json", array('collage'), 'free', $img_url . "20-large.jpg"),
        array("t-21", esc_html__( "Collage - 5 Photos - 2000x1000px", 'palleon' ), $img_url . "21.jpg", $json_url . "21.json", array('collage'), 'free', $img_url . "21-large.jpg"),
        array("t-22", esc_html__( "Modern Collage - 3 Photos - 2000x2000px", 'palleon' ), $img_url . "22.jpg", $json_url . "22.json", array('collage'), 'free', $img_url . "22-large.jpg"),
        array("t-23", esc_html__( "Black Friday Banner - Leaderboard - 728x90px", 'palleon' ), $img_url . "23.jpg", $json_url . "23.json", array('banner-ads','leaderboard'), 'free', $img_url . "23-large.jpg"),
        array("t-24", esc_html__( "Christmas Banner - Leaderboard - 728x90px", 'palleon' ), $img_url . "24.jpg", $json_url . "24.json", array('banner-ads','leaderboard'), 'free', $img_url . "24-large.jpg"),
        array("t-25", esc_html__( "Blog Banner - 2240x1260px", 'palleon' ), $img_url . "25.jpg", $json_url . "25.json", array('blog-banners'), 'free', $img_url . "25-large.jpg"),
        array("t-26", esc_html__( "Blog Banner - 2240x1260px", 'palleon' ), $img_url . "26.jpg", $json_url . "26.json", array('blog-banners'), 'free', $img_url . "26-large.jpg"),
        array("t-27", esc_html__( "Blog Banner - 2240x1260px", 'palleon' ), $img_url . "27.jpg", $json_url . "27.json", array('blog-banners'), 'free', $img_url . "27-large.jpg"),
        array("t-28", esc_html__( "Cafe Banner - Billboard - 970x250px", 'palleon' ), $img_url . "28.jpg", $json_url . "28.json", array('banner-ads','billboard'), 'free', $img_url . "28-large.jpg"),
        array("t-29", esc_html__( "Happy Birthday - Facebook Post - 940x788px", 'palleon' ), $img_url . "29.jpg", $json_url . "29.json", array('facebook-post'), 'free', $img_url . "29-large.jpg"),
        array("t-30", esc_html__( "Blog Banner - 2240x1260px", 'palleon' ), $img_url . "30.jpg", $json_url . "30.json", array('blog-banners'), 'free', $img_url . "30-large.jpg"),
        array("t-31", esc_html__( "Quote - Twitter Post - 1600x900px", 'palleon' ), $img_url . "31.jpg", $json_url . "31.json", array('quote','twitter-post'), 'free', $img_url . "31-large.jpg"),
        array("t-32", esc_html__( "Quote - Instagram Post - 1080x1080px", 'palleon' ), $img_url . "32.jpg", $json_url . "32.json", array('quote','instagram-post'), 'free', $img_url . "32-large.jpg"),
        array("t-33", esc_html__( "Happy Children's Day - Facebook Post - 940x788px", 'palleon' ), $img_url . "33.jpg", $json_url . "33.json", array('facebook-post'), 'free', $img_url . "33-large.jpg"),
        array("t-34", esc_html__( "Business Blog Banner - 2240x1260px", 'palleon' ), $img_url . "34.jpg", $json_url . "34.json", array('blog-banners'), 'free', $img_url . "34-large.jpg"),
        array("t-35", esc_html__( "Blog Banner - 2240x1260px", 'palleon' ), $img_url . "35.jpg", $json_url . "35.json", array('blog-banners'), 'free', $img_url . "35-large.jpg"),
        array("t-36", esc_html__( "Beauty - Leaderboard - 728x90px", 'palleon' ), $img_url . "36.jpg", $json_url . "36.json", array('leaderboard'), 'free', $img_url . "36-large.jpg"),
        array("t-37", esc_html__( "Quote - Twitter Post - 1600x900px", 'palleon' ), $img_url . "37.jpg", $json_url . "37.json", array('quote','twitter-post'), 'free', $img_url . "37-large.jpg"),
        array("t-38", esc_html__( "Blog Banner - 2240x1260px", 'palleon' ), $img_url . "38.jpg", $json_url . "38.json", array('blog-banners'), 'free', $img_url . "38-large.jpg"),
        array("t-39", esc_html__( "Banner - Twitter Post - 1600x900px", 'palleon' ), $img_url . "39.jpg", $json_url . "39.json", array('banner-ads','twitter-post'), 'free', $img_url . "39-large.jpg"),
        array("t-40", esc_html__( "Fashion Banner - Facebook Ad - 1200x628px", 'palleon' ), $img_url . "40.jpg", $json_url . "40.json", array('banner-ads','facebook-ads'), 'free', $img_url . "40-large.jpg"),
        array("t-41", esc_html__( "Real Estate - Facebook Post - 940x788px", 'palleon' ), $img_url . "41.jpg", $json_url . "41.json", array('banner-ads','facebook-post'), 'free', $img_url . "41-large.jpg"),
        array("t-42", esc_html__( "Business Banner - Instagram Post - 1080x1080px", 'palleon' ), $img_url . "42.jpg", $json_url . "42.json", array('banner-ads','instagram-post'), 'free', $img_url . "42-large.jpg"),
        array("t-43", esc_html__( "Polaroid - Instagram Post - 1080x1080px", 'palleon' ), $img_url . "43.jpg", $json_url . "43.json", array('instagram-post'), 'free', $img_url . "43-large.jpg"), 
        array("t-44", esc_html__( "Christmas - Instagram Post - 1080x1080px", 'palleon' ), $img_url . "44.jpg", $json_url . "44.json", array('instagram-post'), 'free', $img_url . "44-large.jpg"),
        array("t-45", esc_html__( "Trendy Furniture - Facebook Ads - 1200x628px", 'palleon' ), $img_url . "45.jpg", $json_url . "45.json", array('banner-ads','facebook-ads'), 'free', $img_url . "45-large.jpg"),
        array("t-46", esc_html__( "Stop War - Twitter Post - 1600x900px", 'palleon' ), $img_url . "46.jpg", $json_url . "46.json", array('twitter-post'), 'free', $img_url . "46-large.jpg"),
        array("t-47", esc_html__( "September - Twitter Post - 1600x900px", 'palleon' ), $img_url . "47.jpg", $json_url . "47.json", array('twitter-post'), 'free', $img_url . "47-large.jpg"),
        array("t-48", esc_html__( "Attractive - Youtube Thumbnail - 1280x720px", 'palleon' ), $img_url . "48.jpg", $json_url . "48.json", array('youtube-thumbnail'), 'free', $img_url . "48-large.jpg"),
        array("t-49", esc_html__( "Christmas - Facebook Post -  940x788px", 'palleon' ), $img_url . "49.jpg", $json_url . "49.json", array('facebook-post'), 'free', $img_url . "49-large.jpg"),
        array("t-50", esc_html__( "Business - Blog Banner - 2240x1260px", 'palleon' ), $img_url . "50.jpg", $json_url . "50.json", array('blog-banners'), 'free', $img_url . "50-large.jpg"),
        array("t-51", esc_html__( "New Trend - Blog Banner - 2240x1260px", 'palleon' ), $img_url . "51.jpg", $json_url . "51.json", array('blog-banners'), 'free', $img_url . "51-large.jpg"),
        array("t-52", esc_html__( "Coming Soon - Instagram Post - 1080x1080px", 'palleon' ), $img_url . "52.jpg", $json_url . "52.json", array('instagram-post'), 'free', $img_url . "52-large.jpg"),
        array("t-53", esc_html__( "The Best Investment - Instagram Post - 1080x1350px", 'palleon' ), $img_url . "53.jpg", $json_url . "53.json", array('instagram-post'), 'free', $img_url . "53-large.jpg"),
        array("t-54", esc_html__( "Premium Collection - Facebook Ads - 1200x628px", 'palleon' ), $img_url . "54.jpg", $json_url . "54.json", array('facebook-ads'), 'free', $img_url . "54-large.jpg"),
        array("t-55", esc_html__( "Explore London - Facebook Ads - 1200x628px", 'palleon' ), $img_url . "55.jpg", $json_url . "55.json", array('facebook-ads'), 'free', $img_url . "55-large.jpg"),
        array("t-56", esc_html__( "Breaking News - Twitter Post - 1600x900px", 'palleon' ), $img_url . "56.jpg", $json_url . "56.json", array('twitter-post'), 'free', $img_url . "56-large.jpg"),
        array("t-57", esc_html__( "Leader - Youtube Thumbnail - 1280x720px", 'palleon' ), $img_url . "57.jpg", $json_url . "57.json", array('youtube-thumbnail'), 'free', $img_url . "57-large.jpg"),
        array("t-58", esc_html__( "Quote - Facebook Post -  940x788px", 'palleon' ), $img_url . "58.jpg", $json_url . "58.json", array('facebook-post', 'quote'), 'free', $img_url . "58-large.jpg"),
        array("t-59", esc_html__( "Business Coach - Blog Banner - 2240x1260px", 'palleon' ), $img_url . "59.jpg", $json_url . "59.json", array('blog-banners', 'banner-ads'), 'free', $img_url . "59-large.jpg"),
        array("t-60", esc_html__( "Business Tips - Blog Banner - 2240x1260px", 'palleon' ), $img_url . "60.jpg", $json_url . "60.json", array('blog-banners'), 'free', $img_url . "60-large.jpg"),
        array("t-61", esc_html__( "Beauty Salon - Facebook Post -  940x788px", 'palleon' ), $img_url . "61.jpg", $json_url . "61.json", array('facebook-post'), 'free', $img_url . "61-large.jpg"),
        array("t-62", esc_html__( "Business Quote - Instagram Post - 1080x1080px", 'palleon' ), $img_url . "62.jpg", $json_url . "62.json", array('instagram-post', 'quote'), 'free', $img_url . "62-large.jpg"),
        array("t-63", esc_html__( "Football - Instagram Post - 1080x1080px", 'palleon' ), $img_url . "63.jpg", $json_url . "63.json", array('instagram-post'), 'free', $img_url . "63-large.jpg"),
    ));
    return $templates;
}