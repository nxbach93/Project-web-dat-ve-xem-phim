# Copilot instructions — Project (PHP / XAMPP)

This project is a small PHP web application served from XAMPP (htdocs/project). The goal of these instructions is to give an AI coding agent the precise, actionable context needed to be productive quickly.

1) Project overview
- **Doc root:** `htdocs/project` — open pages in a browser at `http://localhost/project/...` after starting XAMPP.
- **Includes & layout:** Shared header and DB connection live in `headfoot/` (see [headfoot/header.php](headfoot/header.php#L1-L40) and [headfoot/connect.php](headfoot/connect.php#L1-L10)). Many pages include `headfoot/header.php` for navigation and session handling.
- **CSS:** Global and page CSS files live at project root and per-folder (example: [rap/rap.css](rap/rap.css)).

2) Database & connections (explicit patterns)
- The canonical DB connection file is [headfoot/connect.php](headfoot/connect.php#L1-L4) — it creates a `$conn` mysqli instance and sets `utf8mb4`.
- Note: some pages create their own mysqli connection instead of including `headfoot/connect.php`. Example: [rap/rap.php](rap/rap.php#L20-L36) manually constructs a mysqli instance and runs queries. When changing DB code prefer centralizing on `headfoot/connect.php` to avoid duplicate credentials.
- The DB name discovered: `dbprojectweb` (see [headfoot/connect.php](headfoot/connect.php#L1-L4)).

3) Routing, links, and paths
- Header navigation uses absolute paths rooted at `/project` (see links in [headfoot/header.php](headfoot/header.php#L6-L18)). If you move the project or test on a different doc root, update those links consistently or convert to relative includes.
- Includes in pages commonly use relative paths (e.g., `include('../headfoot/header.php')` in [rap/rap.php](rap/rap.php#L13-L15)). Keep relative include semantics when refactoring files.

4) Patterns and conventions to preserve
- Session handling: pages rely on `$_SESSION['username']` set by auth pages; `headfoot/header.php` checks `session_status()` and displays login/logout links — preserve this pattern when refactoring authentication UI ([headfoot/header.php](headfoot/header.php#L1-L18)).
- DB access: current code uses mysqli procedural/object API and direct string interpolation for queries (see query in [rap/rap.php](rap/rap.php#L38-L44)). When changing queries, prefer prepared statements but maintain parameterization consistent with mysqli or migrate whole project to PDO in a coordinated change.
- File naming: folders represent features (e.g., `phim/`, `rap/`, `lichchieu/`). Follow folder-per-feature structure for new pages.

5) How to run & debug locally (concrete steps)
- Start XAMPP (Apache + MySQL). Confirm the DB `dbprojectweb` exists and import sample data if available.
- Visit `http://localhost/project/formTrangChu.php` or `http://localhost/project/rap/rap.php` to view pages.
- To debug PHP: enable `display_errors` in `php.ini` or use Xdebug attached to your IDE. Database credentials live in `headfoot/connect.php`.

6) Quick examples to guide changes
- To centralize DB connections: replace manual mysqli constructor in [rap/rap.php](rap/rap.php#L20-L36) with `include('../headfoot/connect.php')` and use the `$conn` instance created there.
- Example SQL pattern found: join `rap` and `qlphim` tables to show current movie at a cinema (see query in [rap/rap.php](rap/rap.php#L38-L44)). Update columns used by UI carefully (Poster paths are stored relative to project root and used as `../` in image src).

7) What not to change without coordination
- Absolute `/project` links in header — changing these affects navigation everywhere. If you must change, update all header links in [headfoot/header.php](headfoot/header.php#L6-L18).
- DB schema names and table fields (e.g., `TenPhim`, `Poster`, `IDPhim`, `TenRap`, `DiaChi`) are referenced directly across pages — ensure migrations are synchronized.

8) Where to look for examples and tests
- There are no automated tests or build steps. Use the running site as the primary verification. Check these files for canonical examples:
  - [headfoot/connect.php](headfoot/connect.php#L1-L10)
  - [headfoot/header.php](headfoot/header.php#L1-L40)
  - [rap/rap.php](rap/rap.php#L1-L120)

If anything above is unclear, or you want the file to include extra conventions (coding style, SQL sanitization rules, commit message patterns), tell me what to add and I will iterate.
