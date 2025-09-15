# Timberland WordPress Theme - Project Guide

## 1. Project Overview

- **Type**: WordPress Custom Theme
- **Framework**: Timber (PHP Templating)
- **Purpose**: Personal CV/Portfolio Theme
- **Key Technologies**:
  - WordPress
  - Timber
  - Advanced Custom Fields (ACF)
  - Vite (Frontend Bundling)
  - PHP
  - Twig Templates

## 2. Getting Started

### Prerequisites

- WordPress 5.9+
- PHP 7.4+
- Composer
- Node.js 16+
- Advanced Custom Fields Pro Plugin

### Installation

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Configure `config.json` for Vite environment
5. Import ACF field groups

### Development Setup

```bash
# Start Vite development server
npm run dev

# Build production assets
npm run build
```

## 3. Project Structure

```
theme/
├── assets/           # Frontend assets
│   └── dist/         # Compiled frontend files
├── blocks/           # Custom Gutenberg blocks
├── views/            # Twig template files
└── functions.php     # Theme configuration
```

## 4. Development Workflow

### Coding Standards

- PSR-2 PHP Coding Standard
- Use Timber for template rendering
- Leverage ACF for dynamic content
- Minimize direct WordPress template modifications

### Custom Block Development

1. Create block directory in `blocks/`
2. Add `block.json`
3. Implement `functions.php`
4. Create Twig template

### ACF Configuration

- Use Options Pages for global settings
- Create field groups for modular content
- Validate data using `validate_cv_data()`

## 5. Key Concepts

### Timber Context

- Extends WordPress template rendering
- Provides clean separation of logic and presentation
- Access global data via `add_to_context()`

### Custom Image Handling

- Responsive image sizes defined in `functions.php`
- Lazy loading implemented
- Custom image optimization

## 6. Common Tasks

### Adding a New Block

1. Create block directory
2. Add `block.json`
3. Create Twig template
4. Implement block registration in `acf_register_blocks()`

### Updating Theme Options

- Navigate to "My CV" in WordPress admin
- Modify sections under Personal Info, Skills, Experiences

## 7. Troubleshooting

### Common Issues

- Ensure ACF Pro is activated
- Check Vite configuration in `config.json`
- Verify PHP and Node.js versions

### Debugging

- Enable WordPress debug mode
- Check browser console
- Review Vite development logs

## 8. References

- [Timber Documentation](https://timber.github.io/docs/)
- [Advanced Custom Fields](https://www.advancedcustomfields.com/resources/)
- [Vite Documentation](https://vitejs.dev/guide/)

## 9. Performance Optimization

- Minimal default WordPress scripts loaded
- Assets managed via Vite
- Lazy loading for images
- Responsive image handling

## 10. Deployment Checklist

- Run `npm run build`
- Verify Vite production manifest
- Check ACF field exports
- Test responsive layouts
