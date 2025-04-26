# Career Portal Theme

A lightweight, responsive, and clean WordPress theme developed specifically for displaying job listings using the Job Board Mini plugin. Built with TailwindCSS, fully mobile-first, and designed for fast loading and great accessibility.

---

## Features

- Custom `front-page.php` template
- Hero Section with background image and title
- Dynamic Filters for Job Listings (Location, Salary)
- Responsive Job Grid Layout
- Integrated Contact Form Section
- TailwindCSS CDN-based styling
- Mobile-First design approach
- Clean and accessible HTML structure

---

## Installation

1. Clone or download the theme into your WordPress themes directory:

```
wp-content/themes/career-portal-theme
```

2. Activate **Career Portal Theme** from the WordPress Admin > Appearance > Themes.

3. Ensure that the **Job Board Mini Plugin** is installed and activated to provide job listing functionality.

4. Set "Career Portal Theme" as your active theme.

---

## Usage

- The homepage (`front-page.php`) automatically displays:
  - Hero section with background image.
  - Job filters (Location and Salary) connected dynamically to the Job Board Mini plugin.
  - Available Job Listings using `[job_listings]` shortcode output.
  - Basic Contact Form (non-functional by default, front-end only).

- The theme uses TailwindCSS via CDN. This technology was selected for its ease in creating responsive designs and lightweight styling. The CDN approach was used due to time constraints and because the project is currently in a development stage. For production environments, it is recommended to compile TailwindCSS locally using a build process to optimize performance and load only the necessary CSS.

---


## Notes

- Responsiveness: Designed with TailwindCSS responsive classes (`sm:`, `md:`, `lg:`, etc.).
- Accessibility: Logical heading order (`<h1>`, `<h2>`, `<h3>`), semantic HTML structure with `<section>`, `<header>`, `<footer>`.
- Styling: TailwindCSS loaded via CDN using Play CDN.

---




