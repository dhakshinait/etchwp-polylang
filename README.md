# etchwp-polylang
Unofficial Polylang integration for EtchWP Builder. Provides a language switcher shortcode and exposes Polylang language data (post, term, and global) as Etch dynamic data for use in conditions, queries, and dynamic attributes.

Until Polylang and EtchWP offer native compatibility, this snippet allows developers to:

- Use a Polylang language switcher via shortcode
- Access the current language as **Etch Dynamic Data**
- Apply language-based **conditions, queries, classes, and attributes**
- Support single posts, pages, archives, search pages, and global layouts

---

## ✨ Features

### 1. Polylang Language Switcher Shortcode
Use Polylang’s `pll_the_languages()` safely inside Gutenberg or Etch layouts.

```text
[pll_languages]
