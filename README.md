# ExamplePress Demo

A disposable companion plugin that demonstrates the ExamplePress routing contract, namespace handoff, and template block pattern. Install it, inspect the source, then scaffold your own.

## What It Does

When activated, this plugin registers three routes with the ExamplePress router and completely bypasses the theme's default `get-started` fallback template. Each route is rendered by its own [Blockstudio](https://github.com/inline0/blockstudio) template block:

| Route | Condition | Template Block | URL |
|-------|-----------|----------------|-----|
| **Front** | `is_front_page() \|\| is_home()` | `examplepress-demo/template-front` | `/` |
| **Single** | `is_singular()` | `examplepress-demo/template-single` | `/hello-world/` |
| **404** | `is_404()` | `examplepress-demo/template-404` | `/nonexistent/` |

The front page shows a live before/after comparison of the namespace handoff &mdash; which namespace, route, and block are rendering &mdash; so you can see exactly what changes when a companion plugin takes over.

## Requirements

- WordPress 6.9+
- PHP 8.4+
- [ExamplePress Theme](https://github.com/webmultipliers/examplepress-theme) (active)
- [Blockstudio](https://github.com/inline0/blockstudio) 7.1+

## Installation

1. Install via the **ExamplePress settings page** in your WordPress admin, or download the latest release from [Releases](https://github.com/webmultipliers/examplepress-theme-demo/releases).
2. Activate the plugin.
3. Visit your site &mdash; the demo templates are now live.

## Project Structure

```
examplepress-demo.php        # Plugin bootstrap: route registration, data enrichment, Blockstudio init
examplepress.json             # App manifest: metadata, routing config, Troy placeholders
app/
  templates/
    front/                    # Front page template block
      block.json
      index.php
      style.inline.scss
    single/                   # Single post template block
      block.json
      index.php
      style.inline.scss
    404/                      # 404 page template block
      block.json
      index.php
      style.inline.scss
.github/
  workflows/
    release.yml               # CI/CD: PR verification, preflight, build & release
```

## How It Works

1. **Route registration** &mdash; `examplepress_register_route_origin()` declares the routes this plugin owns and the conditions under which they match. Priority (default `10`) determines which plugin wins when multiple plugins claim the same route.

2. **Route data enrichment** &mdash; The `examplepress_route_data` filter attaches extra context (e.g. the queried post object for single routes) before the template renders.

3. **Template rendering** &mdash; Blockstudio compiles each template folder (`block.json` + `index.php` + scoped SCSS) into a WordPress block. The ExamplePress router resolves the current request, picks the matching origin, and renders the corresponding block.

## Next Steps

This plugin is meant to be studied and removed. When you're ready to build your own:

1. Open the **Build** tab in ExamplePress settings.
2. Scaffold a new companion plugin (uses the [examplepress-theme-app](https://github.com/webmultipliers/examplepress-theme-app) template).
3. Define your routes in `examplepress.json`, create your template blocks, and deactivate this demo.

## ExamplePress Ecosystem

| Repository | Role |
|------------|------|
| [examplepress-theme](https://github.com/webmultipliers/examplepress-theme) | Presentation layer &mdash; single FSE template, router block dispatch, and Blockstudio integration |
| [examplepress-mu](https://github.com/webmultipliers/examplepress-mu) | MU Kernel &mdash; routing engine, feature registry, admin dashboard, config pipeline, governance, and REST API |
| [examplepress-theme-app](https://github.com/webmultipliers/examplepress-theme-app) | Template repo for scaffolding new companion plugins |
| **examplepress-theme-demo** | **This repo** &mdash; reference companion plugin demonstrating the routing contract |
| [examplepress-theme-update](https://github.com/webmultipliers/examplepress-theme-update) | Dedicated updater &mdash; delivers theme releases via GitHub to the WordPress updater |
| [examplepress-troy-bridge](https://github.com/webmultipliers/examplepress-troy-bridge) | Bridge plugin &mdash; provisions companion plugins on Troy Server from the ExamplePress Build tab |
| [Troy](https://github.com/sybrew/troy) | Plugin distribution platform &mdash; host your own private WordPress plugin repository |
| [Blockstudio](https://github.com/inline0/blockstudio) | Block framework &mdash; zero-build, filesystem-based WordPress block development |

## Releases

Releases are automated via GitHub Actions. Pushing to `main` creates a stable release; pushing to `development` creates a pre-release. Each release includes a bundled ZIP and an `updates.json` manifest compatible with the ExamplePress update system.

## License

See the [ExamplePress Theme](https://github.com/webmultipliers/examplepress-theme) repository for license details.
