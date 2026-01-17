# Changelog / سجل التغييرات

All notable changes to this GitHub release are documented here.

> Date: 2026-01-17 (Asia/Riyadh)

## 2026-01-17 Maintenance Patch (v1.11-git-clean-r7)

### Admin / لوحة التحكم
- Sidebar: merged “إدارة الأخبار” under a single **الأخبار** group with a nested submenu (no duplicate cards).  
  **Files:** `admin/layout/sidebar.php`
- Responsive layout: ensured admin pages render within the viewport (no overflow under the sidebar).  
  **Files:** `admin/news/polls.php`, `admin/news/questions.php`, CSS adjustments where applicable.
- News create/edit: fixed saving of `content`, `category_id`, and image columns (`featured_image`, `image_path`, `image`) using schema detection.  
  **Files:** `admin/news/create.php`, `admin/news/edit.php`, `admin/news/_news_helpers.php`

### Frontend / الواجهة
- Article page: fixed featured image rendering; added safe fallback to render first image found in article content when a featured image is missing.
  **Files:** `frontend/views/news_report.php`
- Author avatar: hidden from all news pages and sidebars; kept only in **كتّاب الرأي** section.
  **Files:** `frontend/views/partials/sidebar.php` (and any news templates that previously printed the avatar).

### Services / الخدمات
- Category service: added missing methods used by controllers and fixed compatibility of `siblingCategories()` to accept root categories (NULL parent) safely.
  **Files:** `includes/classes/Services/CategoryService.php`, `src/Services/CategoryService.php`
- Tag service: fixed `findBySlug()` to avoid selecting non-existent `description` column (schema compatibility).
  **Files:** `includes/classes/Services/TagService.php` (and/or `src/Services/TagService.php` if present).

### Controllers / الكنترولرز
- NewsController: fixed related-news query invocation (removed invalid argument passing).
  **Files:** `src/Http/Controllers/NewsController.php`

### Repository hygiene / نظافة الريبو
- Removed runtime artifacts from `storage/` (logs and ratelimit JSON) and improved `.gitignore` so placeholders remain tracked.

