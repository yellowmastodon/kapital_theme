# Kapital Theme

**Kapital Theme** is a custom WordPress theme for magazine Kapitál.

---

## Features

- **Custom Post Types:**  
  Events with date, recording, and gallery support.
- **Custom Block Patterns:**  
  Predefined layouts for recordings, galleries, and event content.
- **Advanced Filtering:**  
  Filter events by year, recordings, and more.
- **Responsive Design:**  
  Mobile-first, Bootstrap 5-based layout.
- **Custom Templates:**  
  Archive, single, and footer templates tailored for events.
- **SVG & Image Helpers:**  
  Functions for responsive images and SVG optimization.
- **Editor Enhancements:**  
  Custom block modifications and patterns for the block editor.
- **WooCommerce Support:**  
  Basic compatibility for shop and product pages.
- **SCSS Boilerplate:**  
  Semantically named files, organized by folders, all compiled into a single file.
- **WAI-ARIA Role Ready:**  
  Accessibility best practices included.
- **Localised Strings:**  
  Translation-ready with the `kapital` text domain.

---

## Folder Structure

```
kapital_theme/
│
├── assets/                # SCSS, JS, images
├── block-editor/          # Custom block modifications
│   └── src/
├── includes/              # PHP helpers and logic
├── patterns/              # Block pattern registration
├── template-parts/        # Template partials
├── woocommerce/           # WooCommerce overrides
├── functions.php
├── style.css
├── archive-event.php
├── single-event.php
└── ...
```

---

### Using Laravel Mix (for SCSS/JS assets)

Install dependencies if you haven't yet:

```sh
npm install
```

Then run:

| Tasks                     |                                                                    |
|---------------------------|--------------------------------------------------------------------|
| `npx mix watch`           | *watch assets for changes*                                         |
| `npx mix --production`    | *compile for production*                                           |

---

## Customization

- **SCSS Variables:**  
  Modify `assets/styles/_variables.scss` for colors, spacing, and breakpoints.
- **Block Patterns:**  
  Edit or add new patterns in `patterns/register_patterns.php`.
- **PHP Functions:**  
  Extend or override helpers in `includes/`.

---

## Translation

- Theme is translation-ready.
- Use the `kapital` text domain for all translations.

---

## Credits

This theme is based on the [barebones](https://github.com/benchmarkstudios/barebones) WordPress boilerplate by Benchmark Studios, with significant customizations for event and cultural websites.  
Includes code and structure inspired by the original barebones theme:

> A lightweight and skeletal WordPress boilerplate theme for HTML5 and beyond. There's lots of these out there but most themes include lots of bloat and files which you might not necessarily need, so we thought we would create our own which is great as a starting point with powerful features to encourage rapid development for most projects.

---

## License

This theme is licensed under the [MIT License](LICENSE) or WordPress GPL, as appropriate.

---