# TailAdmin-inspired admin shell

The admin layout (`resources/views/layouts/main.blade.php`) uses a **TailAdmin 1.0.0**–style shell (sidebar, header, spacing, brand palette) while keeping **Blade**, **CoreUI/Bootstrap** for existing pages, and **RTL**.

## Reference

- Source kit: `TailAdmin-1.0.0/` (React + Vite demo in-repo for design tokens only).
- Implemented in Laravel via:
  - `resources/css/tailadmin.css` — Tailwind **components/utilities only** (`preflight: false` so Bootstrap/CoreUI are not reset).
  - `tailwind.config.js` — brand colors, shadows, z-index scale aligned with TailAdmin.
  - `resources/js/tailadmin-shell.js` — desktop sidebar collapse + mobile drawer + backdrop; persists collapse in `localStorage`.
  - `resources/views/parts/sidebar.blade.php` / `nav.blade.php` — structure and menu (Arabic labels preserved).

## Development

```bash
npm install
npm run dev
```

Run Vite in dev mode while working on Blade/CSS so `@vite` resolves hot assets.

## Production / CI

`public/build` is gitignored. Always run:

```bash
npm ci
npm run build
```

before deploy or in CI (see `.github/workflows/ci.yml`).

## Customization

- **Brand color**: edit `brand.*` in `tailwind.config.js` and rebuild.
- **Sidebar width**: `290px` / `90px` collapsed — see `resources/css/tailadmin.css` (`#ta-sidebar`, `#ta-main` margins).
