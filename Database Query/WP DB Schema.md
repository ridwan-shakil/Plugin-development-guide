# WordPress Database Schema – Quick Notes

## What is the WordPress DB Schema?

The **WordPress database schema** is the structure of tables WordPress uses to store all data (content, settings, users, relationships).

WordPress follows a **few tables, many rows** philosophy. Instead of creating new tables or columns for every feature, it relies heavily on:

* Generic core tables
* Meta tables for extensibility
* Relationship tables for taxonomy

This design makes WordPress highly flexible and plugin-friendly.

---

## Core Idea: Everything is Content

The `wp_posts` table is a **generic content table**, not just for blog posts.

It stores:

* Posts (`post`)
* Pages (`page`)
* Media (`attachment`)
* Revisions (`revision`)
* Navigation items (`nav_menu_item`)
* Custom Post Types (your CPT slug)

Content type is identified using the `post_type` column.

If something has a **title, status, author, and date**, it likely belongs in `wp_posts`.

---

## Metadata System (Why Meta Tables Exist)

WordPress avoids adding new columns to core tables.

Instead, it uses **meta tables**:

* `wp_postmeta`
* `wp_usermeta`
* `wp_termmeta`
* `wp_commentmeta`

Each meta entry is stored as a **row**:

* `meta_key` → identifies the data
* `meta_value` → stores the value

### Why this works

* Unlimited, unpredictable plugin data
* No schema changes required
* Multiple meta values per object

### Tradeoff

* Meta queries are slower than direct columns
* Requires careful indexing and query design

---

## Taxonomy & Relationships

Taxonomies use **relationship-based tables**, not columns on posts.

* `wp_terms` → term names
* `wp_term_taxonomy` → taxonomy type (category, tag, custom)
* `wp_term_relationships` → links posts to terms

Categories and tags are **not stored on posts directly**.

---

## Configuration & Users

* `wp_options` → site-wide settings, flags, caches
* `wp_users` → user accounts
* `wp_usermeta` → per-user preferences
* `wp_comments` / `wp_commentmeta` → comments

---

## The Custom Table Decision Rule

Use a **custom database table** only if **ALL** of the following are true:

1. High volume of data (thousands or more rows)
2. Frequent reads/writes (AJAX, cron, frontend)
3. Complex queries (JOINs, ranges, aggregates)
4. Fixed and predictable schema

If **any one** is false → use **CPT + meta**.

---

## Practical Guideline for Plugin Developers

| Data Type         | Recommended Storage |
| ----------------- | ------------------- |
| Content-like data | `wp_posts` (CPT)    |
| Extra attributes  | Meta tables         |
| Plugin settings   | `wp_options`        |
| Per-user data     | `wp_usermeta`       |
| Logs / analytics  | Custom tables       |

---

**Key takeaway:**
WordPress prioritizes **extensibility over strict normalization**, and plugin architecture should follow this philosophy.
