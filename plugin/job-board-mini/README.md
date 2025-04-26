# Job Board Mini Plugin

A lightweight and responsive WordPress plugin that allows you to create, list, and filter job offers using a Custom Post Type (`job`) with dynamic REST API filtering, TailwindCSS front-end styles, and shortcode support.

---

## Features

- Custom Post Type: `job`
- Custom Meta Fields: Location, Salary, Job Type
- REST API endpoints for job listing and filtering
- Dynamic filters (Location, Salary) with Fetch API
- TailwindCSS responsive layout
- Admin-friendly with styled meta fields
- Secure input validation and nonce protection

---

## Installation

1. Clone or download the plugin into your WordPress plugins directory:

```
wp-content/plugins/job-board-mini
```

2. Activate **Job Board Mini** from the WordPress Admin > Plugins section.

3. (Optional) Visit **Settings > Permalinks** and click "Save Changes" to ensure REST API routes work properly.

---

## Usage

### 1. Shortcode: `[job_listings]`

Insert the following shortcode in any page or post:

```
[job_listings]
```

### 2. Filters (Dynamic Front-end Search)

- A dynamic filter form is integrated into the front-end (Hero Section > Filters).
- Filter by Location and/or Minimum Salary.
- Fully dynamic without page reload (via Fetch API).
- Currently loads all matching results.

---

## REST API Endpoints

| Endpoint | Description |
|----------|-------------|
| `/wp-json/job-board-mini/v1/jobs/` | Fetch jobs (supports `location`, `salary` parameters) |
| `/wp-json/job-board-mini/v1/locations/` | Fetch all unique locations available |

Example:

```
GET /wp-json/job-board-mini/v1/jobs/?location=Remote&salary=80000
```

---

## Plugin Folder Structure

```
job-board-mini/
├── job-board-mini.php          # Main plugin file
├── includes/
│   ├── post-types.php          # Registers the CPT 'job'
│   ├── meta-fields.php         # Custom meta fields (location, salary, type)
│   ├── shortcodes.php          # Shortcode `[job_listings]`
│   ├── rest-api.php            # Custom REST API endpoints
├── assets/
│   ├── css/
│   │   └── admin-style.css      
│   ├── js/
│   │   └── filter.js            # Frontend filtering logic
├── sample-data/
│   └── sample-data.json        # Optional sample jobs importer
├── README.md                   # This file
```

---

## Future Improvements

- For future developments, it is recommended to migrate the job listing functionality from `front-page.php` to a dedicated WordPress page template. This will allow full support for clean pagination using WordPress query variables and avoid limitations tied to the static front-page behavior.

---

## AI Tool Usage Declaration

During the development of this theme and plugin, AI tools such as ChatGPT were used selectively to assist with generating standard code snippets, specifically for:

- The basic structure of the Custom Post Type (`job`) registration.
- The setup of custom meta boxes and saving meta fields.
- The initial outline of the `[job_listings]` shortcode using `WP_Query`.
- The registration of custom REST API endpoints (`/jobs/` and `/locations/`).
- Basic Fetch API call structure for dynamic filtering functionality.


These snippets were used as a starting point only.  
All integration between components, project-specific adjustments, architectural decisions, performance optimizations, security validations (nonce, sanitize functions), and final implementations were reviewed, customized, and developed manually to ensure complete understanding and compliance with WordPress coding standards.

During development, GitHub Copilot was used selectively to suggest inline code comments, primarily to improve clarity and maintainability. All suggested comments were reviewed and adapted to match the actual function of the code.