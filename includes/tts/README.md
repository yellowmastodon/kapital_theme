theme/
├── functions.php                         //include tts
├── block-editor/src/custom-editor-scripts/
|   └── ButtonTTS.js                      // Gutenberg block editor button
└── includes/
    └── tts/
        ├── class-tts-loader.php          // Main loader/bootstrapper
        ├── class-tts-settings.php        // Your current settings class
        ├── class-tts-meta.php            // Post meta registration & handling
        ├── class-tts-ajax.php            // AJAX handlers
        ├── class-tts-api.php             // ElevenLabs API communication
        └── class-tts-rest.php            // REST API endpoint